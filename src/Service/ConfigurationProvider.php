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
     * @param string[] $allowOrigin
     * @param string[] $allowHeaders
     * @param string[] $exposeHeaders
     * @param string[] $targetControllers
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

    public function getAllowCredentials(): bool
    {
        return $this->allowCredentials;
    }

    public function getAllowOrigin(): RA
    {
        return $this->allowOrigin;
    }

    public function getAllowHeaders(): RA
    {
        return $this->allowHeaders;
    }

    public function getExposeHeaders(): RA
    {
        return $this->exposeHeaders;
    }

    public function getTargetControllers(): RA
    {
        return $this->targetControllers;
    }
}
