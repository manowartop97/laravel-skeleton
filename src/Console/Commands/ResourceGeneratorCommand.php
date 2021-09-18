<?php

namespace Manowartop\LaravelSkeleton\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Manowartop\LaravelSkeleton\CodeGenerator\Services\Contracts\CodeGeneratorServiceInterface;
use Manowartop\LaravelSkeleton\CodeGenerator\Templates\Resource\ResourceTemplate;
use Manowartop\LaravelSkeleton\CodeGenerator\Traits\CodeGeneratorTrait;

/**
 * ResourceGeneratorCommand
 */
class ResourceGeneratorCommand extends Command
{
    use CodeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeleton:resource:generate {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resource generator command';

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
        $this->codeGeneratorService->generate(
            new ResourceTemplate($this->getEntityNameFromTableName($this->argument('table')))
        );

        $this->info('Resource generated');
    }
}
