<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;
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
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @return RA|null
     */
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
        if ($methods->length() === 0) {
            return new RA([self::ANY_METHOD]);
        }

        return $methods->filter(function (string $method): bool {
            return Request::METHOD_OPTIONS !== $method;
        });
    }
}
