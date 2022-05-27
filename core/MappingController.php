<?php

class MappingController
{
    public function mapRoutes()
    {
        return ['auth'];
    }

    public function controllersWithoutMiddleware()
    {
        return [
            'Authentication' => ['auth']
        ];
    }
}