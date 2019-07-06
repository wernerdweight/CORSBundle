<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

class ConfigurationProvider
{
    /** @var bool */
    private $allowCredentials;

    /** @var array */
    private $allowOrigin = [];

    /** @var array */
    private $allowHeaders = [];

    /** @var array */
    private $exposeHeaders = [];

    /** @var array */
    private $targetControllers = [];

    /**
     * ConfigurationProvider constructor.
     *
     * @param bool  $allowCredentials
     * @param array $allowOrigin
     * @param array $allowHeaders
     * @param array $exposeHeaders
     * @param array $targetControllers
     */
    public function __construct(
        bool $allowCredentials,
        array $allowOrigin,
        array $allowHeaders,
        array $exposeHeaders,
        array $targetControllers
    ) {
        $this->allowCredentials = $allowCredentials;
        $this->allowOrigin = $allowOrigin;
        $this->allowHeaders = $allowHeaders;
        $this->exposeHeaders = $exposeHeaders;
        $this->targetControllers = $targetControllers;
    }

    /**
     * @return bool
     */
    public function getAllowCredentials(): bool
    {
        return $this->allowCredentials;
    }

    /**
     * @return array
     */
    public function getAllowOrigin(): array
    {
        return $this->allowOrigin;
    }

    /**
     * @return array
     */
    public function getAllowHeaders(): array
    {
        return $this->allowHeaders;
    }

    /**
     * @return array
     */
    public function getExposeHeaders(): array
    {
        return $this->exposeHeaders;
    }

    /**
     * @return array
     */
    public function getTargetControllers(): array
    {
        return $this->targetControllers;
    }
}
