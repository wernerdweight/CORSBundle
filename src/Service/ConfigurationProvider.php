<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Service;

use WernerDweight\RA\RA;

class ConfigurationProvider
{
    /** @var bool */
    private $allowCredentials;

    /** @var RA */
    private $allowOrigin;

    /** @var RA */
    private $allowHeaders;

    /** @var RA */
    private $exposeHeaders;

    /** @var RA */
    private $targetControllers;

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
        $this->allowOrigin = new RA($allowOrigin);
        $this->allowHeaders = new RA($allowHeaders);
        $this->exposeHeaders = new RA($exposeHeaders);
        $this->targetControllers = new RA($targetControllers);
    }

    /**
     * @return bool
     */
    public function getAllowCredentials(): bool
    {
        return $this->allowCredentials;
    }

    /**
     * @return RA
     */
    public function getAllowOrigin(): RA
    {
        return $this->allowOrigin;
    }

    /**
     * @return RA
     */
    public function getAllowHeaders(): RA
    {
        return $this->allowHeaders;
    }

    /**
     * @return RA
     */
    public function getExposeHeaders(): RA
    {
        return $this->exposeHeaders;
    }

    /**
     * @return RA
     */
    public function getTargetControllers(): RA
    {
        return $this->targetControllers;
    }
}
