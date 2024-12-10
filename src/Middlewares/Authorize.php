<?php

namespace Vntrungld\PrometheusExporter\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request$request, Closure $next)
    {
        if ($expected_token = config('prometheus-exporter.token')) {
            if ($request->query('token') !== $expected_token) {
                throw new UnauthorizedHttpException('Unauthorized');
            }
        }

        return $next($request);
    }
}
