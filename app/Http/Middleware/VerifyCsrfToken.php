<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
       
    ];

    // protected function tokensMatch($request): bool
    // {
    //     $componentPath = $this->getLivewireComponentPath($request);

    //     if ($componentPath === 'livewire.empleados.personal-data-component') {
    //         return true;
    //     }
    //     return parent::tokensMatch($request);
    // }
}
