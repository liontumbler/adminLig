<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class CustomExceptions extends Exception
{
    private $msg = '';
    private $cod = '';
    public function __construct($cod, $msg)
    {
        $this->cod = $cod;
        $this->msg = $msg;
        $statusCodes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        
        if (array_key_exists($cod, $statusCodes)) {
            parent::__construct($statusCodes[$cod]);
        } else {
            parent::__construct($statusCodes[500]);
        }
    }

    public function report()
    {
        //TODO:mandar mail, notificacion a teams preguntando si esta en en ambiente desarrollo o QA
        $cadena = '';
        foreach ($this->getTrace() as $value) {
            $cadena .= $value['function']."\n";
        }
        Log::error($this->msg.":".$this->getMessage().":".$this->getFile().":".$this->getLine().":\n".$cadena);
    }

    public function render()
    {
        return response()->view('error.custom', ['exception' => $this], $this->cod);
    }
}
//TODO: implementar: throw new \App\Exceptions\CustomExceptions(500, $e->getMessage());