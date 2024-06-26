<?php

namespace abdalqader\crudcommand\Commands\Make;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;
use abdalqader\crudcommand\Support\Config\GenerateConfigReader;
use abdalqader\crudcommand\Support\Stub;
use abdalqader\crudcommand\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class ViewMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'name';
    protected $name = 'module:make-view';
    protected $description = 'Create a new view for the specified module.';

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the view.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    protected function getTemplateContents(): string
    {
        return (new Stub('/view.stub', ['QUOTE' => Inspiring::quotes()->random()]))->render();
    }

    protected function getDestinationFilePath(): string
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());
        $factoryPath = GenerateConfigReader::read('views');

        return $path . $factoryPath->getPath() . '/' . $this->getFileName();
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return Str::lower($this->argument('name')) . '.blade.php';
    }
}
