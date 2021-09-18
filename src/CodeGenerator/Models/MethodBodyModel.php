<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models;

use Manowartop\LaravelSkeleton\CodeGenerator\Formatters\TabFormatter;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts\ModelInterface;

/**
 * Class MethodBodyModel
 */
class MethodBodyModel implements ModelInterface
{
    /**
     * @var array
     */
    protected $lines = [];

    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        return implode(PHP_EOL, $this->lines) . PHP_EOL;
    }

    /**
     * Add code line
     *
     * @param string $codeLine
     * @return $this
     */
    public function addLine(string $codeLine): self
    {
        $format = resolve(TabFormatter::class)->getFormat();
        array_push($this->lines, $format . $format . $codeLine);

        return $this;
    }

    /**
     * Set code lines array
     *
     * @param array $codeLines
     * @return $this
     */
    public function setLines(array $codeLines): self
    {
        foreach ($codeLines as $codeLine) {
            $this->addLine($codeLine);
        }

        return $this;
    }

    /**
     * Get code lines
     *
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}
