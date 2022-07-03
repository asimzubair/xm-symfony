<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Helper
{
    public static function apiRequest($method, $url, $queryParams = [], $body = [], $headers = [], $contentType = 'json', $returnWithStatusCode = false, $extras = [])
    {
        $response = [];
        try
        {
            if (is_array($queryParams) && count($queryParams) > 0)
            {
                $url .= '?' . http_build_query($queryParams);
            }

            $payload = [
                $contentType => $body,
                'headers' => $headers,
                'http_errors' => false,
                'timeout' => $extras['timeout'] ?? 45,
                'connect_timeout' => $extras['connect_timeout'] ?? 45,
            ];

            $client = new Client();
            $curlResponse = $client->request($method, $url, $payload );
            if( $returnWithStatusCode )
            {
                $response['code'] =  $curlResponse->getStatusCode();
                $response['content'] =  json_decode($curlResponse->getBody()->getContents(), true);
            }
            else
            {
                $response = json_decode($curlResponse->getBody()->getContents(), true);
            }
        }
        catch (RequestException $e)
        {
            #log exception here
        }
        catch (\Exception $e)
        {
            #log exception here
        }
        finally
        {
            return $response;
        }
    }
}
