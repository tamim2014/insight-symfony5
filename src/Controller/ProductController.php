<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\Type\ProductType;

use App\Repository\ProductRepository;
use App\Repository\CategorieRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// blem pour poser un placeholder sur Entity field(pourtant ça marche pour les text field!)
//use Services\ProductBundle\Entity\Product; 
//use Services\ProductBundle\DependencyInjection\Configuration;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('product/accueil.html.twig');
    }

    // On ajoute le produit(par un formulaire)  et on affiche la liste des produits dans la même page

    /**
     * @Route("/product", name="new_product")
     */
    public function nouveauProduit(EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository): Response
    {
        // Instancier un objet Product
        $product = new Product();
        // Si tu veux(initialiser les champs)
        $product->setName('');
        $product->setPrice(0); // placer un placeholder au lieu de Zero
        $product->setDescription('');
        $product->getCategorie();
        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush(); // the INSERT query
        }
        return $this->renderForm('product/new_product.html.twig', [
            'form' => $form,
            'produit' => $product,
            'produits' => $productRepository->findBy([]),
            'editMode' => $product->getId() !== null

        ]);
    }

    /**
     * @Route("/show_products", name="show_products")
     */
    public function afficheTousLesProduits(ProductRepository $productRepository)
    {

        return $this->render('product/show_products.html.twig', [
            // 'produits' => $products    (test de tri)
            'produits' => $productRepository->findBy([])
        ]);
    }
    /**
     * @Route("/show_edit_remove_product", name="show_edit_remove_product")
     */
    public function modifierOuSupprimerUnProduit(ProductRepository $productRepository)
    {
        return $this->render('product/show_edit_remove_product.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }


    /**
     * @Route("/p/edit/{id}", name="p_edit")
     */
    public function edit(Request $request, EntityManagerInterface $em,  ProductRepository $productRepository, Product $product, int $id)
    {
        $product = $em->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em->persist($product); //$em->remove($product);
            $em->flush();
        }
        return $this->renderForm('product/edit_products.html.twig', [
            'form' => $form,
            'id' => $product->getId(),
            'product' => $product,
            'produits' => $productRepository->findBy([]),
            'editMode' => $product->getId() !== null
        ]);
    }

    /**
     * @Route("/p/remove/{id}", name="p_remove")
     */
    public function remove(Request $request, EntityManagerInterface $em,  ProductRepository $productRepository, Product $product, int $id)
    {
        $product = $em->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em->remove($product); //$em->persist($product);
            $em->flush();
        }
        return $this->renderForm('product/remove_products.html.twig', [
            'form' => $form,
            'id' => $product->getId(),
            'product' => $product,
            'produits' => $productRepository->findBy([]),
            'removeMode' => $product->getId() !== null

        ]);
    }
}
