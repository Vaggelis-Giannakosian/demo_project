<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function today()
    {
        return  today()->format('Y-m-d');
    }

     protected function tomorrow()
     {
         return  today()->addDay(1)->format('Y-m-d');
     }

     protected function yesterday()
     {
         return  today()->subDay(1)->format('Y-m-d');
     }

}
