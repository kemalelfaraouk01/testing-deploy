<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\HandleCors as Middleware;

class HandleCors extends Middleware
{
    /**
     * The names of the headers that are allowed to be exposed to the browser.
     *
     * @var array<int, string>
     */
    protected $exposedHeaders = [];
}
