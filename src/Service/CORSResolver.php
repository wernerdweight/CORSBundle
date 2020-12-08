<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WernerDweight\CORSBundle\Event\GetResponseHeadersEvent;
use WernerDweight\CORSBundle\Event\PreflightRequestInterceptedEvent;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;
use WernerDweight\RA\RA;

class CORSResolver
{
    /** @var string */
    private const RESPONSE_DATA = 'OK';
    /** @var string */
    private const HEADER_ALLOW_CREDENTIALS = 'Access-Control-Allow-Credentials';
    /** @var string */
    private const HEADER_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    /** @var string */
    private const HEADER_ALLOW_METHODS = 'Access-Control-Allow-Methods';
    /** @var string */
    private const HEADER_ALLOW_HEADERS = 'Access-Control-Allow-Headers';
    /** @var string */
    private const HEADER_EXPOSE_HEADERS = 'Access-Control-Expose-Headers';
    /** @var string */
    private const HEADER_ORIGIN = 'Origin';
    /** @var string */
    private const TRUE_VALUE = 'true';
    /** @var string */
    private const HEADER_VALUE_SEPARATOR = ', ';
    /** @var string */
    private const ANY_ORIGIN = '*';

    /** @var ConfigurationProvider */
    private $configurationProvider;

    /** @var RoutingHeaderResolver */
    private $routingHeaderResolver;

    /** @var EventDispatcher */
    private $eventDispatcher;

    /**
     * CORSResolver constructor.
     *
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(
        ConfigurationProvider $configurationProvider,
        RoutingHeaderResolver $routingHeaderResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->configurationProvider = $configurationProvider;
        $this->routingHeaderResolver = $routingHeaderResolver;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function resolve(Request $request): void
    {
        $response = new JsonResponse(self::RESPONSE_DATA, Response::HTTP_OK, $this->getHeaders($request));
        /** @var PreflightRequestInterceptedEvent $event */
        $event = $this->eventDispatcher->dispatch(new PreflightRequestInterceptedEvent($request, $response));
        throw new PreflightRequestInterceptedException($event->getResponse());
    }

    private function isOriginAllowed(RA $allowOrigin, ?string $origin): bool
    {
        return true === $allowOrigin->contains(self::ANY_ORIGIN) ||
            (null !== $origin && true === $allowOrigin->contains($origin));
    }

    /**
     * @return string[]
     */
    public function getHeaders(Request $request): array
    {
        $headers = [];

        if (true === $this->configurationProvider->getAllowCredentials()) {
            $headers[self::HEADER_ALLOW_CREDENTIALS] = self::TRUE_VALUE;
        }

        $allowOrigin = $this->configurationProvider->getAllowOrigin();
        if ($allowOrigin->length() > 0) {
            $origin = $request->headers->get(self::HEADER_ORIGIN);
            if (true === $this->isOriginAllowed($allowOrigin, $origin)) {
                $headers[self::HEADER_ALLOW_ORIGIN] = $origin ?: self::ANY_ORIGIN;
            }
        }

        $allowHeaders = $this->configurationProvider->getAllowHeaders();
        if ($allowHeaders->length() > 0) {
            $headers[self::HEADER_ALLOW_HEADERS] = $allowHeaders->join(self::HEADER_VALUE_SEPARATOR);
        }

        $exposeHeaders = $this->configurationProvider->getExposeHeaders();
        if ($exposeHeaders->length() > 0) {
            $headers[self::HEADER_EXPOSE_HEADERS] = $exposeHeaders->join(self::HEADER_VALUE_SEPARATOR);
        }

        $allowMethods = $this->routingHeaderResolver->resolveAllowedMethods($request);
        if (null !== $allowMethods) {
            $headers[self::HEADER_ALLOW_METHODS] = $allowMethods->join(self::HEADER_VALUE_SEPARATOR);
        }

        /** @var GetResponseHeadersEvent $event */
        $event = $this->eventDispatcher->dispatch(new GetResponseHeadersEvent($request, $headers));
        return $event->getHeaders();
    }
}
