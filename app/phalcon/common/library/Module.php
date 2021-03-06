<?php
namespace Webird;

use Phalcon\DI,
    Phalcon\Mvc\ModuleDefinitionInterface,
    Webird\Mvc\View;

/**
 * Module
 *
 */
abstract class Module implements ModuleDefinitionInterface
{
    /**
     *
     */
    public function getViewFunc()
    {
        $viewsDir = $this->getViewsDir();
        return function() use ($viewsDir) {
            $view = new View();
            $view->setDI($this);
            $view->setViewsDir($viewsDir);
            $view->setLayoutsDir('_layouts/');
            $view->setPartialsDir('_partials/');

            $view->registerEngines([
                '.volt' => 'voltShared'
            ]);
            return $view;
        };
    }

    /**
     * Returns the module view directory for external operations
     *
     * @return string
     */
    public function getViewsDir()
    {
        return $this->getModuleRootDir() . 'views/';
    }

    /**
     *
     */
    protected function getModuleRootDir()
    {
        $modulesDir = DI::getDefault()
            ->getConfig()
            ->path->modulesDir;

        $classParts = explode('\\', get_called_class());
        $moduleName = lcfirst($classParts[2]);

        return $modulesDir . $moduleName . '/';
    }
}
