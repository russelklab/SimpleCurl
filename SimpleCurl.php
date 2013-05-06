<?php

class SimpleCurl
{
    protected static $ch;

    public static function init()
    {
        if(isset(self::$ch)) {
            return self::$ch;
        }

        self::$ch = curl_init();

        return new self();
    }

    /**
     * @return resource The curl resource type
     */
    public function getCurlResource()
    {
        return self::$ch;
    }

    /**
     * @param string $curl_opt The CURLOPT_XXXX to be set
     * @param array|string $options options for the CULROPT_XXXX
     */
    private function setOpt($curl_opt, $options)
    {
        if(!isset(self::$ch)) {
            self::init();
        }

        curl_setopt(self::$ch, $curl_opt, $options);
    }

    /**
     * @param string $url The URL to fetch
     */
    public function setUrl($url)
    {
        $this->setOpt(CURLOPT_URL, $url);
    }

    /**
     * Include the header in the output
     *
     * @pram boolean $enable True to include header in output. Defaults to False.
     */
    public function setHeader($enable = false)
    {
        $this->setOpt(CURLOPT_HEADER, $enable);
    }

    public function setHeaderOutput($enable = false)
    {
        $this->setOpt(CURLINFO_HEADER_OUT, $enable);
    }

    public function setPostField($data)
    {
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
    }

    /**
     * TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
     * @param boolean $enable
     */
    public function setReturnTransfer($enable = true)
    {
        $this->setOpt(CURLOPT_RETURNTRANSFER, $enable);
    }

    /**
     * Execute the given cURL session.
     */
    public function exec()
    {
        return curl_exec(self::$ch);
    }

    /**
     * Gets information about the last transfer
     * @return mixed
     */
    public function info()
    {
        return curl_getinfo(self::$ch);
    }

    public function __destruct()
    {
        error_log(curl_error(self::$ch));
        curl_close(self::$ch);
    }
}