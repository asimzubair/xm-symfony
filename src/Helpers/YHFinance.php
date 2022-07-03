<?php

namespace App\Helpers;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class YHFinance
{
    const ENDPOINT = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=";

    public static function getHistoricalData( $companySymbol )
    {
        try
        {
            $apiEndpoint = self::ENDPOINT.$companySymbol;
            $apiResponse =  self::__sendRequest( $apiEndpoint, "get yh-finance historical data for company $companySymbol" );
            return $apiResponse['content'] ?? [];
        }
        catch (\Exception $e)
        {
            #log exception here
            return [];
        }
    }

    private static function __sendRequest( $url, $title='', $method = 'GET', $requestBody = [], $format = 'json' )
    {   
        $headers = [
            "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com",
            "X-RapidAPI-Key" => $_ENV['RAPIDAPI_KEY']
        ];

        $apiResponse = Helper::apiRequest( $method, $url, [], $requestBody, $headers, $format, true);
        
        #Log third party here
        #$responseCode = $apiResponse['code'] ?? 0;
        #ThirdPartyApiCallLog::logNasdaqResponse($url, $method, $responseCode, $requestBody, $apiResponse, $title);
        
        return $apiResponse;
    }
}