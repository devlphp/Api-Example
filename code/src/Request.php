<?php
declare(strict_types=1);

namespace ApiExample;

use ApiExample\Exceptions\InvalidRequestException;

class Request
{
    protected array $headers = [];
    protected string $request_uri;
    protected string $method;
    protected string $post_raw;
    protected array $get;
    protected array $post;

    /**
     * @throws InvalidRequestException
     */
    public function __construct()
    {
        foreach ($_SERVER as $k => $value) {
            $this->headers[strtolower($k)] = $value;
        }

        if (!isset($this->headers['request_uri']) || !isset($this->headers['request_method'])) {
            throw new InvalidRequestException();
        }

        $this->request_uri = $this->headers['request_uri'];
        $this->method = $this->headers['request_method'];
        $this->post_raw = file_get_contents('php://input');
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function getUri(): string
    {
        return $this->request_uri;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getRawPost(): string
    {
        return $this->post_raw;
    }

    public function get($key): mixed
    {
        return $this->get[$key] ?? null;
    }

    public function post($key): mixed
    {
        return $this->post[$key] ?? null;
    }
}