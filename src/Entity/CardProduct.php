<?php

namespace App\Entity;

use App\Repository\CardProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardProductRepository::class)]
class CardProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $product_quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductQuantity(): ?string
    {
        return $this->product_quantity;
    }

    public function setProductQuantity(?string $product_quantity): self
    {
        $this->product_quantity = $product_quantity;

        return $this;
    }
}
