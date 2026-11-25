<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Model/Category.php';
require_once __DIR__ . '/../src/Model/Product.php';
require_once __DIR__ . '/../Service/CatalogService.php';
$catalog = new CatalogService(
    __DIR__ . '/../dataset/products.json',
    __DIR__ . '/../dataset/categories.json'
);

$rawCategory = isset($_GET['category']) ? trim((string)$_GET['category']) : '';
$selectedCategoryId = $rawCategory !== '' ? (int)$rawCategory : null;

$categories = $catalog->categories();
$products = $catalog->filterByCategory($selectedCategoryId);
$averagePrice = $catalog->getAveragePrice($products);


###Проверка ошибок
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$validationErrors = [];

try {
    new Category(0, '   ');
} catch (InvalidArgumentException $e) {
    $validationErrors[] = 'Category: ' . $e->getMessage();
}

try {
    new Product(1, '   ', -10.0, 1, true);
} catch (InvalidArgumentException $e) {
    $validationErrors[] = 'Product: ' . $e->getMessage();
}
?>




<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров — ПР №5</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 960px; margin: 24px auto; padding: 0 16px; background: #f7f7f9; color: #1f2937; }
        .bar, .summary, .validation { background: #fff; padding: 16px; border-radius: 10px; border: 1px solid #e5e7eb; margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
        .card { background: #fff; padding: 16px; border-radius: 10px; border: 1px solid #e5e7eb; }
        .price { font-size: 1.2rem; font-weight: 700; margin: 8px 0; }
        .muted { color: #6b7280; font-size: 0.9rem; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 0.8rem; background: #eef2ff; }
    </style>
</head>
<body>
<header>
    <h1>Каталог товаров</h1>
</header>

<main>
    <section class="bar">
        <form method="GET" action="">
            <label for="category">Категория:</label>
            <select id="category" name="category">
                <option value="">Все категории</option>
                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?= $category->id() ?>"
                        <?= $selectedCategoryId === $category->id() ? 'selected' : '' ?>
                    >
                        <?= e($category->name()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Показать</button>
            <a href="index.php">Сбросить</a>
        </form>
    </section>

    <!-- Статистика и карточки товаров --> 
  
<section class="summary">
        <strong>Найдено товаров:</strong> <?= count($products) ?> |
        <strong>Средняя цена:</strong> <?= number_format($averagePrice, 2, '.', ' ') ?> ₽
    </section>

    <section aria-label="Список товаров">
        <?php if ($products === []): ?>
            <div class="bar">Товары в выбранной категории не найдены.</div>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($products as $product): ?>
                    <article class="card">
                        <span class="badge"><?= e($catalog->categoryNameById($product->categoryId())) ?></span>
                        <h2><?= e($product->name()) ?></h2>
                        <p class="price"><?= e($product->formattedPrice()) ?></p>
                        <p class="muted">Со скидкой 10%: <?= e($product->formattedDiscountedPrice(10)) ?></p>
                        <p class="muted">Статус: <?= $product->isActive() ? 'Активен' : 'Скрыт' ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>



    <section class="validation">
        <h3>Проверка валидации конструкторов (InvalidArgumentException)</h3>
        <ul>
            <?php foreach ($validationErrors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
</body>
</html>