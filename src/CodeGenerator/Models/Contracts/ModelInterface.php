<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts;

/**
 * ModelInterface
 */
interface ModelInterface
{
    /**
     * Render
     *
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string;
}
