<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use WernerDweight\RA\RA;

class TargetControllerResolver
{
    /** @var ConfigurationProvider */
    private $configurationProvider;

    /** @var RA|null */
    private $configuration;

    /**
     * TargetControllerResolver constructor.
     * @param ConfigurationProvider $configurationProvider
     */
    public function __construct(ConfigurationProvider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @return RA
     */
    private function getConfiguration(): RA
    {
        if (null === $this->configuration) {
            $this->configuration = new RA($this->configurationProvider->getTargetControllers());
        }
        return $this->configuration;
    }

    /**
     * @param callable $controller
     * @return bool
     */
    public function isTargeted(callable $controller): bool
    {
        dump($controller, $this->getConfiguration());exit;

        if ($controller instanceof CORSControllerInterface) {
            return true;
        }

        return false;
    }
}
