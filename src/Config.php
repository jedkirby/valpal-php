<?php

namespace Jedkirby\ValPal;

/**
 * @codeCoverageIgnore
 */
class Config
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://www.valpal.co.uk/api';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var bool
     */
    private $debug = false;

    /**
     * @param string $username
     * @param string $password
     * @param string $endpoint
     * @param bool $debug
     */
    public function __construct(
        $username,
        $password,
        $endpoint = self::ENDPOINT,
        $debug = false
    ) {
        $this->username = (string) $username;
        $this->password = (string) $password;
        $this->endpoint = (string) $endpoint;
        $this->debug = (bool) $debug;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = (string) $endpoint;
    }

    /**
     * @param bool $debug
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }
}
