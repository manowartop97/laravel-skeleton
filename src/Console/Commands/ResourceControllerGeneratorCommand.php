<?php

namespace Manowartop\LaravelSkeleton\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\CodeGeneratorServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\ApiResourceController\ApiResourceControllerTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Traits\CodeGeneratorTrait;

/**
 * ResourceControllerGeneratorCommand
 */
class ResourceControllerGeneratorCommand extends Command
{
    use CodeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeleton:resource-controller:generate {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resource Controller generator command';

    /**
     * @var CodeGeneratorServiceInterface
     */
    protected $codeGeneratorService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CodeGeneratorServiceInterface $codeGeneratorService)
    {
        parent::__construct();

        $this->codeGeneratorService = $codeGeneratorService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $entityName = $this->getEntityNameFromTableName($this->argument('table'));

        $serviceInterfaceNamespace = config('code_generator.service.is_create_entity_folder')
            ? config('code_generator.service.namespace') . "\\$entityName\\Contracts\\{$entityName}ServiceInterface"
            : config('code_generator.service.namespace') . "\\Contracts\\{$entityName}ServiceInterface";

        $template = new ApiResourceControllerTemplate($entityName, $serviceInterfaceNamespace);

        $this->codeGeneratorService->generate($template);

        $this->info('Api Resource Controller generated');
    }
}
