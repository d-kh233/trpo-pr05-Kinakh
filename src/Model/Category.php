<?php

declare(strict_types=1);
final class Category 
{
    public function __construct (
        private int $id,
        private string $name)

        {
            if (trim($name) === '') {
        throw new InvalidArgumentException('Название не может быть пустым.');
        }
        
        
        if ($id <= 0) {
            throw new InvalidArgumentException('ID является обязательным.');
        } }
    

    public function id(): int { return $this->id;}
    public function name(): string { return $this->name;}

}

