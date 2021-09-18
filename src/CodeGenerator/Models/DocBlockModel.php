<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Models;

use Manowartop\LaravelSkeleton\CodeGenerator\Formatters\Contracts\FormatterInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\Contracts\ModelInterface;

/**
 * Class DocBlockModel
 * @package Krlove\CodeGenerator\Model
 */
class DocBlockModel implements ModelInterface
{
    /**
     * @var array
     */
    protected $content = [];

    /**
     * @var FormatterInterface|null
     */
    protected $formatter;

    /**
     * {@inheritDoc}
     */
    public function render(array $params = []): string
    {
        $format = !is_null($this->formatter) ? $this->formatter->getFormat() : '';

        $lines = [];
        $lines[] = "$format/**";
        if ($this->content) {
            foreach ($this->content as $item) {
                $lines[] = sprintf("$format * %s", $item);
            }
        } else {
            $lines[] = "$format *";
        }
        $lines[] = "$format */";

        return implode(PHP_EOL, $lines);
    }

    /**
     * @param array $content
     * @return DocBlockModel
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param FormatterInterface|null $formatter
     * @return DocBlockModel
     */
    public function setFormatter(FormatterInterface $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}
