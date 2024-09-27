<?php

declare(strict_types=1);

namespace Src\Validation;

class RouteValidation
{
    public array $parameters = [];

    /**
     * @param string $serverUri
     * @param string $routeUri
     * @return bool
     */
    public function validateUri(string $serverUri, string $routeUri): bool
    {
        $serverUriParts = $this->extractParts($serverUri);
        $routeUriParts = $this->extractParts($routeUri);

        if (count($routeUriParts) == count($serverUriParts)) {
            return $this->countParts($serverUriParts, $routeUriParts);
        }
        return false;
    }

    private function extractParts(string $uri): array
    {
        $uriParts = explode('?', $uri);
        $routeParts = explode('/', $uriParts[0]);

        return $this->isParameter($routeParts);
    }

    private function isParameter(array $parts): array
    {
        $uri = [];

        foreach ($parts as $part) {
            if ($part === "") {
                continue;
            }

            $uri[] = [
                'name' => $part,
                'uriParam' => preg_match('/{[^}]*}/', $part) === 1,
            ];
        }
        return $uri;
    }

    private function countParts(array $serverUri, array $routeUri): bool
    {
        $this->setParameters($serverUri, $routeUri);

        if (count($serverUri) !== count($routeUri)) {
            return false;
        }

        foreach ($serverUri as $key => $part) {
            if ($part['uriParam'] === 1) {
                continue;
            }

            if ($part['name'] === $routeUri[$key]['name']) {
                continue;
            }
            return false;
        }
        return true;
    }

    private function setParameters(array &$serverUri, array $routeUri): void
    {
        foreach ($routeUri as $key => $part) {
            if (! $part['uriParam']) {
                continue;
            }
            $param = trim($part['name'], '{}');
            $this->parameters[$param] = $serverUri[$key]['name'];
            $serverUri[$key]['uriParam'] = 1;
        }
    }
}