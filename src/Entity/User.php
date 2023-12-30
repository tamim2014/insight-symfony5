<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

// Pour valider le champ confirm_password
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
// i fo que l'email soit unique
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="4", minMessage="Votre mot de passe doit faire au moins 4 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password")
     */
    private $password;

    // Pas d'ORM car il n'a R1 avoir avec la BD
    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas saisi le même message")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // Hashage des password: 
    // UserInterface impose d'implementer SES mthd mm si elles font R1

    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
    }
    public function getUserIdentifier()
    {
    }
    // Par contre celle-ci doit renvoyer un tableau de chaine de caractère
    // qui explique le rôle de cet utilisateur
    public function getRoles()
    {
        return ['ROLE_USER']; // user normal, pas administrateur
    }
}
