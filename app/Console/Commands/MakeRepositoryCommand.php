<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Genera una interfaz y un repositorio para un modelo dado';

    public function handle()
    {
        $name = $this->argument('name');
        $interfacePath = app_path('Repositories/Contracts/' . str_replace('\\', '/', $name) . 'RepositoryInterface.php');
        $repositoryPath = app_path('Repositories/Eloquent/' . str_replace('\\', '/', $name) . 'Repository.php');

        //Se crea interface
        if (File::exists($interfacePath)) {
            $this->error('Interface already exists!');
            return;
        }

        File::ensureDirectoryExists(dirname($interfacePath));

        $namespaceInterface = 'App\\Repositories\\Contracts' . (dirname($name) !== '.' ? '\\' . str_replace('/', '\\', dirname($name)) : '');
        $interfaceName = basename($name). 'RepositoryInterface';

        $content = <<<EOT
<?php

namespace {$namespaceInterface};

interface {$interfaceName}
{
    //
}
EOT;
        File::put($interfacePath, $content);
        $this->info('Interface created successfully.');

        //Se crea repositorio
        if (File::exists($repositoryPath)) {
            $this->error('Interface already exists!');
            return;
        }
        
        File::ensureDirectoryExists(dirname($repositoryPath));
        $namespaceRepository = 'App\\Repositories\\Eloquent' . (dirname($name) !== '.' ? '\\' . str_replace('/', '\\', dirname($name)) : '');
        $repositoryName = basename($name) . 'Repository';

        $content = <<<EOT
<?php
namespace {$namespaceRepository};

use {$namespaceInterface}\\{$interfaceName};

class {$repositoryName} implements {$interfaceName}
{
    //
}
EOT;
        File::put($repositoryPath, $content);
        $this->info('Repository created successfully.');
    }
}