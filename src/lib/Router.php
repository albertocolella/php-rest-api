<?php

namespace TcRest\lib;
use TcRest\lib\exceptions\RestException;
class Router {
    private $routes;
    private $settings;
    
    public function __construct($routes, $settings) {
        $this->routes = $routes;
        $this->settings = $settings;
    }
    
    function callRoute(){
        $path = $this->getPath();
        $path = explode('/', $path);            
        $controller_info = $this->getController(array_shift($path));
        $c = $controller_info['controller'];        
        if (!isset($_SERVER['HTTP_ORIGIN']) && isset($_SERVER['SERVER_NAME'])) {
            $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
        }
        try {
            if(!$c){
              throw new RestException('No address selected', 500);
              echo json_encode(array('error' => $e->getMessage()));
            }
            $method = $this->getMethod();
            $request = $this->getRequest($method);
            $dbc = $this->settings['adapter']['class'];
            $db = $dbc::getInstance($this->settings['adapter']);
            $ctr = new $c($request, $db);
            $code = call_user_func(array(&$ctr, strtolower($method)), $path);
            http_response_code($code);
        } catch (RestException $e) {
          http_response_code($e->getCode());
          echo json_encode(array('error' => $e->getMessage()));
        }
    }
    
    function getRequest($method){
        switch($method){
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            case 'DELETE':
            case 'PUT':
                $post_vars = array();
                parse_str(file_get_contents("php://input"),$post_vars);
                $_REQUEST = $post_vars + $_REQUEST;
                return $_REQUEST;
            default:
                http_response_code(405);
                return json_encode(array('error' => 'Method not supported'));            
        }
    }
    
    function getMethod(){
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD'])) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $method = 'PUT';
            } else {
                throw new RestException("Unexpected Header", 500);
            }
        }
        return $method;
    }
    
    function getController($path){
        if(isset($this->routes[$path])){
            return $this->routes[$path];
        }
        return false;
    }
    
    function getPath(){
        $path_info = '';
        if(!empty($_SERVER['PATH_INFO'])){
            $path_info = $_SERVER['PATH_INFO'];
        } else if(!empty($_SERVER['ORIG_PATH_INFO'])){
            $path_info = $_SERVER['ORIG_PATH_INFO'];
        }
        return ltrim($path_info,'/');
    }
    
    protected function http_response_code($code = NULL) {
        if (function_exists('http_response_code')) {
            return http_response_code($code);
        }
        if ($code !== null) {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }
        return $code;
    }
    
}
