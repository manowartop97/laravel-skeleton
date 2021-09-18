<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\Repository;

use Exception;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\EntityNameModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\PropertyModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ClassTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;
use Manowartop\ServiceRepositoryPattern\Repositories\BaseRepository;

/**
 * RepositoryTemplate
 */
class RepositoryTemplate extends ClassTemplate implements TemplateInterface
{
    /**
     * @var string
     */
    protected $modelName;

    /**
     * @param string $modelName
     */
    public function __construct(string $modelName)
    {
        parent::__construct();

        $this->modelName = $modelName;

        $this->setNamespace($modelName)->setName($modelName);
    }

    /**
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function render(array $params = []): string
    {
        $repositoryInterfaceNamespace = config('code_generator.repository.is_create_entity_folder')
            ? config('code_generator.repository.namespace') . "\\$this->modelName\\Contracts\\{$this->modelName}RepositoryInterface"
            : config('code_generator.repository.namespace') . "\\Contracts\\{$this->modelName}RepositoryInterface";

        $this
            ->setType(EntityNameModel::TYPE_CLASS)
            ->addUse($this->getModelNameWithNamespace())
            ->setExtends(BaseRepository::class)
            ->setImplements($repositoryInterfaceNamespace)
            ->addProperty(
                'modelClass',
                $this->modelName . '::class',
                PropertyModel::ACCESS_PROTECTED
            );

        return parent::render($params);
    }

    /**
     * @param string|null $name
     * @return void
     */
    public function setName(string $name): ClassTemplate
    {
        return parent::setName("{$name}Repository");
    }

    /**
     * @param string|null $namespace
     * @return void
     */
    public function setNamespace(string $namespace): ClassTemplate
    {
        if (config('code_generator.repository.is_create_entity_folder')) {
            return parent::setNamespace(
                config('code_generator.repository.namespace') . "\\$namespace"
            );
        }

        return parent::setNamespace(
            config('code_generator.repository.namespace')
        );
    }

    /**
     * @return string
     */
    public function getModelNameWithNamespace(): string
    {
        if (config('code_generator.model.is_create_entity_folder')) {
            return config('code_generator.model.namespace') . "\\$this->modelName\\$this->modelName";
        }

        return config('code_generator.model.namespace') . "\\$this->modelName";
    }
}
