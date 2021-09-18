<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Formatters;

use Manowartop\LaravelSkeleton\CodeGenerator\Formatters\Contracts\FormatterInterface;

/**
 * Class TabFormatter
 */
class TabFormatter implements FormatterInterface
{
    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return "\t";
    }
}
