<?php

namespace LaravelPayment\Manager\Support;

use LaravelPayment\Manager\Exceptions\ConfigException;

abstract class ProviderAbstract
{

    protected $name;

    protected $config = [];

    protected $testMode = false;

    /** @var RequestClient */
    protected $client;

    final public function __construct($providerName, $config)
    {
        $this->name = $providerName;
        $this->config = $config;
        $this->testMode = !empty($config['test_mode']);
    }

    abstract function boot();

    public function getName()
    {
        return $this->name;
    }

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
