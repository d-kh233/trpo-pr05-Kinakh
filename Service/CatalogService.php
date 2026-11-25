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
    throw new RuntimeException("Файл не найден: {$path}");
    }
    $raw = file_get_contents($path);
    $data = json_decode((string)$raw, true, 512, JSON_THROW_ON_ERROR);

    return $data;

}


private function loadCategories(string $path): void {
    $categories = $this->readFile($path);
    foreach ($categories as $category) {
        $this->categories[] = new Category(
            (int)$category['id'], 
            (string)$category['name'])  ;
    }
  
}

private function loadProducts(string $path): void
    {
        $rows = $this->readFile($path);

        foreach ($rows as $row) {
            $this->products[] = new Product(
                (int)$row['id'],
                (string)$row['name'],
                (float)$row['price'],
                (int)$row['category_id'],
                (bool)($row['active'] ?? true)
            );
        }
    }

public function categories(): array
    {
        return $this->categories;
    }

    public function filterByCategory(?int $categoryId): array
    {
        if ($categoryId === null || $categoryId <= 0) {
            return $this->products;
        }

        return array_values(array_filter(
            $this->products,
            fn(Product $p): bool => $p->belongsToCategory($categoryId)
        ));
    }
    
public function getAveragePrice(array $products): float
{
    if ($this->products === []) {
        return 0.0;
    }

    $total = array_reduce(
        $products,
        fn(float $sum, Product $product): float => $sum + $product->price(), 
        0.0
    );

    return round($total / count($products), 2);
    }

    public function categoryNameById(int $categoryId): string
    {
        foreach ($this->categories as $category) {
            if ($category->id() === $categoryId) {
                return $category->name();
            }
        }

        return 'Без категории';
    }
}

