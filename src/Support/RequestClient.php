<?php


namespace LaravelPayment\Manager\Support;

use LaravelPayment\Manager\Exceptions\Request\ClientException;
use LaravelPayment\Manager\Exceptions\Request\ParseTypeException;

class RequestClient
{
    const DATA_TYPE_JSON = 'json';
    const DATA_TYPE_PLAIN = 'plain';
    const DATA_TYPE_XML = 'xml';

    const METHOD_POST = 'post';
    const METHOD_GET = 'get';

    protected $dataType = self::DATA_TYPE_JSON;
    protected $baseURL = null;
    protected $headers = [];
    protected $globalData = [];

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setDataType($dataType): self
    {
        $this->dataType = $dataType;
        return $this;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function setBaseURL($baseURL): self
    {
        $this->baseURL = $baseURL;
        return $this;
    }

    public function getBaseURL(): mixed
    {
        return $this->baseURL;
    }

    public function setGlobalData(array $data, $merge = false): self
    {
        $this->globalData = $merge ? array_merge($this->globalData, $data) : $data;
        return $this;
    }

    public function getGlobalData(): array
    {
        return $this->globalData;
    }

    public function request($url, $method, $data)
    {
        if (!is_null($this->baseURL)) {
            $url = $this->baseURL . $url;
        }

        if (!empty($this->globalData)) {
            $data += $this->globalData;
        }

        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_VERBOSE        => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $this->headers,
        ];

        switch ($method) {
            case self::METHOD_POST:
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $data;
                break;
            case self::METHOD_GET:
                $options[CURLOPT_URL] .= '?' . http_build_query($data);
                $options[CURLOPT_POST] = false;
                break;
            default:
                throw new ClientException('unknown method');
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if ($error = curl_errno($ch)) {
            throw new ClientException(curl_error($ch), $error);
        }

        return $this->parseResponse($response);
    }

    protected function parseResponse($data)
    {
        switch ($this->dataType) {
            case self::DATA_TYPE_JSON:
                return $this->parseJSON($data);
            case self::DATA_TYPE_PLAIN:
                return $this->parsePlain($data);
            case self::DATA_TYPE_XML:
                return $this->parseXML($data);
            default:
                throw new ParseTypeException('unknown type:' . $this->dataType);
        }
    }

    protected function parseJSON($data)
    {
        return json_decode($data, true);
    }

    protected function parsePlain($data)
    {
        return $data;
    }

    protected function parseXML($data)
    {
        $xml = simplexml_load_string($data);
        $array = json_decode(json_encode((array)$xml), true);
        return [$xml->getName() => $array];
    }
}
