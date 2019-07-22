<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;

class PreflightRequestInterceptedExceptionTest extends TestCase
{
    public function testGetResponse(): void
    {
        $response = new Response('test', Response::HTTP_NO_CONTENT, ['test']);
        $exception = new PreflightRequestInterceptedException($response);
        $this->assertEquals($response, $exception->getResponse());
    }
}
