<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomersRepository::class)
 */
class Customers
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
    private $Customer_name;

    /**
     * @ORM\Column(type="date")
     */
    private $Birth_day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomername(): ?string
    {
        return $this->Customer_name;
    }

    public function setCustomername(string $Customer_name): self
    {
        $this->Customer_name = $Customer_name;

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
}