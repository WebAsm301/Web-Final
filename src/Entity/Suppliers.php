<?php

namespace App\Entity;

use App\Repository\SuppliersRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $Product;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Supplier_nation;

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

    public function getProduct(): ?string
    {
        return $this->Product;
    }

    public function setProduct(string $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

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
}
