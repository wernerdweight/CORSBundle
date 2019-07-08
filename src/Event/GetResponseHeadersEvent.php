<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class GetResponseHeadersEvent extends Event
{
    /** @var string */
    public const NAME = 'wds.cors_bundle.get_response_headers';

    /** @var Request */
    private $request;

    /** @var array */
    private $headers;

    /**
     * GetResponseHeadersEvent constructor.
     * @param Request $request
     * @param array $headers
     */
    public function __construct(Request $request, array $headers)
    {
        $this->request = $request;
        $this->headers = $headers;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return GetResponseHeadersEvent
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }
}
