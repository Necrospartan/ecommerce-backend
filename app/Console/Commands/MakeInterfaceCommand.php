<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeInterfaceCommand extends Command
{
    protected $signature = 'make:interface {name : The name of the interface}';
    protected $description = 'Create a new interface';

    public function handle()
    {
        $name = $this->argument('name');
        $interfacePath = app_path('Repositories/Contracts/' . str_replace('\\', '/', $name) . '.php');

        if (File::exists($interfacePath)) {
            $this->error('Interface already exists!');
            return;
        }

        File::ensureDirectoryExists(dirname($interfacePath));

        $namespace = 'App\\Repositories\\Contracts' . (dirname($name) !== '.' ? '\\' . str_replace('/', '\\', dirname($name)) : '');
        $interfaceName = basename($name);

        $content = <<<EOT
<?php

namespace {$namespace};

interface {$interfaceName}
{
    //
}
EOT;
        File::put($interfacePath, $content);
        $this->info('Interface created successfully.');
    }
}
