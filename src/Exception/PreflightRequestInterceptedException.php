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
     *
     * @param Response        $response
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(Response $response, string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
