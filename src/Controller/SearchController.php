<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\YHFinance;

class SearchController extends AbstractController
{
    /**
     * @Route("/", name="search_form")
     */
    public function index()
    {
        return $this->render('search.html.twig');
    }

    /**
     * @Route("/search", name="search_json")
     */
    public function search(Request $request)
    {
        $dateRangeData = [];

        try
        {
            $historicalData = YHFinance::getHistoricalData( $request->get('companySymbol') );
            $dateRangeData = self::__filterDataByDateRange( $historicalData, $request->get('startDate'), $request->get('endDate') );
        }
        catch (\Exception $e)
        {
            #log exception here
        }
        finally
        {
            return $this->json([
                $dateRangeData
            ]);
        }
    }

    private static function __filterDataByDateRange( $historicalData, $startDate, $endDate )
    {
        $filteredHistoricalData = [];
        if(isset($historicalData['prices']))
        {
            foreach( $historicalData['prices'] as $price )
            {
                $priceDate = date('Y-m-d', $price['date']);
                if( $priceDate >= $startDate &&  $priceDate <= $endDate )
                {
                    $price['date'] = $priceDate;
                    $filteredHistoricalData[] = $price;
                }
            }
        }

        return $filteredHistoricalData;
    }
}
