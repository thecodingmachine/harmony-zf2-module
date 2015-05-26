<?php
namespace Harmony\Module\ZF2Module;

use Acclimate\Container\ContainerAcclimator;
use Harmony\Module\ContainerExplorerInterface;
use Harmony\Module\HarmonyModuleInterface;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Application;

class ZF2Module implements HarmonyModuleInterface {

    private $application;
    private $acclimatedContainer;
    private $containerExplorer;

    /**
     * Creates the module from the ZF2 Application.
     * If no Application is passed, one will be loaded from config in config/application.config.php
     *
     * @param Application $application
     */
    public function __construct(Application $application = null) {
        if ($application !== null) {
            $this->application = $application;
        } else {
            chdir(__DIR__.'/../../../../../../../');

            // Setup autoloading
            require 'init_autoloader.php';

            $this->application = Application::init(require 'config/application.config.php');

        }

        $acclimate = new ContainerAcclimator();
        $this->acclimatedContainer = $acclimate->acclimate($this->application->getServiceManager());
    }

    /**
     * You can return a container if the module provides one.
     *
     * It will be chained to the application's root container.
     *
     * @param ContainerInterface $rootContainer
     * @return ContainerInterface|null
     */
    public function getContainer(ContainerInterface $rootContainer)
    {
        return $this->acclimatedContainer;
    }

    /**
     * Returns a class that can be used to explore a container
     *
     * @return ContainerExplorerInterface|null
     */
    public function getContainerExplorer()
    {
        if ($this->containerExplorer === null) {
            $this->containerExplorer = new ZF2ContainerExplorer($this->application->getServiceManager());
        }
        return $this->containerExplorer;
    }
}
