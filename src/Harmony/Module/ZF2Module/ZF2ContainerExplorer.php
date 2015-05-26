<?php
namespace Harmony\Module\ZF2Module;


use Harmony\Module\ContainerExplorerInterface;
use Zend\ServiceManager\ServiceManager;

class ZF2ContainerExplorer implements ContainerExplorerInterface {
    private $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Returns the name of the instances implementing `$type`.
     * Will scan only the main services, not the aliases.
     *
     * @param string $type
     * @return string[]
     */
    public function getInstancesByType($type)
    {
        $registeredServices = $this->serviceManager->getRegisteredServices();

        $services = [];

        foreach (['invokableClasses', 'factories', 'instances'] as $mode) {
            foreach ($registeredServices[$mode] as $serviceName) {
                try {
                    $instance = $this->serviceManager->get($serviceName);
                    if (is_object($instance)) {
                        if ($type == get_class($instance) || is_subclass_of($instance, $type)) {
                            $services[] = $serviceName;
                        }
                    }
                } catch (\Exception $e) {
                    // No exceptions allowed to bubble up.
                }
            }
        }

        return $services;
    }
}
