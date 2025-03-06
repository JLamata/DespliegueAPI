<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El nombre del espacio de nombres para los controladores.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Realiza el registro de las rutas para la aplicación.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Registra las rutas de la API para la aplicación.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')  // Define el prefijo de la API
             ->middleware('api')  // Aplica el middleware `api` para las rutas de la API
             ->namespace($this->namespace)  // Usa el espacio de nombres para los controladores
             ->group(base_path('routes/api.php'));  // Carga el archivo `routes/api.php`
    }

    /**
     * Registra las rutas de la web para la aplicación.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')  // Aplica el middleware `web` para las rutas web
             ->namespace($this->namespace)  // Usa el espacio de nombres para los controladores
             ->group(base_path('routes/web.php'));  // Carga el archivo `routes/web.php`
    }
}
