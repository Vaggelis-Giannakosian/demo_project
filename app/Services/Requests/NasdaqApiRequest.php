<?php


namespace App\Services\Requests;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class NasdaqApiRequest implements ApiRequestContract
{

    private $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
    private $cache;
    private $http;

    public function __construct(Cache $cache, Http $http)
    {
        $this->cache = $cache;
        $this->http = $http;
    }

    public function get(): Collection
    {

        if ($this->cache::has('company_symbols')) {
            $companySymbols = $this->cache::get('company_symbols');
        } else {
            $companyApiResponse = $this->http::get($this->url)->json();
            $companySymbols = collect($companyApiResponse)->unique('Symbol')->pluck('Symbol');
            $this->cache::put('company_symbols', $companySymbols, 600);
        }

        return $companySymbols;
    }
}
