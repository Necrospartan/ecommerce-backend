<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name : The name of the service class}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . str_replace('\\', '/', $name) . '.php');

        if(File::exists($servicePath)){
            $this->fail('Service already exists!');
        }

        File::ensureDirectoryExists(dirname($servicePath));

        $namespacePart = dirname(str_replace('/', '\\', $name));
        $nameSpace = 'App\\Services' . ($namespacePart !== '.' ? '\\' . $namespacePart : '');
        $className = basename($name);
        
        $content = <<<EOT
<?php

namespace {$nameSpace};

class {$className}
{
    //
}
EOT;
        File::put($servicePath, $content);
        $this->info('Service created successfully.');
    }
}
