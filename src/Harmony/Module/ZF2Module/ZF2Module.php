<?php
namespace Harmony\Bundle\SymfonyBundle;

use Acclimate\Container\ContainerAcclimator;
use Harmony\Module\ContainerExplorerInterface;
use Harmony\Module\HarmonyModuleInterface;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Application;

class ZF2Module implements HarmonyModuleInterface {

    private $kernel;
    private $acclimatedContainer;
    private $containerExplorer;

    /**
     * Creates the module from the ZF2 Application.
     * If no Application is passed, one will be loaded from config in config/application.config.php
     *
     * @param Application $application
     */
    public function __construct(Application $application = null) {
        if ($kernel !== null) {
            $this->kernel = $kernel;
        } else {
            $loader = require_once __DIR__.'/../../../../../../../app/bootstrap.php.cache';
            Debug::enable();

            require_once __DIR__.'/../../../../../../../app/AppKernel.php';

            $this->kernel = new \AppKernel('dev', true);
            $this->kernel->loadClassCache();
        }
        $this->kernel->boot();

        $acclimate = new ContainerAcclimator();
        $this->acclimatedContainer = $acclimate->acclimate($this->kernel->getContainer());
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
            $this->containerExplorer = SymfonyContainerExplorer::build($this->kernel->getContainer());
        }
        return $this->containerExplorer;
    }
}
