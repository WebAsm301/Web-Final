<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="orders")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Customers::class, inversedBy="orders")
     */
    private $customer;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }
    
    public function getProducts(): ?Products
    {
        return $this->product;
    }

    public function setProducts(?Products $products): self
    {
        $this->product = $products;

        return $this;
    }

    public function getCustomers(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomers(?Customers $customers): self
    {
        $this->customer = $customers;

        return $this;
    }
}