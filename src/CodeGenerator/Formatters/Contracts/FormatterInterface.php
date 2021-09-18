<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Formatters\Contracts;

/**
 * FormatterInterface
 */
interface FormatterInterface
{
    /**
     * Get format
     *
     * @return string|null
     */
    public function getFormat(): ?string;
}
