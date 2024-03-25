<?php

namespace Kerigard\LaravelUtils\Tests;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteTest extends TestCase
{
    public function test_remove_route(): void
    {
        Route::any('home', fn () => null);

        $this->checkRouteMethods('home', Router::$verbs);

        Route::removeGet('home');

        $this->checkRouteMethods('home', ['post', 'put', 'patch', 'delete'], ['get']);

        Route::get('home', fn () => null);
        Route::removePost('home');

        $this->checkRouteMethods('home', ['get', 'put', 'patch', 'delete'], ['post']);

        Route::post('home', fn () => null);
        Route::removePut('home');

        $this->checkRouteMethods('home', ['get', 'post', 'patch', 'delete'], ['put']);

        Route::put('home', fn () => null);
        Route::removePatch('home');

        $this->checkRouteMethods('home', ['get', 'post', 'put', 'delete'], ['patch']);

        Route::patch('home', fn () => null);
        Route::removeDelete('home');

        $this->checkRouteMethods('home', ['get', 'post', 'put', 'patch'], ['delete']);
    }

    public function test_remove_multiple_routes(): void
    {
        Route::any('home', fn () => null);
        Route::any('about', fn () => null);

        Route::remove(['post', 'put'], ['home', 'about']);

        $this->checkRouteMethods('home', ['get', 'patch', 'delete'], ['post', 'put']);
        $this->checkRouteMethods('about', ['get', 'patch', 'delete'], ['post', 'put']);
    }

    public function test_remove_routes_by_pattern(): void
    {
        Route::get('api/users', fn () => null);
        Route::post('api/users', fn () => null);
        Route::get('api/posts', fn () => null);

        $this->checkRouteMethods('api/users', ['get', 'post']);
        $this->checkRouteMethods('api/posts', ['get']);

        Route::removeGet('api/*');

        $this->checkRouteMethods('api/users', ['post'], ['get']);
        $this->checkRouteMethods('api/posts', missing: ['get']);
    }

    private function checkRouteMethods(string $uri, array $exists = [], array $missing = []): void
    {
        foreach ($exists as $method) {
            $response = $this->call(strtoupper($method), $uri);
            $response->assertOk();
        }

        foreach ($missing as $method) {
            $response = $this->call(strtoupper($method), $uri);
            $this->assertContains($response->status(), [404, 405]);
        }
    }
}
