<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

//use Doctrine\Common\Persistence\ObjectManager;
//use Doctrine\Persistence\ObjectManager; 
// ObjectManager est déprecié. Remplacé par EntityManagerInterface
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;... est deprecié depuis Symfony 5.3
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscripti")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Hasher le mot de passe avant d'enregistrer ds la BD
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            // Enregistrer ds la BD
            $manager->persist($user);
            $manager->flush();
            // return $this->redirectToRoute('connexion');
        }
        return $this->render('security/form-inscription.html.twig', [
            'form' => $form->createView(),
            'doubleCompte' => $user->getId() !== null
        ]);
    }

    // Authentification

    /**
     * @Route("/", name="login")
     */
    public function login()
    {
        return $this->render('security/form-connexion.html.twig');
    }
    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {
    }
}
