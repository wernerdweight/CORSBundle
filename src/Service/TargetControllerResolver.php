<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use Symfony\Contracts\Service\ServiceSubscriberInterface;
use WernerDweight\CORSBundle\Controller\Contracts\CORSControllerInterface;
use WernerDweight\RA\RA;

class TargetControllerResolver
{
    /**
     * @var string
     */
    private const ANY_CONTROLLER = '*';

    /**
     * @var ConfigurationProvider
     */
    private $configurationProvider;

    /**
     * @var RA|null
     */
    private $configuration;

    public function __construct(ConfigurationProvider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    public function isTargeted(ServiceSubscriberInterface $controller): bool
    {
        $configuration = $this->getConfiguration();

        if ($controller instanceof CORSControllerInterface) {
            return true;
        }

        if ($configuration->length() > 0) {
            if (true === $configuration->contains(self::ANY_CONTROLLER)) {
                return true;
            }

            $configuration->rewind();
            while (true === $configuration->valid()) {
                $targetedClass = $configuration->current();
                if ($controller instanceof $targetedClass) {
                    return true;
                }
                $configuration->next();
            }
        }

        return false;
    }

    private function getConfiguration(): RA
    {
        if (null === $this->configuration) {
            $this->configuration = $this->configurationProvider->getTargetControllers();
        }
        return $this->configuration;
    }
}
