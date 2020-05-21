<?php


namespace App\Services\Requests;


use App\Adapters\DateToTimeAdapter;
use App\Contracts\ApiRequestContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class HistoryApiRequest implements ApiRequestContract
{
    private $apiKey;
    private $host = 'apidojo-yahoo-finance-v1.p.rapidapi.com';
    private $url = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v2/get-historical-data?';
    private $apiResponse;
    private $queryString;
    private $http;
    private $headers;

    public function __construct( HTTP $http)
    {
        $this->http = $http;
        $this->apiKey = env('HISTORY_API_KEY');
    }


    public function get(): ApiRequestContract
    {
        $this->apiResponse = collect($this->http::withOptions([
            'verify' => false,
           ])->withHeaders($this->headers)
            ->get($this->url.$this->queryString)
            ->json());

        return $this;
    }

    public function getTableData() : array
    {
        return $this->apiResponse['prices'] ?? [];
    }

    public function getGraphData () : array
    {
        $graphData = [];

        if(empty($this->apiResponse['prices']))
            return $graphData;

        collect($this->apiResponse['prices'])->each(function($row) use (&$graphData){
            if(!isset($row['type']))
            {
                $graphData [] = [$row['date']*1000, (float)$row['open'], (float)$row['close']];
            }
        });

        return array_reverse($graphData);
    }

    public function prepare(array $params) : self
    {
        $this->queryString = $this->createQueryString($params);
        $this->headers = $this->createRequestHeaders();
        return $this;
    }

    private function createQueryString(array $params):string
    {
        $queryArray = [
            'frequency' => '1d',
            'filter'=>'history',
            'period1' => DateToTimeAdapter::toTime($params['start_date']),
            'period2' => DateToTimeAdapter::toTime($params['end_date']),
            'symbol' => $params['company_symbol']
        ];
        return http_build_query($queryArray,'','&');
    }

    private function createRequestHeaders(): array
    {
        $headersArray = [
            'useQueryString'=>'true',
            'x-rapidapi-key'=>$this->apiKey,
            'x-rapidapi-host'=>$this->host,
        ];

        return $headersArray;
    }
}
