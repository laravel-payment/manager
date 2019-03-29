<?php

namespace LaravelPayment\Manager\Support;

abstract class ProviderAbstract
{

    protected $config = [];

    /** @var RequestClient */
    protected $client;

    abstract function __construct($config);

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
        dd(array_keys($serviceConfig), $requiredFields);
        dd(array_intersect(array_keys($serviceConfig), $requiredFields));
    }

}
