<?php 
namespace App\Core;

use App\Core\Uri;
use App\Core\Body;

class Request{
    
    function __construct(
        private Uri $uri,
        private $method,
        private Body $body
        )
    {}

    function getUri() : Uri {
        return $this->uri;
    }

    function getMethod() : string {
        return $this->method;
    }

    function getBody() : Body {
        return $this->body;
    }

    function setMethod(string $method) : self {
        $this->method = $method;
        return $this;
    }

    function setBody(Body $body) : self {
        $this->body = $body;
        return $this;
    }
}
