<?php

class Validation
{
    public function validateLogin(?string $login): ?string
    {
        if (!$login || strlen($login) < 5) {
            return null;
        }

        return $login;
    }

    public function validatePassword(?string $password): ?string
    {
        if (!$password || strlen($password) < 5) {
            return null;
        }

        return $password;
    }

    public function validateName(?string $name): ?string
    {
        if (!$name || strlen($name) < 5) {
            return null;
        }

        return $name;
    }

    public function validateDescription(?string $description): ?string
    {
        if (!$description || strlen($description) < 10) {
            return null;
        }

        return $description;
    }
}