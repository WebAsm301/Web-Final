<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Orders::class, mappedBy="customers", cascade={"persist"})
     */
    private $order;

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
            $order->setCustomers($this);
        }

        return $this;
    }

    public function removeProduct(Orders $orders): self
    {
        if ($this->order->removeElement($orders)) {
            // set the owning side to null (unless already changed)
            if ($orders->getCustomers() === $this) {
                $orders->setCustomers(null);
            }
        }

        return $this;
    }
}
