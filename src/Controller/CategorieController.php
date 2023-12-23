<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\Type\CategorieType;
use App\Repository\ProductRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    /**
     * @Route("/nouvelle_categorie", name="nouvelle_categorie")
     */
    public function nouveauProduit(EntityManagerInterface $entityManager, Request $request, CategorieRepository $categorieRepository): Response
    {
        // Instancier un objet Product
        $categorie = new Categorie();
        // Si tu veux(initialiser les champs)
        $categorie->setTitre('');

        // createForm() remplace  createFormBuilder() 
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {






            $categorie = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush(); // the INSERT query
        }
        return $this->renderForm('product/new_categorie.html.twig', [
            'form' => $form,
            'categorie' => $categorie,
            'categories' => $categorieRepository->findBy([]),
            'editMode' => $categorie->getId() !== null

        ]);
    }


    /**
     * @Route("/show_categorie", name="show_categorie")
     */
    public function afficheLesCategorie(CategorieRepository $categorieRepository)
    {
        return $this->render('product/show_categories.html.twig', [
            // 'produits' => $products    (test de tri)
            'categories' => $categorieRepository->findBy([])
        ]);
    }

    /**
     * @Route("/c/edit/{id}", name="c_edit")
     */
    public function edit_categorie(Request $request, EntityManagerInterface $em,  CategorieRepository $catRepository, Categorie $cat, int $id)
    {
        $cat = $em->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $em->persist($cat); //$em->remove($product);
            $em->flush();
            $this->addFlash(
                'notice1',
                'btn vert '
            );
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
        }
        return $this->renderForm('product/edit_categories.html.twig', [
            'form' => $form,
            'id' => $cat->getId(),
            'categorie' => $cat,
            'categories' => $catRepository->findBy([]),
            'editMode' => $cat->getId() !== null
        ]);
    }

    /**
     * @Route("/show_edit_remove_category", name="show_edit_remove_category")
     */
    public function modifierOuSupprimerUneCategorie(CategorieRepository $categorieRepository)
    {
        return $this->render('product/show_edit_remove_category.html.twig', [
            'categories' => $categorieRepository->findBy([])
        ]);
    }


    /**
     * @Route("/categorie1", name="cat1")
     */
    public function afficheCategorie1(ProductRepository $productRepository)
    {
        return $this->render('product/show_categorie1.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }

    /**
     * @Route("/categorie2", name="cat2")
     */
    public function afficheCategorie2(ProductRepository $productRepository)
    {
        return $this->render('product/show_categorie2.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }
    /**
     * @Route("/categorie3", name="cat3")
     */
    public function afficheCategorie3(ProductRepository $productRepository)
    {
        return $this->render('product/show_categorie3.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }
    /**
     * @Route("/categorie4", name="cat4")
     */
    public function afficheCategorie4(ProductRepository $productRepository)
    {
        return $this->render('product/show_categorie4.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }
    /**
     * @Route("/toutes_categories", name="cat1234")
     */
    public function afficheToutesCategorieS(ProductRepository $productRepository)
    {
        return $this->render('product/show_all_categories.html.twig', [
            'produits' => $productRepository->findBy([])
        ]);
    }

    /**
     * @Route("/c/remove/{id}", name="c_remove")
     */
    public function remove(Request $request, EntityManagerInterface $em,  CategorieRepository $categorieRepository, Categorie $categorie, int $id)
    {
        $categorie = $em->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em->remove($categorie);
            $em->flush();
        }
        return $this->renderForm('product/remove_category.html.twig', [
            'form' => $form,
            'id' => $categorie->getId(),
            'category' => $categorie,
            'categories' => $categorieRepository->findBy([]),
            'removeMode' => $categorie->getId() !== null

        ]);
    }
}
