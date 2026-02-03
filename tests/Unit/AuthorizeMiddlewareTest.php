<?php

namespace Vntrungld\PrometheusExporter\Tests\Unit;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Vntrungld\PrometheusExporter\Middlewares\Authorize;
use Vntrungld\PrometheusExporter\Tests\TestCase;

class AuthorizeMiddlewareTest extends TestCase
{
    protected Authorize $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new Authorize();
    }

    public function test_allows_request_when_no_token_configured(): void
    {
        $this->app['config']->set('prometheus-exporter.token', null);

        $request = Request::create('/metrics', 'GET');

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_request_with_valid_token(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'secret-token');

        $request = Request::create('/metrics', 'GET', ['token' => 'secret-token']);

        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_denies_request_with_invalid_token(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'secret-token');

        $request = Request::create('/metrics', 'GET', ['token' => 'wrong-token']);

        $this->expectException(UnauthorizedHttpException::class);

        $this->middleware->handle($request, function ($req) {
            return response('OK');
        });
    }

    public function test_denies_request_with_missing_token_when_required(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'secret-token');

        $request = Request::create('/metrics', 'GET');

        $this->expectException(UnauthorizedHttpException::class);

        $this->middleware->handle($request, function ($req) {
            return response('OK');
        });
    }
}
