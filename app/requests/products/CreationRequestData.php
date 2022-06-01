<?php

namespace App\Requests\Products;

class CreationRequestData
{
    private ?string $name;
    private ?string $description;
    private ?int $statusId;
    private ?int $categoryId;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setStatusId(string $statusId): void
    {
        $this->statusId = $statusId;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
}