<?php

namespace Manowartop\LaravelSkeleton\CodeGenerator\Templates\ApiResourceController;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Manowartop\LaravelSkeleton\CodeGenerator\Exceptions\CodeGeneratorException;
use Manowartop\LaravelSkeleton\CodeGenerator\Exceptions\TemplateException;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\MethodModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Models\PropertyModel;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ClassTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Contracts\TemplateInterface;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * Class CrudControllerTemplate
 */
class ApiResourceControllerTemplate extends ClassTemplate implements TemplateInterface
{
    /**
     * @var string
     */
    protected $serviceInterfaceNamespace;

    /**
     * @var string
     */
    protected $serviceName;

    /**
     * @var string
     */
    protected $modelName;

    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @var string
     */
    protected $storeRequestName;

    /**
     * @var string
     */
    protected $updateRequestName;

    /**
     * @param string $entityName
     * @param string $serviceInterfaceNamespace
     */
    public function __construct(string $entityName, string $serviceInterfaceNamespace)
    {
        parent::__construct();

        $this->setName($entityName)->setNamespace($entityName);

        $this->serviceInterfaceNamespace = $serviceInterfaceNamespace;
        $this->serviceName = $this->getServiceNameFromNamespace();
        $this->modelName = $entityName;
        $this->resourceName = "{$entityName}Resource";
        $this->storeRequestName = config('code_generator.controller.store_request_name');
        $this->updateRequestName = config('code_generator.controller.update_request_name');
    }

    /**
     * @param string $name
     * @return ClassTemplate
     */
    public function setName(string $name): ClassTemplate
    {
        return parent::setName($name . 'Controller');
    }

    /**
     * @param array $params
     * @return string
     * @throws TemplateException
     * @throws CodeGeneratorException
     */
    public function render(array $params = []): string
    {
        $this
            ->addUse($this->serviceInterfaceNamespace)
            ->addUse(AnonymousResourceCollection::class)
            ->addUse(JsonResponse::class)
            ->addUse(Exception::class)
            ->addUse(Response::class)
            ->addUse(ResponseStatus::class . ' as ResponseStatus')
            ->addUse(config('code_generator.request.namespace') . "\\$this->modelName\\$this->storeRequestName")
            ->addUse(config('code_generator.request.namespace') . "\\$this->modelName\\$this->updateRequestName")
            ->addUse(config('code_generator.resource.namespace') . "\\$this->modelName\\$this->resourceName")
            ->addUse(config('code_generator.model.namespace') . "\\$this->modelName\\$this->modelName")
            ->setExtends(Controller::class)
            ->addProperty(
                'service',
                PropertyModel::VALUE_NON_INITIALIZED,
                PropertyModel::ACCESS_PROTECTED,
                ['@var ' . $this->serviceName]
            )
            ->setConstruct()
            ->setIndexAction()
            ->setShowAction()
            ->setStoreAction()
            ->setUpdateAction()
            ->setDestroyAction();

        return parent::render($params);
    }

    /**
     * @param string|null $namespace
     * @return void
     */
    public function setNamespace(string $namespace): ClassTemplate
    {
        if (config('code_generator.controller.is_create_entity_folder')) {
            return parent::setNamespace(
                config('code_generator.controller.namespace') . "\\$namespace"
            );
        }

        return parent::setNamespace(config('code_generator.controller.namespace'));
    }

    /**
     * @return string
     */
    protected function getServiceNameFromNamespace(): string
    {
        return last(explode('\\', $this->serviceInterfaceNamespace));
    }

    /**
     * Set up construct method
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setConstruct(): self
    {
        return $this->addMethod(
            '__construct',
            [['type' => $this->serviceName, 'name' => 'service']],
            MethodModel::ACCESS_PUBLIC,
            null,
            null,
            ['$this->service = $service;']
        );
    }

    /**
     * Set index controller action
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setIndexAction(): self
    {
        return $this
            ->addMethod(
                'index',
                [],
                MethodModel::ACCESS_PUBLIC,
                null,
                'AnonymousResourceCollection',
                ["return {$this->modelName}Resource::collection(" . '$this->service->getAllPaginated());']
            );
    }

    /**
     * Set show action
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setShowAction(): self
    {
        $varName = Str::camel($this->modelName);
        return $this
            ->addMethod(
                'show',
                [['type' => $this->modelName, 'name' => $varName]],
                MethodModel::ACCESS_PUBLIC,
                null,
                $this->resourceName,
                ["return $this->resourceName::make(" . '$' . $varName . ');']
            );
    }

    /**
     * Set store action
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setStoreAction(): self
    {
        return $this->addMethod(
            'store',
            [['type' => $this->storeRequestName, 'name' => 'request']],
            MethodModel::ACCESS_PUBLIC,
            null,
            $this->resourceName,
            ['return ' . $this->resourceName . '::make($this->service->create($request->validated()), ResponseStatus::HTTP_CREATED);']
        );
    }

    /**
     * Set update action
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setUpdateAction(): self
    {
        $varName = Str::camel($this->modelName);
        return $this->addMethod(
            'update',
            [['type' => $this->modelName, 'name' => $varName], ['type' => $this->updateRequestName, 'name' => 'request']],
            MethodModel::ACCESS_PUBLIC,
            null,
            $this->resourceName,
            ['return ' . $this->resourceName . '::make($this->service->update($' . $varName . ', $request->validated()));']
        );
    }

    /**
     * Set destroy action
     *
     * @return $this
     * @throws CodeGeneratorException
     * @throws TemplateException
     */
    protected function setDestroyAction(): self
    {
        $varName = Str::camel($this->modelName);
        return $this
            ->addMethod(
                'destroy',
                [['type' => $this->modelName, 'name' => $varName]],
                MethodModel::ACCESS_PUBLIC,
                null,
                'JsonResponse',
                [
                    '$this->service->delete($' . $varName . ');',
                    '',
                    "return Response::json(null, ResponseStatus::HTTP_NO_CONTENT);"
                ],
                [
                    '@param ' . $this->modelName . ' $' . $varName,
                    '',
                    '@return JsonResponse',
                    '@throws Exception'
                ]
            );
    }
}
