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
     * @Route("/trucks", name="trucks")
     */
    public function showTrucks(TruckRepository $truckRepository)
    {
        $data = $truckRepository->getTrucks();
        return $this->json($data);
    }
    /**
     * @Route("/newest", name="newest")
     */
    public function getLatestOnTruck(ProductRepository $productRepository, TruckRepository $truckRepository)
    {
        // $find = $truckRepository->findBy(array(), array('id' => 'DESC'), 1, 0);
        // foreach ($find as $key => $value) {
        //     $res = $productRepository->findOnTruck($value->getLicensePlate());
        // }
        // return $this->json($res);
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

        $firstLoad = $this->getClosest($max, $products);
        $sum = $max - $firstLoad["number"];
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

        $jaak = 0;
        while ($max >= 0) {
            $addon = $this->getClosest($sum, $products);

            array_push($res, $this->getClosest($max, $products));

            $max -= $firstLoad["number"];
            if ($max <= $addon["number"] || 0) {
                break;
            }
            if ($sum <= 0) {
                break;
            }
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


        return new JsonResponse(["truckId" => $truck->getId(), "loadedWeight" => $data], JsonResponse::HTTP_CREATED);
    }
}
