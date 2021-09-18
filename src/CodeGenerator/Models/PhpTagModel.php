<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models;

use Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts\ModelInterface;

/**
 * PhpTagModel
 */
class PhpTagModel implements ModelInterface
{
    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        return '<?php';
    }
}
