<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models;

use Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts\ModelInterface;

/**
 * NamespaceModel
 */
class NamespaceModel implements ModelInterface
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * Set namespace
     *
     * @param string $namespace
     * @return $this
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        return sprintf('namespace %s;', $this->namespace);
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
