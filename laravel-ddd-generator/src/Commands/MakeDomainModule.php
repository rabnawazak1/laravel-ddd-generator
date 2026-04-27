<?php

namespace rabnawazak1\DddGenerator\Commands; // <-- change this

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDomainModule extends Command
{
    protected $signature = 'make:domain {domain} {module}';
    protected $description = 'Create a new DDD module with Actions, Controller, Requests, Service, Repository, Model, DTO';

    public function handle()
    {
        $domain = Str::studly($this->argument('domain'));
        $module = Str::studly($this->argument('module'));

        $basePath = app_path("Domains/{$domain}/{$module}");

        $folders = [
            'Actions',
            'Controllers',
            'Requests',
            'Services',
            'Repositories',
            'Models',
            'DTO',
        ];

        // Create directories
        foreach ($folders as $folder) {
            $path = $basePath . '/' . $folder;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }

        $this->info("Folders created successfully under Domains/{$domain}/{$module}");

        // Generate stub files
        $this->generateFiles($domain, $module, $basePath);
    }

    protected function generateFiles($domain, $module, $basePath)
    {
        $classMap = [
            'Actions' => ['Create', 'Update', 'Delete', 'ChangeStatus', 'Search'],
            'Controllers' => [$module . 'Controller'],
            'Requests' => ['Store' . $module . 'Request', 'Update' . $module . 'Request', 'Change' . $module . 'StatusRequest'],
            'Services' => [$module . 'Service'],
            'Repositories' => [$module . 'Repository'],
            'Models' => [$module],
            'DTO' => [$module . 'Data'],
        ];

        foreach ($classMap as $folder => $classes) {
            foreach ($classes as $class) {
                $namespace = "App\\Domains\\{$domain}\\{$module}\\$folder";
                $filePath = "$basePath/$folder/$class.php";

                if (!File::exists($filePath)) {
                    File::put($filePath, $this->getStub($namespace, $class, $folder, $module,$domain));
                }
            }
        }

        $this->info("Stub files created successfully.");
    }

    protected function getStub($namespace, $class, $folder, $module,$domain)
    {
        switch ($folder) {
            case 'Controllers':
                return <<<PHP
<?php

namespace $namespace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class $class extends Controller
{
    // TODO: Inject Services and implement methods
}

PHP;

            case 'Actions':
                return <<<PHP
<?php

namespace $namespace;

use App\Domains\\$domain\\$module\Repositories\\{$module}Repository;
use Illuminate\Support\Facades\DB;

class $class
{
    public function __construct(
        protected {$module}Repository \$repository
    ) {}

    public function execute(array \$data)
    {
        return DB::transaction(function () use (\$data) {
            // TODO: implement action logic
        });
    }
}

PHP;

            case 'Requests':
                return <<<PHP
<?php

namespace $namespace;

use Illuminate\Foundation\Http\FormRequest;

class $class extends FormRequest
{
    public function rules()
    {
        return [
            // TODO: add validation rules
        ];
    }
}

PHP;

            case 'Services':
                return <<<PHP
<?php

namespace $namespace;

class $class
{
    // TODO: inject Actions and implement workflow methods
}

PHP;

            case 'Repositories':
                return <<<PHP
<?php

namespace $namespace;

use App\Domains\\$domain\\$module\Models\\$module;

class $class
{
    // TODO: implement database queries
}

PHP;

            case 'Models':
                return <<<PHP
<?php

namespace $namespace;

use Illuminate\Database\Eloquent\Model;

class $class extends Model
{
    protected \$fillable = [
        // TODO: fillable attributes
    ];
}

PHP;

            case 'DTO':
                return <<<PHP
<?php

namespace $namespace;

class $class
{
    // TODO: define data transfer object properties
}

PHP;

            default:
                return <<<PHP
<?php

namespace $namespace;

class $class
{
    // TODO: implement class
}

PHP;
        }
    }
}