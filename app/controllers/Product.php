<?php

namespace App\Controllers;

use App\Models\Products;
use App\Requests\Products\CreationRequestData;
use App\Requests\Products\UpdateRequestData;
use System\Core\Helpers\Input;
use System\Core\Helpers\User;

class Product
{
    private Products\GettingService $gettingService;
    private Products\CreationService $creationService;
    private Products\UpdateService $updateService;
    private Products\DeleteService $deleteService;

    public function __construct()
    {
        $this->gettingService = new Products\GettingService();
        $this->creationService = new Products\CreationService();
        $this->updateService = new Products\UpdateService();
        $this->deleteService = new Products\DeleteService();
    }

    public function list(): void
    {
        $products = $this->gettingService->get();

        view('products/list', ['products' => $products, 'user' => User::get()]);
    }

    public function createForm(?array $errors = null): void
    {
        $statuses = $this->gettingService->getStatuses();
        $category = $this->gettingService->getCategories();

        view('products/create', ['statuses' => $statuses, 'category' => $category, 'errors' => $errors]);
    }

    public function createSubmit(): void
    {
        $data = new CreationRequestData();
        $data->setName(Input::post('name'));
        $data->setDescription(Input::post('description'));
        $data->setCategoryId(Input::post('category'));
        $data->setStatusId(Input::post('status'));

        $creation = $this->creationService->create($data);

        if (!isset($creation['error'])) {
            redirect('/');
        } else {
            $this->createForm(['message' => $creation['error']]);
        }
    }

    public function editForm(?int $id = null, ?array $errors = null): void
    {
        $product = $this->gettingService->getProductWithRelations($id);
        $statuses = $this->gettingService->getStatuses();
        $category = $this->gettingService->getCategories();

        if (!$product) {
            view('products/notFound');
        } else {
            view('products/edit', ['product' => $product, 'category' => $category, 'statuses' => $statuses, 'errors' => $errors]);
        }
    }

    public function editSubmit(?int $id = null): void
    {
        $product = $this->gettingService->getProductWithRelations($id);
        $data = new UpdateRequestData();
        $data->setName(Input::post('name'));
        $data->setDescription(Input::post('description'));
        $data->setCategoryId(Input::post('category'));
        $data->setStatusId(Input::post('status'));

        if (!$product) {
            view('products/notFound');
        } else {
            $update = $this->updateService->update($data, $id);

            if (!isset($update['error'])) {
                redirect('/');
            } else {
                $this->editForm($id, ['message' => $update['error']]);
            }
        }
    }

    public function delete(?int $id = null): void
    {
        $this->deleteService->delete($id);

        redirect('/');
    }
}