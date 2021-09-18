<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\Service;

use Exception;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\EntityNameModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\PropertyModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ClassTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;
use Manowartop\ServiceRepositoryPattern\Services\BaseCrudService;

/**
 * ServiceTemplate
 */
class ServiceTemplate extends ClassTemplate implements TemplateInterface
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

        $serviceInterfaceNamespace = config('code_generator.service.is_create_entity_folder')
            ? config('code_generator.service.namespace') . "\\$this->modelName\\Contracts\\{$this->modelName}ServiceInterface"
            : config('code_generator.service.namespace') . "\\Contracts\\{$this->modelName}ServiceInterface";

        $this
            ->addUse($repositoryInterfaceNamespace)
            ->setType(EntityNameModel::TYPE_CLASS)
            ->setExtends(BaseCrudService::class)
            ->setImplements($serviceInterfaceNamespace)
            ->addProperty(
                'repository',
                $this->modelName . 'RepositoryInterface::class',
                PropertyModel::ACCESS_PROTECTED,
                ['@var string|' . $this->modelName . 'RepositoryInterface']
            );

        return parent::render($params);
    }

    /**
     * @param string|null $name
     * @return void
     */
    public function setName(string $name): ClassTemplate
    {
        return parent::setName("{$name}Service");
    }

    /**
     * @param string|null $namespace
     * @return void
     */
    public function setNamespace(string $namespace): ClassTemplate
    {
        if (config('code_generator.service.is_create_entity_folder')) {
            return parent::setNamespace(
                config('code_generator.service.namespace') . "\\$namespace"
            );
        }

        return parent::setNamespace(
            config('code_generator.service.namespace') . ""
        );
    }
}
