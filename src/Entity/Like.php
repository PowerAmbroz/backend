<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App/Entity/Person")
     */
    private $person_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App/Entity/Product")
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="prod_id")
     */
    private $product;

    public function __construct()
    {
        $this->product_id = new ArrayCollection();
        $this->person_id = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->product_id;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPerson(): Collection
    {
        return $this->person_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getPersonId(): ?int
//    {
//        return $this->person_id;
//    }

    public function setPersonId(int $person_id): self
    {
        $this->person_id = $person_id;

        return $this;
    }

//    public function getProductId(): ?int
//    {
//        return $this->product_id;
//    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
