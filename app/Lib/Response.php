<?php

namespace App\Lib;

class Response
{
    protected $data;
    protected $status;
    protected $headers;

    public function __construct($data = [], $status = 200, array $headers = [])
    {
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    public static function json($data = [], $status = 200, array $headers = [])
    {
        return new static($data, $status, $headers);
    }

    public function withHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send()
    {
        http_response_code($this->status);
        
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        
        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit;
    }
}