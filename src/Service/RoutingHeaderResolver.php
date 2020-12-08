<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use WernerDweight\RA\RA;

class RoutingHeaderResolver
{
    /** @var string */
    private const ROUTE_KEY = '_route';
    /** @var string */
    private const ANY_METHOD = '*';

    /** @var RouterInterface */
    private $router;

    /**
     * RoutingHeaderResolver constructor.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function resolveAllowedMethods(Request $request): ?RA
    {
        $routeName = $request->attributes->get(self::ROUTE_KEY);
        if (null === $routeName) {
            return null;
        }

        $route = $this->router->getRouteCollection()->get($routeName);
        if (null === $route) {
            return null;
        }

        $methods = new RA($route->getMethods());
        if (0 === $methods->length()) {
            return new RA([self::ANY_METHOD]);
        }

        return $methods->filter(function (string $method): bool {
            return Request::METHOD_OPTIONS !== $method;
        });
    }
}
