<?php

namespace EasyTodo;

class Router
{
  private array $routes = [];

  public function addRoute(string $method, string $pattern, callable $callback): void {
    $this->routes[] = [
      "method" => strtoupper($method), 
      "pattern" => $this->convertPattern($pattern),
      "callback" => $callback,
    ];
  }

  public function dispatch(string $method, string $uri): void {
    // Log the dispatching information
    error_log("Dispatching $method $uri");

    // Extract the path part of the URI, ignoring the query parameters
    $path = parse_url($uri, PHP_URL_PATH);

    foreach ($this->routes as $route) {
      if (
        $method === $route["method"] &&
        preg_match($route["pattern"], $path, $matches)
      ) {
        error_log("Matched route: " . json_encode($route));
        array_shift($matches); 
        call_user_func_array($route["callback"], $matches); 
        return; 
      }
    }
    $this->handleNotFound();
  }

  private function convertPattern(string $pattern): string {
    $pattern = preg_replace("/\{(\w+)\}/", '(?P<$1>[^\/]+)', $pattern); 
    return "/^" . str_replace("/", "\/", $pattern) . "$/";
  }

  private function handleNotFound(): void {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
  }
}