<?php

class Product extends MainController
{
    public function __construct()
    {
        $this->load('database');
        $this->load('validation');
    }

    public function list(): void
    {
        $products = $this->database->table('products')
            ->selectRaw('`product_category`.`name` AS `categoryName`, `statuses`.`name` AS `statusName`, `products`.`id`, `products`.`name`, `products`.`description`')
            ->join('statuses')
            ->on('statuses', 'id', 'products', 'status_id')
            ->join('product_category')
            ->on('product_category', 'id', 'products', 'category_id')
            ->get();

        $this->view('products/list', $products);
    }

    public function createForm(?array $errors = null): void
    {
        $statuses = $this->getStatuses();
        $category = $this->getCategories();

        $this->view('products/create', ['statuses' => $statuses, 'category' => $category, 'errors' => $errors]);
    }

    public function createSubmit(): void
    {
        $name = $this->validation->validateName($_POST['name']);
        $description = $this->validation->validateDescription($_POST['description']);
        $statusId = $_POST['status'];
        $categoryId = $_POST['category'];

        if (!$name || !$description) {
            $this->createForm(['message' => 'name or description invalid']);
        } else {
            $this->database->table('products')
                ->insert([
                    'name' => $name,
                    'description' => $description,
                    'status_id' => $statusId,
                    'category_id' => $categoryId
                ])
                ->run();

            redirect('/index.php/product/list');
        }
    }

    public function editForm(?int $id = null, ?array $errors = null): void
    {
        $product = $this->getProductWithRelations($id);
        $statuses = $this->getStatuses();
        $category = $this->getCategories();

        if (!$product) {
            $this->view('products/notFound');
        } else {
            $this->view('products/edit', ['product' => $product, 'category' => $category, 'statuses' => $statuses, 'errors' => $errors]);
        }
    }

    public function editSubmit(?int $id = null): void
    {
        $product = $this->getProductWithRelations($id);

        if (!$product) {
            $this->view('products/notFound');
        } else {
            $name = $this->validation->validateName($_POST['name']);
            $description = $this->validation->validateDescription($_POST['description']);
            $statusId = $_POST['status'];
            $categoryId = $_POST['category'];

            if (!$name || !$description) {
                $this->editForm($id, ['message' => 'name or description invalid']);
            } else {
                $this->database->table('products')
                    ->update(['name' => $name, 'description' => $description, 'category_id' => $categoryId, 'status_id' => $statusId])
                    ->where('id', '=', $id)
                    ->run();

                redirect('/index.php/product/list');
            }
        }
    }

    public function delete(?int $id = null): void
    {
        $this->database->table('products')
            ->delete()
            ->where('id', '=', $id)
            ->run();

        redirect('/index.php/product/list');
    }

    private function getProductWithRelations(int $id): ?array
    {
        $product = $this->database->table('products')
            ->selectRaw('`product_category`.`name` AS `categoryName`, `statuses`.`name` AS `statusName`, `products`.`id`, `products`.`name`, `products`.`description`')
            ->join('statuses')
            ->on('statuses', 'id', 'products', 'status_id')
            ->join('product_category')
            ->on('product_category', 'id', 'products', 'category_id')
            ->whereRaw('`products`.`id` = ' . $id)
            ->first();

        return $product;
    }

    private function getStatuses(): array
    {
        $statuses = $this->database->table('statuses')
            ->select()
            ->get();

        return $statuses;
    }

    private function getCategories(): array
    {
        $categories = $this->database->table('product_category')
            ->select()
            ->get();

        return $categories;
    }
}