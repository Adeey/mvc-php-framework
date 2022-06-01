<?php

namespace App\Models\Products;

use System\Core\Helpers\Database;

class GettingService
{
    public function get(): array
    {
        return Database::table('products')
            ->selectRaw('`product_category`.`name` AS `categoryName`, `statuses`.`name` AS `statusName`, `products`.`id`, `products`.`name`, `products`.`description`')
            ->join('statuses')
            ->on('statuses', 'id', 'products', 'status_id')
            ->join('product_category')
            ->on('product_category', 'id', 'products', 'category_id')
            ->get();
    }

    public function getProductWithRelations(int $id): ?array
    {
        return Database::table('products')
            ->selectRaw('`product_category`.`name` AS `categoryName`, `statuses`.`name` AS `statusName`, `products`.`id`, `products`.`name`, `products`.`description`')
            ->join('statuses')
            ->on('statuses', 'id', 'products', 'status_id')
            ->join('product_category')
            ->on('product_category', 'id', 'products', 'category_id')
            ->whereRaw('`products`.`id` = ' . $id)
            ->first();
    }

    public function getStatuses(): array
    {
        return Database::table('statuses')
            ->select()
            ->get();
    }

    public function getCategories(): array
    {
        return Database::table('product_category')
            ->select()
            ->get();
    }
}