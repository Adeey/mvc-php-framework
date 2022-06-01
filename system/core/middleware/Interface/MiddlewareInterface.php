<?php

namespace System\Core\Middleware\Interface;

interface MiddlewareInterface
{
    public function run(): bool;
}