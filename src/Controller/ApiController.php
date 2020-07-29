<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Truck;
use App\Repository\TruckRepository;
use PhpParser\Node\Stmt\TryCatch;

class ApiController extends AbstractController
{
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
        $entityManager = $this->getDoctrine()->getManager();
        $max = $data["max"];
        $truck = new Truck();
        $truck->setLoaded(true);
        $truck->setMaxLoad($max);

        $products = $productRepository->getProductsData();


        if ($max <= 55 && $max > 8000) {
            $msg = array("ERROR" => "Invalid max truck load number");
            return new JsonResponse(json_decode($msg), JsonResponse::HTTP_CREATED);
        }



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

        var_dump($res);



        try {
            // first transaction
            $entityManager->persist($truck);
            $entityManager->flush();
        } catch (\Exception $e) {
            /* ... handle the exception */
            $entityManager->resetManager();
        }

        // try {
        //     $productRepository->findOneBy(["id" => $f["id"]])->setOnTruck($truck->getId());
        //     $productRepository->findOneBy(["id" => $addon["id"]])->setOnTruck($truck->getId());
        //     $entityManager->flush();
        // } catch (\Exception $e) {
        //     $entityManager->resetManager();
        // }






        var_dump(json_encode($data));
        //exit(\Doctrine\Common\Util\Debug::dump($data));
        return new JsonResponse($data, JsonResponse::HTTP_CREATED);
    }
}
