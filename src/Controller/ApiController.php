<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Truck;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }
    /**
     * @Route("/products", name="products")
     */
    public function showProducts(ProductRepository $productRepository)
    {
        $data = $productRepository->getProductsData();
        return $this->json($data);
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
        $license = $data["license"];
        $truck = new Truck();
        $truck->setLoaded("yes");
        $truck->setMaxLoad($max);
        $truck->setLicensePlate($license);


        

        foreach ($productRepository->findLessThanWeight($max) as $key => $value) {
            $leftOver = $max - $value->getWeight();
            $addonProduct = $productRepository->findLessThanWeight($leftOver);
            $prod = $productRepository->find($value->getId());


            $prod->setOnTruck($license);


            if ($addonProduct) {
                foreach ($addonProduct as $k => $v) {
                    $extraProd = $productRepository->find($v->getId());
                    $extraProd->setOnTruck($license);
                }
            } else {
                var_dump('nothing to add');
            }
        }


        $entityManager->persist($truck);
        $entityManager->flush();


        var_dump(json_encode($data));
        //exit(\Doctrine\Common\Util\Debug::dump($data));
        return new JsonResponse($data, JsonResponse::HTTP_CREATED);
    }
}
