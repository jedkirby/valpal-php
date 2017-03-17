<?php

namespace Jedkirby\ValPal;

class Config
{
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
        $endpoint = 'https://www.valpal.co.uk/api',
        $debug = false
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->endpoint = $endpoint;
        $this->debug = $debug;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param bool $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
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
    public function getDebug()
    {
        return $this->debug;
    }
}
