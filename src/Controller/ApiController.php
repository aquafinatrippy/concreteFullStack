<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Truck;
use App\Repository\TruckRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends AbstractController
{
    private function getClosest($search, $arr)
    {
        $closest = null;
        foreach ($arr as $item) {
            if ($item["onTruck"] === NULL) {
                if ($closest === null || abs($search - $closest) > abs($item["weight"] - $search) && $item["weight"] <= $search) {
                    $closest = $item["weight"];
                    $id = $item["id"];
                }
            }
        }
        return array("number" => $closest, "id" => $id);
    }

    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/truck/{id}", name="truck")
     */
    public function truck(
        Request $request,
        $id,
        ProductRepository $productRepository
    ) {
        $res = $productRepository->findById(intval($id));
        if ($res == NULL) {
            return new JsonResponse(
                ["error" => "No data found"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        return new JsonResponse(["data" => $res], JsonResponse::HTTP_CREATED);
    }
    /**
     * @Route("/addTruck", name="addTruck", methods={"POST"})
     */
    public function addTruck(
        Request $request,
        ProductRepository $productRepository
    ) {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $max = $data["max"];
        $truck = new Truck();
        $truck->setLoaded(true);
        $truck->setMaxLoad($max);
        $products = $productRepository->getProductsData();
        $res = array();
        $transPrice = 60;
        $totalWeight = 0;

        if ($max < 1000) {
            return new JsonResponse(
                ["error" => "Minimum number is 1000"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } elseif ($max > 8000) {
            return new JsonResponse(
                ["error" => "Maximum number is 8000"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } elseif (gettype($max) != "integer") {
            return new JsonResponse(
                ["error" => "Maximum load needs to be a integer"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $i = 0;
        $z = 0;
        $total = 0;
        while ($z <= $max) {
            if ($i === 0) {
                $addon = $this->getClosest($max, $products);
                $total += $addon["number"];
                $z += $addon["number"];
                array_push($res, $this->getClosest($z, $products));
            } elseif ($i === 1) {
                $total = $max - $total;
                if ($total > $data["max"]) {
                    break;
                }
                $addon = $this->getClosest($total, $products);
                $z += $addon["number"];
                array_push($res, $this->getClosest($total, $products));
            } else {
                $total = $max - $z;
                $addon = $this->getClosest($total, $products);
                $z += $addon["number"];
                if ($z > $data["max"]) {
                    break;
                }
                array_push($res, $this->getClosest($total, $products));
            }
            $i++;
        }


        try {
            foreach ($res as $k => $v) {
                $transPrice += intval($v["number"] / 50);
                $totalWeight += $v["number"];
            }
            $truck->setTransportPrice($transPrice + count($res));
            $this->entityManager->persist($truck);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(
                ["error" => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        try {
            foreach ($res as $sRes) {
                $productRepository->findOneBy(["id" => $sRes["id"]])->setOnTruck($truck->getId());
            }
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(
                ["error" => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }


        return new JsonResponse(["truckId" => $truck->getId(), "loadedWeight" => $data, "transportTotal" => $transPrice + count($res)], JsonResponse::HTTP_CREATED);
    }
}
