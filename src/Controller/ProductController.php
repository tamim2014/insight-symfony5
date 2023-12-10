<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use Services\ProductBundle\Entity\Product; 
//use Services\ProductBundle\DependencyInjection\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{ 
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(){
        return $this->render('product/accueil.html.twig');
    }

    // On ajoute le produit(par un formulaire)  et on affiche la liste des produits dans la même page
   
    /**
     * @Route("/product", name="create_product")
     */
    public function nouveauProduit(EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository): Response
    {
        // Instancier un objet Product
        $product = new Product();
        // Si tu veux(initialiser les champs)
        $product->setName('');
        $product->setPrice(0); // placer un placeholder au lieu de Zero
        $product->setDescription('');
        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush(); // the INSERT query
        }
        return $this->renderForm('product/nouveauProduit.html.twig', [
            'form' => $form,
            'produit' => $product,
            'produits' => $productRepository->findBy([])
        ]);
    }

    /**
     * @Route("/affichetous", name="affichetous")
     */
    public function afficheTousLesProduits(ProductRepository $productRepository){
       
        return $this->render('product/affichetous.html.twig', [
            // 'produits' => $products    (test de tri)
             'produits' => $productRepository->findBy([])
        ]);
    }
   
 
 
    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function update(EntityManagerInterface $entityManager, int $id, ProductRepository $productRepository, Request $request): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException( 'No product found for id ' . $id);
        }
        // $product->setName('un clou');
        // $entityManager->flush();
        $product->setName('PC');
        $product->setPrice(3000);
        $product->setDescription('multi-processeurs');
        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(ProductType::class, $product);
        //1.2 Requette de saisie (accès en ecriture à la base)
        $form->handleRequest($request);
        //1.3 Enregistrement
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush(); // the INSERT query
        }


        // !!!!!!!!!! Attention! twig ne voit pas le formulaire si !!!!!!!!
        // !!!!!!!!!! si tu n'utilise pas renderForm()             !!!!!!!
        //return $this->render('product/edit_products.html.twig', [
        return $this->renderForm('product/edit_products.html.twig', [
            'form' => $form,
            'id' => $product->getId(),
            'product' => $product, 
            'produits' => $productRepository->findBy([])
        ]);
    }

}
