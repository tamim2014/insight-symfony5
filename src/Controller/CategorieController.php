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
        }
        return $this->renderForm('product/edit_categories.html.twig', [
            'form' => $form,
            'id' => $cat->getId(),
            'categorie' => $cat,
            'categories' => $catRepository->findBy([])
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
}
