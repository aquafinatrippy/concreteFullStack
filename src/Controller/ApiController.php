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

        if ($data["max"] < 1000) {
            return new JsonResponse(
                ["error" => "Minimum number is 1000"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } elseif ($data["max"] > 8000) {
            return new JsonResponse(
                ["error" => "Maximum number is 8000"],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }


        $max = $data["max"];
        $truck = new Truck();
        $truck->setLoaded(true);
        $truck->setMaxLoad($max);

        $products = $productRepository->getProductsData();



        function getClosest($search, $arr)
        {
            $closest = null;
            foreach ($arr as $item) {
                if ($closest === null || abs($search - $closest) > abs($item["weight"] - $search) && $item["weight"] <= $search && $item["onTruck"] == 0 | NULL) {
                    $closest = $item["weight"];
                    $id = $item["id"];
                }
            }
            return array("number" => $closest, "id" => $id);
        }

        $f = getClosest($max, $products);

        $sum = $max - $f["number"];
        $res = array();

        while ($max >= 0) {



            $addon = getClosest($sum, $products);
            var_dump("addon" . $addon["number"]);

            array_push($res, getClosest($max, $products));

            $max -= $f["number"];
            var_dump("sum" . $sum);

            if ($max <= $addon["number"] || 0) {
                break;
            }
            if ($sum <= 0) {
                break;
            }
        }

        //var_dump($res);



        try {
            // first transaction
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






        var_dump(json_encode($data));
        //exit(\Doctrine\Common\Util\Debug::dump($data));
        return new JsonResponse($data, JsonResponse::HTTP_CREATED);
    }
}
