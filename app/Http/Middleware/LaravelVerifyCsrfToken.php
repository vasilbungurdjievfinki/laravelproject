<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class LaravelVerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',  // You can add other URIs that should bypass CSRF verification
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is excluded from CSRF verification
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }

        // Handle CSRF verification
        if ($this->isReading($request) || $this->runningUnitTests() || $this->inExceptArray($request)) {
            return $next($request);
        }

        // Ensure the CSRF token is valid
        if (!$this->tokensMatch($request)) {
            throw new TokenMismatchException;
        }

        return $next($request);
    }

    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function tokensMatch(Request $request)
    {
        $token = $request->session()->token();

        return is_string($token) && hash_equals($token, $request->input('_token') ?? $request->header('X-CSRF-TOKEN'));
    }

    /**
     * Determine if the incoming request is from a read-only method.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isReading(Request $request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    /**
     * Determine if the request is running unit tests.
     *
     * @return bool
     */
    protected function runningUnitTests()
    {
        return app()->runningUnitTests();
    }

    /**
     * Determine if the URI should be excluded from CSRF verification.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray(Request $request)
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
?>
