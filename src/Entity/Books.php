<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
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
    private $bookname;

        /**
     * @ORM\OneToMany(targetEntity=Suppliers::class, mappedBy="book_id")
     */
    private $suppliers;

            /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="book_id")
     */
    private $products;

    public function __constring()
    {
        $this->suppliers = new ArrayCollection();
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString() {
        return $this->bookname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookname(): ?string
    {
        return $this->bookname;
    }

    public function setBookname(string $bookname): self
    {
        $this->bookname = $bookname;

        return $this;
    }

        /**
     * @return Collection|Suppliers[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Suppliers $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
            $supplier->setBooks($this);
        }

        return $this;
    }

    public function removeSupplier(Suppliers $suppliers): self
    {
        if ($this->suppliers->removeElement($suppliers)) {
            // set the owning side to null (unless already changed)
            if ($suppliers->getBooks() === $this) {
                $suppliers->setBooks(null);
            }
        }

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
