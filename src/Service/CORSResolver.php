<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;

class CORSResolver
{
    /** @var string */
    private const RESPONSE_DATA = 'OK';

    /**
     * @param Request $request
     */
    public function resolve(Request $request): void
    {
        // TODO: add event to replace the default response with custom response
        $response = new JsonResponse(self::RESPONSE_DATA, Response::HTTP_OK, $this->getHeaders($request));
        throw new PreflightRequestInterceptedException($response);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getHeaders(Request $request): array
    {
        // TODO:
    }
}
