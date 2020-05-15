<?php


namespace App\Services\Requests;


use App\Contracts\ApiRequestContract;
use Illuminate\Support\Collection;

class HistoryApiRequest implements ApiRequestContract
{
    private $apiKey = 'ca36972eeamshff71fe5a5fd18fbp1e0659jsnaf99340b1541';

    private $queryString;

    public function __construct(string $queryString)
    {
        $this->queryString = $queryString;
    }



    public function get(): Collection
    {
        // TODO: Implement get() method.
    }
}
