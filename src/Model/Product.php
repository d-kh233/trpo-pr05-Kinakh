<?php

declare(strict_types=1);
final class Product {
    public function __construct (
        private int $id,
        private string $name,
        private float $price,
        private int $categoryId,
        private bool $active = true
    ) {
        if (trim($name) === '') {
            throw new InvalidArgumentException('Название не может быть пустым');
        }
        if ($id <=0) {
            throw new InvalidArgumentException('ID не может отсутствовать');
        }
        if ($price <=0 ) {
            throw new InvalidArgumentException('Цена не может отсутствовать или быть отрицательной');
        }
        if ($categoryId <=0 ) {
            throw new InvalidArgumentException('Категория товара является обязательным полем');
        }
        
    }

    public function id(): int{return $this->id;}
    public function name(): string{return $this->name;}
    public function price(): float{return $this->price;}
    public function categoryId(): int{return $this->categoryId;}
    public function active(): bool{return $this->active;}
    public function belongsToCategory(int $categoryId): bool {return $this->categoryId === $categoryId;}
    public function statusLabel(): string {return $this->active ? 'Активен' : 'Скрыт';} 


  public function discountedPrice(float $percent): float
{
    if ($percent < 0 || $percent > 100) {
        throw new InvalidArgumentException('Процент должен находиться в диапазоне от 0 до 100');
    }
    return round($this->price * (1 - $percent / 100), 2);
}

public function formattedPrice(): string
{
    return $this->format($this->price);
}

public function formattedDiscountedPrice(float $percent): string
{
    return $this->format($this->discountedPrice($percent));
}


private function format(float $amount): string
{
    return number_format($amount, 2, '.', ' ') . ' ₽';
}

    
}


