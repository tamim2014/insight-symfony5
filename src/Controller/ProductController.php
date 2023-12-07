<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{ 
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(){
        return $this->render('product/accueil.html.twig');
    }
    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        //return new Response('Saved new product with id ' . $product->getId());
        return $this->render('product/show_products.html.twig', [
            'product' => $product,
            'produits' => $productRepository->findBy([])
        ]);
    }

    /**
     * @Route("/affichetous", name="affichetous")
     */
    public function afficheTousLesProduits(ProductRepository $productRepository){
        return $this->render('product/affichetous.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);

    }
   
    /**
     * @Route("/product/edit2/{id}", name="product_show")
     */
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {  throw $this->createNotFoundException('No product found for id ' . $id);  }
        return $this->render('product/show_products.html.twig', ['product' => $product ]);
    }
 
    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function update(EntityManagerInterface $entityManager, int $id, ProductRepository $productRepository): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException( 'No product found for id ' . $id);
        }
        $product->setName('un clou');
        $entityManager->flush();

        return $this->render('product/edit_products.html.twig', [
            'id' => $product->getId(),
            'product' => $product, 
            'produits' => $productRepository->findBy([])
        ]);
    }
    /**
     * @Route("editinterface", name="edit_interface")
     */
    public function editinterface( ProductRepository $productRepository){
       // $product = $entityManager->getRepository(Product::class)->find($id);
        return $this->render('product/edit_interface.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }
}
