<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Formatters;

use Manowartop\LaravelSkeleton\CodeGenerator\Formatters\Contracts\FormatterInterface;

/**
 * Class BreakLineFormatter
 */
class BreakLineFormatter implements FormatterInterface
{
    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return "\n";
    }
}
