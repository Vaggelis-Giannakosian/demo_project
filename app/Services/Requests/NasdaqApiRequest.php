<?php


namespace App\Services\Requests;


use App\Contracts\ApiRequestContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class NasdaqApiRequest implements ApiRequestContract
{

    private $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
    private $cache;
    private $http;
    private $apiResponse;

    public function __construct(Cache $cache, Http $http)
    {
        $this->cache = $cache;
        $this->http = $http;
        $this->apiResponse = [];
    }

    public function get(): ApiRequestContract
    {

        if ($this->cache::has('company_symbols')) {
            $this->apiResponse = $this->cache::get('company_symbols');
        } else {
            $this->apiResponse = $this->http::get($this->url)->json();
            $this->cache::put('company_symbols',  $this->apiResponse, 600);
        }

        return $this;
    }


    public function symbolsArray(): Collection
    {
        return collect( $this->apiResponse)->unique('Symbol')->pluck('Symbol');
    }

    public function companyNameBySymbol(?string $symbol) : ?string
    {
        $companiesNames = collect( $this->apiResponse)->unique('Symbol')->pluck('Security Name','Symbol')->toArray();
            return $companiesNames[$symbol] ?? null;
    }
}
