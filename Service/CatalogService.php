<?php
declare(strict_types=1); 


final class CatalogService {
    private array $categories = [];
    private array $products = [];
    public function __construct(string $productsPath, string $categoriesPath){
        $this->loadCategories($categoriesPath);
        $this->loadProducts($productsPath);
}


private function readFile(string $path): array {
    if (!is_file($path) ){
    throw new RuntimeException('Неверный путь к файлу:');
    }
    $readenFile = file_get_contents($path);
    $data = json_decode((string)$readenFile, true, 512, JSON_THROW_ON_ERROR);
    return $data;

}


private function loadCategories(string $path): void {
    $categories = $this->readFile($path);
    foreach $categories as $category (
        $this->categories[] = new Category((int)$row['id'], (string)$row['name']);  
    )
}
private function loadProducts(string $path): void {
    $products = $this->readFile($path);
    foreach $products as $product {
        $this->products[] = new Product((int)$row['id'], (string)$row['name'], (float)$row['price'], (int)$row['category_id'], (bool)($row['active'] ?? true)) 
    }
}
public function filterByCategory(?int $categoryId): array {
    if ($categoryId === null || $categoryId <= 0) {
        return $this->products
         иначе отфильтрует через 
    }
    else: { array_values(array_filter($this->$category, fn(Product $p): bool => $p->belongsToCategory($categoryId)))
}
    }
public function getAveragePrice(): float
{
    if ($this->products === []) {
        return 0.0;
    }

    $total = array_reduce(
        $this->products,
        fn(float $sum, Product $product): float => $sum + $product->price(), 
        0.0
    );

    return round($total / count($this->products), 2);
}
}

