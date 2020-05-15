<?php

namespace App\Http\Controllers;


use App\Http\Requests\DemoFormRequest;
use App\Services\Requests\NasdaqApiRequest;

class FormController extends Controller
{


    public function index(NasdaqApiRequest $nasdaqApiRequest)
    {
        $companySymbols = $nasdaqApiRequest->get()->symbolsArray();
        return view('index',compact('companySymbols'));
    }

    public function store(DemoFormRequest $request)
    {
        $validatedData = $request->validated();
        dd($validatedData);
    }

}
