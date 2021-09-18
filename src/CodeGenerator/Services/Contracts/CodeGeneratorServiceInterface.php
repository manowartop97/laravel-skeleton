<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts;

use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;

/**
 * CodeGeneratorServiceInterface
 */
interface CodeGeneratorServiceInterface
{
    /**
     * Generate file by template
     *
     * @param TemplateInterface $template
     * @param array $params
     * @return void
     */
    public function generate(TemplateInterface $template, array $params = []): void;
}
