<?php

namespace Manowartop\LaravelSkeleton\Console\Commands;

use Illuminate\Console\Command;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\CodeGeneratorServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Repository\RepositoryInterfaceTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Repository\RepositoryTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Service\ServiceTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Service\ServiceInterfaceTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Traits\CodeGeneratorTrait;

/**
 * RepoAndServiceCodeGeneratorCommand
 */
class RepositoryAndServiceCodeGeneratorCommand extends Command
{
    use CodeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeleton:repository-service:generate {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repositories and services for a model command';

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
     */
    public function handle(): void
    {
        $entityName = $this->getEntityNameFromTableName($this->argument('table'));
        $templates = [
            new RepositoryInterfaceTemplate($entityName),
            new RepositoryTemplate($entityName),
            new ServiceInterfaceTemplate($entityName),
            new ServiceTemplate($entityName)
        ];

        foreach ($templates as $template) {
            $this->codeGeneratorService->generate($template);
        }

        $this->info('Repositories and Services were generated');
    }
}
