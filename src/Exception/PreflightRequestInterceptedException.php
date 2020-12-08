<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

class PreflightRequestInterceptedException extends \RuntimeException
{
    /** @var Response */
    private $response;

    /**
     * PreflightRequestInterceptedException constructor.
     */
    public function __construct(Response $response, string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
