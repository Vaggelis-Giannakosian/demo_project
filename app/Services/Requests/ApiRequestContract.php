<?php


namespace App\Services\Requests;

use Illuminate\Support\Collection;


interface ApiRequestContract
{

    public function get() : Collection;

}
