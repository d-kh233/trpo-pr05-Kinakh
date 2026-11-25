<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Model/Category.php';
require_once __DIR__ . '/../src/Model/Product.php';
require_once __DIR__ . '/../Service/CatalogService.php';

$errors = [];

try {
    new Category(0, '   ');
} catch (InvalidArgumentException $e) {
    $errors[] = $e->getMessage(); 
}

try {
    new Product(0, '   ', -0.1, 1, true);
} catch (InvalidArgumentException $e) {
    $errors[] = $e->getMessage();
}