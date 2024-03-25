<?php

namespace Kerigard\LaravelUtils\Routing;

use Closure;
use Illuminate\Routing\Router;

/**
 * @property-read \Illuminate\Routing\RouteCollection $routes
 *
 * @mixin \Illuminate\Routing\Router
 */
class RemovableRoutesMixin
{
    public function remove(): Closure
    {
        return function (array|string $methods, array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove($methods, $urls));
        };
    }

    public function removeGet(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove(['GET', 'HEAD'], $urls));
        };
    }

    public function removePost(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove('POST', $urls));
        };
    }

    public function removePut(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove('PUT', $urls));
        };
    }

    public function removePatch(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove('PATCH', $urls));
        };
    }

    public function removeDelete(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove('DELETE', $urls));
        };
    }

    public function removeOptions(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove('OPTIONS', $urls));
        };
    }

    public function removeAny(): Closure
    {
        return function (array|string $urls) {
            $this->setRoutes(RemovableRouteCollection::cloneFrom($this->routes)->remove(Router::$verbs, $urls));
        };
    }
}
