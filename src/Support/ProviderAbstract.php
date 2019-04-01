<?php

namespace LaravelPayment\Manager\Support;

use LaravelPayment\Manager\Exceptions\ConfigException;

abstract class ProviderAbstract
{

    protected $config = [];

    /** @var RequestClient */
    protected $client;

    final public function __construct($config)
    {
        $this->config = $config;
    }

    abstract function boot();

    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setClient(RequestClient $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function checkServiceConfig($serviceConfig, $requiredFields)
    {
        $notFoundFields = array_diff($requiredFields, array_keys($serviceConfig));
        if (!empty($notFoundFields)) {
            throw new ConfigException('Invalid config. Not found fields: ' . implode($notFoundFields));
        }
    }

}
