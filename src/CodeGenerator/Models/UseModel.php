<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models;

use Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts\ModelInterface;

/**
 * UseModel
 */
class UseModel implements ModelInterface
{
    /**
     * @var string
     */
    protected $use;

    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        return "use $this->use;";
    }

    /**
     * Set use
     *
     * @param string $use
     * @return UseModel
     */
    public function setUse(string $use): UseModel
    {
        $this->use = $use;

        return $this;
    }

    /**
     * @return string
     */
    public function getUse(): string
    {
        return $this->use;
    }
}
