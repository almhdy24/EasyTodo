<?php

namespace EasyTodo;

class Router
{
  private array $routes = [];

  /**
   * Add a route to the router.
   *
   * @param string $method The HTTP method (GET, POST, etc.)
   * @param string $pattern The route pattern
   * @param callable $callback The callback to execute
   */
  public function addRoute(
    string $method,
    string $pattern,
    callable $callback
  ): void {
    $this->routes[] = [
      "method" => strtoupper($method), // Ensure method is in uppercase
      "pattern" => $this->convertPattern($pattern),
      "callback" => $callback,
    ];
  }

  /**
   * Dispatch the request to the appropriate route.
   *
   * @param string $method The HTTP method
   * @param string $uri The request URI
   */
  public function dispatch(string $method, string $uri): void
  {
    foreach ($this->routes as $route) {
      if (
        $method === $route["method"] &&
        preg_match($route["pattern"], $uri, $matches)
      ) {
        // Remove the full match from matches and pass the rest as parameters
        array_shift($matches); // The full URI match is the first element
        call_user_func_array($route["callback"], $matches); // Call the callback without returning
        return; // Exit the method after handling the route
      }
    }
    $this->handleNotFound();
  }

  /**
   * Convert the pattern to a regex.
   *
   * @param string $pattern The route pattern
   * @return string The regex pattern
   */
  private function convertPattern(string $pattern): string
  {
    // Convert parameters into regex groups
    $pattern = preg_replace("/\{(\w+)\}/", '(?P<$1>[^\/]+)', $pattern); // support route params
    return "/^" . str_replace("/", "\/", $pattern) . "$/";
  }

  /**
   * Handle the 404 Not Found response.
   */
  private function handleNotFound(): void
  {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
  }
}
