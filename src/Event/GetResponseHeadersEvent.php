<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class GetResponseHeadersEvent extends Event
{
    /**
     * @var string
     */
    public const NAME = 'wds.cors_bundle.get_response_headers';

    /**
     * @var string[]
     */
    private $headers = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * GetResponseHeadersEvent constructor.
     *
     * @param string[] $headers
     */
    public function __construct(Request $request, array $headers)
    {
        $this->request = $request;
        $this->headers = $headers;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string[] $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}
