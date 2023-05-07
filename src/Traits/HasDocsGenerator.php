<?php

namespace JoBins\APIGenerator\Traits;

use Illuminate\Testing\TestResponse;

/**
 * Class HasDocsGenerator
 */
trait HasDocsGenerator
{
    /**
     * @var string
     */
    protected $d_method;

    /**
     * @var string
     */
    protected $d_url;

    /**
     * @var array
     */
    protected $d_data;

    protected $d_header;

    /**
     * @var string
     */
    protected $d_summary;

    protected array $d_tags = [];

    /**
     * @var string
     */
    protected $d_operationId;

    /**
     * @var string
     */
    protected $d_request;

    protected $d_definitions;

    protected array $d_security = [];

    protected $d_response_schema;

    /**
     * @var bool
     */
    protected $d_ignore_request_data;

    /**
     * Operation Id of swagger api's endpoint.
     *
     * @return $this
     */
    public function setId(string $operationId)
    {
        $this->d_operationId = $operationId;

        return $this;
    }

    public function setSummary($summary)
    {
        $this->d_summary = $summary;

        return $this;
    }

    /**
     * Set tags for this endpoint.
     *
     * @return self
     */
    public function setTags(array $tags)
    {
        $this->d_tags = $tags;

        return $this;
    }

    public function setRulesFromFormRequest($request)
    {
        $this->d_request = $request;

        return $this;
    }

    public function ignoreRequestDataAsExample()
    {
        $this->d_ignore_request_data = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function setSecurity(array $security): self
    {
        $this->d_security = $security;

        return $this;
    }

    public function defineParameters(array $parameters): self
    {
        $this->d_definitions = $parameters;

        return $this;
    }

    /**
     * @return $this
     */
    public function defineResponseSchema($schema): self
    {
        $this->d_response_schema = $schema;

        return $this;
    }

    public function jsond(string $method, string $uri, array $data = [], array $headers = []): TestResponse
    {
        $this->d_method = $method;

        $this->d_url = $uri;

        $this->d_data = $data;

        $this->d_header = $headers;

        return $this->json($method, $uri, $data, $headers);
    }

    public function getParams(): array
    {
        return [
            'security' => $this->d_security,
            'operationID' => $this->d_operationId,
            'summary' => $this->d_summary,
            'tags' => $this->d_tags,
            'rule' => $this->d_request,
            'data' => $this->d_data,
            'header' => $this->d_header,
            'definitions' => $this->d_definitions,
            'url' => $this->d_url,
            'method' => $this->d_method,
            'ignoreData' => $this->d_ignore_request_data,
            'responseSchema' => $this->d_response_schema,
        ];
    }
}
