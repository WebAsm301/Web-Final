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


    public function __construct()
    {
        $this->suppliers = new ArrayCollection();
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
}
