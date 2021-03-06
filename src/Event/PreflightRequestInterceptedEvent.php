<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class PreflightRequestInterceptedEvent extends Event
{
    /** @var string */
    public const NAME = 'wds.cors_bundle.preflight_request_intercepted';

    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    /**
     * PreflightRequestInterceptedEvent constructor.
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return PreflightRequestInterceptedEvent
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }
}
