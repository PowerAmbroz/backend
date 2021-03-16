<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $f_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $l_name;

    /**
     * @ORM\ManyToOne(targetEntity=PersonLikeProduct::class, inversedBy="person_id")
     */
    private $personLikeProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getFName(): ?string
    {
        return $this->f_name;
    }

    public function setFName(string $f_name): self
    {
        $this->f_name = $f_name;

        return $this;
    }

    public function getLName(): ?string
    {
        return $this->l_name;
    }

    public function setLName(string $l_name): self
    {
        $this->l_name = $l_name;

        return $this;
    }

    public function getPersonLikeProduct(): ?PersonLikeProduct
    {
        return $this->personLikeProduct;
    }

    public function setPersonLikeProduct(?PersonLikeProduct $personLikeProduct): self
    {
        $this->personLikeProduct = $personLikeProduct;

        return $this;
    }
}
