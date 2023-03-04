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
     * @ORM\ManyToOne(targetEntity=Books::class, inversedBy="suppliers")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="supplier_id")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getBooks(): ?Books
    {
        return $this->book;
    }

    public function setBooks(?Books $books): self
    {
        $this->book = $books;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProducts($this);
        }

        return $this;
    }

    public function removeProduct(Products $products): self
    {
        if ($this->products->removeElement($products)) {
            // set the owning side to null (unless already changed)
            if ($products->getProducts() === $this) {
                $products->setProducts(null);
            }
        }

        return $this;
    }
}