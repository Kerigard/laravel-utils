<?php

namespace Kerigard\LaravelUtils\Routing;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class RemovableRouteCollection extends RouteCollection
{
    public static function cloneFrom(RouteCollection $base): static
    {
        $clone = new static();

        $clone->routes = $base->routes;
        $clone->allRoutes = $base->allRoutes;
        $clone->nameList = $base->nameList;
        $clone->actionList = $base->actionList;

        return $clone;
    }

    public function remove(array|string $methods, array|string $urls): static
    {
        $methods = Arr::map(Arr::wrap($methods), fn (string $method) => strtoupper($method));
        $urls = Arr::wrap($urls);

        foreach ($this->routes as $method => $routes) {
            if (! in_array($method, $methods)) {
                continue;
            }

            /** @var \Illuminate\Routing\Route $route */
            foreach ($routes as $domainAndUri => $route) {
                foreach ($urls as $url) {
                    if (Str::is($url, $route->uri())) {
                        $this->removeRoute($route, $method, $domainAndUri);
                    }
                }
            }
        }

        return $this;
    }

    protected function removeRoute(Route $route, string $method, string $domainAndUri): void
    {
        unset($this->routes[$method][$domainAndUri]);
        unset($this->allRoutes[$method.$domainAndUri]);

        if ($name = $route->getName()) {
            unset($this->nameList[$name]);
        }

        $action = $route->getAction();

        if (isset($action['controller'])) {
            unset($this->actionList[trim($action['controller'], '\\')]);
        }
    }
}
