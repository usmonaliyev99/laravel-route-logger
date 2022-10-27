<?php

namespace Usmonaliyev\LaravelRouteLogger\Middleware;

use Closure;
use Illuminate\Http\Request;

class Log
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $status = $response->getStatusCode();
        $statusMessage = $response->isSuccessful() ? 'SUCCESS' : ($status == 500 ? 'EXCEPTION' : 'FAIL');
        $clientIp = $request->ip();
        $method = $request->getMethod();
        $pathInfo = $request->getPathInfo();
        $content = json_decode($response->getContent(), true);
        $errorMessage = $response->isSuccessful() ? 'null' : (isset($content["message"]) ? $content["message"] : 'null');
        $data = json_encode([
            "request" => $request->all(),
            "response" => $content
        ]);
        $userId = auth()->id() ?? 'null';
        $userAgent = $request->userAgent();
        $executionTime = microtime(true) - LARAVEL_START;

        $log = str_replace([
            "status_message",
            "status",
            "client_ip",
            "method",
            "path_info",
            "error_message",
            "{'request':[],'response': []}",
            "execution_time",
            "auth_id",
            "user_agent",
            "now",
        ], [
            $statusMessage,
            $status,
            $clientIp,
            $method,
            $pathInfo,
            $errorMessage,
            $data,
            $executionTime,
            $userId,
            $userAgent,
            now()
        ], config("laravel-route-logger.format"));

        file_put_contents(
            config("laravel-route-logger.path") . config("laravel-route-logger.file"),
            $log,
            FILE_APPEND
        );

        return $response;
    }
}
