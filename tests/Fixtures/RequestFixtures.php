<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Fixtures;

use Symfony\Component\HttpFoundation\Request;

class RequestFixtures
{
    public static function createEmptyRequest(): Request
    {
        return Request::create('');
    }

    public static function createValidGetRequest(): Request
    {
        $request = Request::create('http://localhost/test/get', Request::METHOD_GET);
        $request->attributes->set('_route', 'test_get');
        return $request;
    }

    public static function createValidPostRequest(): Request
    {
        $request = Request::create('http://localhost/test/post', Request::METHOD_POST);
        $request->attributes->set('_route', 'test_post');
        return $request;
    }

    public static function createInvalidGetRequest(): Request
    {
        $request = Request::create('http://localhost/test/post', Request::METHOD_GET);
        $request->attributes->set('_route', 'test_post');
        return $request;
    }

    public static function createInvalidPostRequest(): Request
    {
        $request = Request::create('http://localhost/test/get', Request::METHOD_POST);
        $request->attributes->set('_route', 'test_get');
        return $request;
    }
}
