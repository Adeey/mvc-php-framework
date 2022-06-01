<?php

namespace App\Models\Products;

use System\Core\Helpers\Database;

class DeleteService
{
    public function delete(int $productId): void
    {
        Database::table('products')
            ->delete()
            ->where('id', '=', $productId)
            ->run();
    }
}