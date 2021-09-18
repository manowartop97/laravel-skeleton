<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Services;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\CodeGeneratorServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;

/**
 * Class CodeGeneratorService
 */
class CodeGeneratorService implements CodeGeneratorServiceInterface
{
    /**
     * Generate file by template
     *
     * @param TemplateInterface $template
     * @param array $params
     * @return void
     * @throws Exception
     */
    public function generate(TemplateInterface $template, array $params = []): void
    {
        $fullPath = $this->writeContentAndGetPath($template, $template->render());

        // Including file
        include_once $fullPath;
    }

    /**
     * Write content to a project directory
     *
     * @param TemplateInterface $template
     * @param string $content
     * @return void
     * @throws Exception
     */
    protected function writeContentAndGetPath(TemplateInterface $template, string $content): string
    {
        $path = app_path(str_replace(['\\', 'App'], ['/', ''], $template->getNamespace()));
        $filesystems = new Filesystem();

        if (!$filesystems->isDirectory($path)) {
            if (!$filesystems->makeDirectory($path, 0777, true)) {
                throw new Exception(sprintf('Could not create directory %s', $path));
            }
        }

        if (!$filesystems->isWritable($path)) {
            throw new Exception(sprintf('%s is not writeable', $path));
        }

        $fullPath = "$path/{$template->getName()}.php";

        $filesystems->put($fullPath, $content);

        return $fullPath;
    }
}
