<?php
declare(strict_types=1);

namespace ApiExample\Routing;

use ApiExample\Exceptions\AppException;
use ApiExample\Request;

class Route
{
    const REGEX_PATTERN = '([\w-]+)';
    protected $callback;
    protected array $options = [];

    /**
     * @param string $request_type
     * @param string $path
     * @param callable|array $callback
     */
    public function __construct(protected string $request_type,
                                protected string $path,
                                callable|array   $callback)
    {
        $this->callback = $callback;
    }

    public function matchRequest(Request $request): bool
    {
        if ($this->request_type !== $request->getRequestMethod()) {
            return false;
        }

        //check if url contains regex element
        if (!str_contains($this->path, '{')) {
            if ($this->path !== $request->getUri()) {
                return false;
            }
            return true;
        }

        //make regex
        if (preg_match($this->getRegex(), $request->getUri(), $match)) {
            unset($match[0]);
            $this->options = $match;
            return true;
        }

        return false;
    }

    /**
     * @throws AppException
     */
    public function run(): void
    {
        if (is_callable($this->callback)) {
            call_user_func_array($this->callback, array_values($this->options));
        } else {
            if (class_exists($this->callback[0]) === false) {
                throw new AppException("Class doesn't exist");
            }
            if (method_exists($this->callback[0], $this->callback[1]) === false) {
                throw new AppException("Class method doesn't exist");
            }
            call_user_func_array([new $this->callback[0](), $this->callback[1]], array_values($this->options));
        }
    }


    private function getRegex(): string
    {
        //extract all {} from path
        preg_match_all('!{[^}]+}!', $this->path, $matches);
        $regex_path = '!^' . preg_quote($this->path, '!') . '$!';
        foreach ($matches[0] as $match) {
            $pattern = '!' . preg_quote(preg_quote($match, '!'), '!') . '!';
            $regex_path = preg_replace($pattern, self::REGEX_PATTERN, $regex_path, limit: 1);
        }

        return $regex_path;
    }
}