<?php

namespace App\Entity;

use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(
 * fields={"username"},
 * message="Le login choisi existe déjà"
 * )
 */
class Utilisateur implements UserInterface 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=15, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 15 caractères")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=15, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 15 caractères")
     */
    private $password;

    /**
     * @Assert\Length(min=5, max=15, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 15 caractères")
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne sont pas équivalents")
     */
    private $verificationPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVerificationPassword(): ?string
    {
        return $this->verificationPassword;
    }

    public function setVerificationPassword(string $verificationPassword): self
    {
        $this->verificationPassword = $verificationPassword;

        return $this;
    }

    //Ajout des fonctions de sécurité
    public function eraseCredentials() {

    }

    public function getSalt() {

    }

    public function getRoles() {
        return [$this->roles];
    }

    public function setRoles(?string $roles): self
    {
        //De base l'utilisateur qui s'inscrit aura le role ROLE_USER
        if($roles === null) {
            $this->roles = "ROLE_USER";
        } else {
            $this->roles = $roles;
        }

        return $this;
    }
}
