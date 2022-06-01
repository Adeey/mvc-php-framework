<?php

namespace System\Config;

class ApplicationConfig
{
    /**
     * 2 types
     * development - with displayed errors
     * production - without displayed errors
     */
    const APPLICATION_TYPE = 'development';

    /**
     * true - enable authentication for application
     * false - disable authentication for application
     */
    const AUTHENTICATION = true;
}