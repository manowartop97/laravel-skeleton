<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts;

/**
 * TemplateInterface
 */
interface TemplateInterface
{
    /**
     * Get parts of a template to tender
     *
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace(): string;
}
