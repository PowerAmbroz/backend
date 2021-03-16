<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $info;

    /**
     * @ORM\Column(type="date")
     */
    private $public_date;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="product")
     */
    private $prod_id;

    public function __construct()
    {
        $this->prod_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getPublicDate(): ?\DateTimeInterface
    {
        return $this->public_date;
    }

    public function setPublicDate(\DateTimeInterface $public_date): self
    {
        $this->public_date = $public_date;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getProdId(): Collection
    {
        return $this->prod_id;
    }

    public function addProdId(Like $prodId): self
    {
        if (!$this->prod_id->contains($prodId)) {
            $this->prod_id[] = $prodId;
            $prodId->setProduct($this);
        }

        return $this;
    }

    public function removeProdId(Like $prodId): self
    {
        if ($this->prod_id->removeElement($prodId)) {
            // set the owning side to null (unless already changed)
            if ($prodId->getProduct() === $this) {
                $prodId->setProduct(null);
            }
        }

        return $this;
    }

}
