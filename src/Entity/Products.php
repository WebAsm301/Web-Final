<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Suppliers::class, inversedBy="products")
     */
    private $supplier;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class, inversedBy="products")
     */
    private $book;

    /**
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\OneToMany(targetEntity=Orders::class, mappedBy="products")
     */
    private $order;

    public function __construct()
    {
        $this->order = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

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

    public function getSuppliers(): ?Suppliers
    {
        return $this->supplier;
    }

    public function setSuppliers(?Suppliers $suppliers): self
    {
        $this->supplier = $suppliers;

        return $this;
    }

        /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->order;
    }

    public function addOrders(Orders $order): self
    {
        if (!$this->order->contains($order)) {
            $this->order[] = $order;
            $order->setProducts($this);
        }

        return $this;
    }

    public function removeOrders(Orders $orders): self
    {
        if ($this->order->removeElement($orders)) {
            // set the owning side to null (unless already changed)
            if ($orders->getProducts() === $this) {
                $orders->setProducts(null);
            }
        }

        return $this;
    }
}
