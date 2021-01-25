<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ActionInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return mixed[]
     */
    public function getResponseVars(ServerRequestInterface $request): array;

    public function redirectTo(): ?string;
}
