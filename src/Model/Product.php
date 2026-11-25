<?php

declare(strict_types=1);
final class Product {
    public function __construct (
        private int $id,
        private string $name,
        private float $price,
        private int $categoryId,
        private ?bool $active = null
    ) {}
    public function id(): int{return $this->id;}
    public function name(): string{return $this->name;}
    public function price(): float{return $this->price;}
    public function categoryId(): int{return $this->categoryId;}
    public function active(): bool{return $this->active;}
}

?>

