<?php

namespace App\Models\Products;

use System\Core\Helpers\Database;
use App\Requests\Products\CreationRequestData;
use System\Core\Helpers\Validation;

class CreationService
{
    public function create(CreationRequestData $data): array
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
            ->insert([
                'name' => $name,
                'description' => $description,
                'status_id' => $statusId,
                'category_id' => $categoryId
            ])
            ->run();

        return ['status' => 'success'];
    }
}