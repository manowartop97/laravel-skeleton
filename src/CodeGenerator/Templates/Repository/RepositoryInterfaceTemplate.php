<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\Repository;

use Exception;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\EntityNameModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ClassTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;
use Manowartop\ServiceRepositoryPattern\Repositories\Contracts\BaseRepositoryInterface;

/**
 * RepositoryInterfaceTemplate
 */
class RepositoryInterfaceTemplate extends ClassTemplate implements TemplateInterface
{
    /**
     * @param string $entityName
     */
    public function __construct(string $entityName)
    {
        parent::__construct();

        $this->setNamespace($entityName)->setName($entityName);
    }

    /**
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function render(array $params = []): string
    {
        $this->setType(EntityNameModel::TYPE_INTERFACE)->setExtends(BaseRepositoryInterface::class);

        return parent::render($params);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): ClassTemplate
    {
        return parent::setName("{$name}RepositoryInterface");
    }

    /**
     * @param string|null $namespace
     * @return void
     */
    public function setNamespace(string $namespace): ClassTemplate
    {
        if (config('code_generator.repository.is_create_entity_folder')) {
            return parent::setNamespace(
                config('code_generator.repository.namespace') . "\\$namespace\\Contracts"
            );
        }

        return parent::setNamespace(
            config('code_generator.repository.namespace') . "\\Contracts"
        );
    }
}
