<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Model/Category.php';
require_once __DIR__ . '/../src/Model/Product.php';

$CategoryError = null;
$ProductError = null;

try {
    $broken = new Category(0, '   ');
} catch (InvalidArgumentException $e) {
    $errorMessage = $e->getMessage();
}

try {
    $broken = new Product(0, '   ', -0.1, 1, TRUE);
} catch (InvalidArgumentException $e) {
    $errorMessage = $e->getMessage();
}