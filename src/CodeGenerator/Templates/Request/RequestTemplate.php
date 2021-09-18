<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\Request;

use Doctrine\DBAL\Schema\Column;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Manowartop\LaravelSkeleton\CodeGenerator\Exceptions\TemplateException;
use Manowartop\LaravelSkeleton\CodeGenerator\Formatters\TabFormatter;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\EntityNameModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\MethodModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\DbManagerServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ClassTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;
use Manowartop\LaravelSkeleton\Request\Request;

/**
 * RequestTemplate
 */
class RequestTemplate extends ClassTemplate implements TemplateInterface
{
    /**
     * @var string
     */
    protected $modelNamespace;

    /**
     * @var string[]
     */
    protected $columnTypeToValidationRuleMapping = [
        'array'        => 'array',
        'simple_array' => 'array',
        'json_array'   => 'string',
        'bigint'       => 'integer',
        'boolean'      => 'boolean',
        'datetime'     => 'date_format:Y-m-d H:i',
        'datetimetz'   => 'date_format:Y-m-d H:i',
        'date'         => 'date_format:Y-m-d',
        'time'         => 'date_format:H:i',
        'decimal'      => 'numeric',
        'integer'      => 'integer',
        'smallint'     => 'integer',
        'string'       => 'string',
        'text'         => 'string',
        'binary'       => 'string',
        'blob'         => 'string',
        'float'        => 'numeric',
        'guid'         => 'string',
    ];

    /**
     * @param string $className
     * @param string $namespace
     * @param string|null $modelNamespace
     * @throws TemplateException
     */
    public function __construct(string $className, string $namespace, string $modelNamespace = null)
    {
        parent::__construct();

        if (!is_null($modelNamespace) && !class_exists($modelNamespace)) {
            throw new TemplateException("Model '$modelNamespace' not found.");
        }

        $this->modelNamespace = $modelNamespace;

        $this
            ->setName($className)
            ->setNamespace($namespace);
    }

    /**
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function render(array $params = []): string
    {
        $this
            ->setType(EntityNameModel::TYPE_CLASS)
            ->setExtends(Request::class)
            ->addMethod(
                'rules',
                [],
                MethodModel::ACCESS_PUBLIC,
                null,
                'array',
                $this->getRulesBody(),
                ['Get validation rules', '', '@return array']
            )
            ->addMethod(
                'messages',
                [],
                MethodModel::ACCESS_PUBLIC,
                null,
                'array',
                ['return [', '', '];'],
                ['Get validation messages', '', '@return array']
            );

        return parent::render($params);
    }

    /**
     * @param string|null $namespace
     * @return void
     */
    public function setNamespace(string $namespace): ClassTemplate
    {
        return parent::setNamespace(
            config('code_generator.request.namespace') . ($namespace ? "\\$namespace" : '')
        );
    }

    /**
     * @return string[]
     * @throws TemplateException
     */
    protected function getRulesBody(): array
    {
        if (is_null($this->modelNamespace)) {
            return ['return [', '', '];'];
        }

        /** @var Model $model */
        $model = resolve($this->modelNamespace);

        if (!$model instanceof Model) {
            throw new TemplateException('Model must be an instance of ' . Model::class);
        }

        /** @var DbManagerServiceInterface $dbManager */
        $dbManager = resolve(DbManagerServiceInterface::class);
        $formatter = resolve(TabFormatter::class);

        $body = ['return ['];

        $fillable = $model->getFillable();

        /** @var Column $tableColumn */
        foreach ($dbManager->getTableColumns($model->getTable()) as $tableColumn) {

            if (!in_array($tableColumn->getName(), $fillable)) {
                continue;
            }

            $type = $this->columnTypeToValidationRuleMapping[$tableColumn->getType()->getName()] ?? 'string';
            $body[] = $formatter->getFormat() . "'{$tableColumn->getName()}' => 'required|$type',";
        }

        $body[] = '];';

        return $body;
    }
}
