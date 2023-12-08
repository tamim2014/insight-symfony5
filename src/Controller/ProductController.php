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
        $product->setPrice(0);
        $product->setDescription('');
        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush(); // the INSERT query
            // Redirection (suite au clic sur le bouton save)
            //return new Response('Tâche prévue: ' . $task->getTask() .'|Tâche numéro: '.$task->getId() );
        }
        return $this->renderForm('product/toutdansUnePage.html.twig', [
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
     * @Route("/editinterfaceP", name="edit_interfaceP")
     */
    //public function editinterface( ProductRepository $productRepository){ // cette signature est suiffisant pour la table sans le formulaire
    public function editinterface(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository){
        //1. Le formulaire de mise à jour
        //1.1 Relier le formulaire à l'entité correspondante
        $product = new Product(); // c faux i fo recuperer, pas instancier, mais pour recuperer il faut un service et je l'ai pas
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
        //2. La liste des produits
        // $product = $entityManager->getRepository(Product::class)->find($id);
        //return $this->render('product/edit_interface.html.twig', [
        return $this->render('product/edit_interface.html.twig', [
           // 'form' => $form ,
            'produits' => $productRepository->findBy([])
        ]);
    }


}
