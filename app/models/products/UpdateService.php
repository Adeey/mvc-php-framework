<?php

namespace App\Models\Products;

use System\Core\Helpers\Database;
use System\Core\Helpers\Validation;
use App\Requests\Products\UpdateRequestData;

class UpdateService
{
    public function update(UpdateRequestData $data, int $productId): array
    {
        $name = Validation::validate($data->getName(), ['maxLength:30', 'minLength:3']);
        $description = Validation::validate($data->getDescription(), ['maxLength:40', 'minLength:10']);
        $statusId = Validation::validate($data->getStatusId(), ['exists:statuses']);
        $categoryId = Validation::validate($data->getCategoryId(), ['exists:product_category']);

        if (!$name) {
            return ['error' => 'Name is invalid'];
        }

        if (!$description) {
            return ['error' => 'Description is invalid'];
        }

        if (!$statusId) {
            return ['error' => 'Status not exist'];
        }

        if (!$categoryId) {
            return ['error' => 'Category not exist'];
        }

        Database::table('products')
            ->update([
                'name' => $name,
                'description' => $description,
                'category_id' => $categoryId,
                'status_id' => $statusId
            ])
            ->where('id', '=', $productId)
            ->run();

        return ['status' => 'success'];
    }
}