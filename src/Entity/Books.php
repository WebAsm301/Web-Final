<?php

namespace App\Entity;

use App\Repository\BooksRepository;
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
     * @ORM\Column(type="integer")
     */
    private $Quantity;

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

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }
}
