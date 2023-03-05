<?php

namespace App\Entity;

use App\Repository\SuppliersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuppliersRepository::class)
 */
class Suppliers
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
    private $Supplier_name;

    /**
     * @ORM\Column(type="date")
     */
    private $Birth_day;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Supplier_nation;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="supplier_id")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplierName(): ?string
    {
        return $this->Supplier_name;
    }

    public function setSupplierName(string $Supplier_name): self
    {
        $this->Supplier_name = $Supplier_name;

        return $this;
    }

    public function getSupplierNation(): ?string
    {
        return $this->Supplier_nation;
    }

    public function setSupplierNation(string $Supplier_nation): self
    {
        $this->Supplier_nation = $Supplier_nation;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->Birth_day;
    }

    public function setBirthDay(\DateTimeInterface $Birth_day): self
    {
        $this->Birth_day = $Birth_day;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->product;
    }

    public function addProducts(Products $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setSuppliers($this);
        }

        return $this;
    }

    public function removeSupplier(Products $products): self
    {
        if ($this->product->removeElement($products)) {
            // set the owning side to null (unless already changed)
            if ($products->getSuppliers() === $this) {
                $products->setSuppliers(null);
            }
        }

        return $this;
    }
}