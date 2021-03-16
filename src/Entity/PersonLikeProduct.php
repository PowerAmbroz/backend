<?php

namespace App\Entity;

use App\Repository\PersonLikeProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonLikeProductRepository::class)
 */
class PersonLikeProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="personLikeProduct")
     */
    private $person_id;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="personLikeProduct")
     */
    private $product_id;

    public function __construct()
    {
        $this->person_id = new ArrayCollection();
        $this->product_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPersonId(): Collection
    {
        return $this->person_id;
    }

    public function addPersonId(Person $personId): self
    {
        if (!$this->person_id->contains($personId)) {
            $this->person_id[] = $personId;
            $personId->setPersonLikeProduct($this);
        }

        return $this;
    }

    public function removePersonId(Person $personId): self
    {
        if ($this->person_id->removeElement($personId)) {
            // set the owning side to null (unless already changed)
            if ($personId->getPersonLikeProduct() === $this) {
                $personId->setPersonLikeProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId(Product $productId): self
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id[] = $productId;
            $productId->setPersonLikeProduct($this);
        }

        return $this;
    }

    public function removeProductId(Product $productId): self
    {
        if ($this->product_id->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getPersonLikeProduct() === $this) {
                $productId->setPersonLikeProduct(null);
            }
        }

        return $this;
    }
}
