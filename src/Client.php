<?php

namespace Aisdk;

use Dadata\Response\Order;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

class Client
{


    const METHOD_GET = 'GET';
    
    const METHOD_POST = 'POST';
    
    const METHOD_PUT = 'PUT';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $token;
 
     /**
     * @var ClientInterface
     */
     protected $httpClient;
 
    /**
     * @var array
     */
    protected $httpOptions = [];

    
    public function __construct($baseUrl, ClientInterface $httpClient, array $config = [])
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
        foreach ($config as $name => $value) {
            $this->$name = $value;
        }
    }


    /**
     * Prepares URI for the request.
     *
     * @param string $endpoint
     * @return string
     */
    protected function prepareUri($endpoint)
    {
        return $this->baseUrl . '/' . $endpoint;
    }


    public function auth($username, $password)
    {
        $uri = $this->prepareUri('auth');

        $headers = [
            'Content-Type'  => 'application/json',
        ];

        $params = array('username'=>$username, 'password'=>$password);

        $request = new Request(self::METHOD_POST, $uri, $headers , json_encode($params));

        $response = $this->httpClient->send($request, $this->httpOptions);

        $result = json_decode($response->getBody(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error parsing response: ' . json_last_error_msg());
        }

        if (empty($result)) {
            throw new RuntimeException('Empty result');
        }

        if (!is_array($result)) {
            throw new RuntimeException('Bad result');
        }

        if (!array_key_exists('token', $result)) {
            return $result;
        }

        $this->token = $result['token'];
        return true;
    }



    /**
     * Requests API.
     *
     * @param string $uri
     * @param array  $params
     *
     * @param string $method
     *
     * @return array
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    protected function query($uri, array $params = [], $method = self::METHOD_POST)
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $request = new Request($method, $uri, $headers, 0 < count($params) ? json_encode($params) : null);
        $response = $this->httpClient->send($request, $this->httpOptions);
        
        $body = $response->getBody();

        //print $body;
        
        $result = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error parsing response: ' . json_last_error_msg());
        }
        return $result;
    }


    public function getOrders($page = 1)
    {
        return $this->query($this->prepareUri('orders?page='.$page), [], self::METHOD_GET);
    }

    public function getOrder($id)
    {
        return $this->query($this->prepareUri('orders/'.$id), [], self::METHOD_GET);
    }

    public function getDcardForOrder($id)
    {
        return $this->query($this->prepareUri('orders/'.$id.'/dcard'), [], self::METHOD_GET);
    }

    public function getMetaForOrder($id)
    {
        return $this->query($this->prepareUri('orders/'.$id.'/meta'), [], self::METHOD_GET);
    }


    public function createOrder(array $data = [])
    {
       $data = ['Orders'=>$data];
       return $this->query($this->prepareUri('orders'), $data, self::METHOD_POST);
    }
   
    public function updateOrder($id, array $data = [])
    {
       $data = ['Orders'=>$data];
       return $this->query($this->prepareUri('orders/'.$id), $data, self::METHOD_PUT);
    }



}
