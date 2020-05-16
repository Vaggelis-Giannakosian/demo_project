<?php

namespace App\Http\Controllers;


use App\Events\SearchSubmitted;
use App\Http\Requests\DemoFormRequest;
use App\Services\Requests\HistoryApiRequest;
use App\Services\Requests\NasdaqApiRequest;

class FormController extends Controller
{


    public function index(NasdaqApiRequest $nasdaqApiRequest)
    {
        $companySymbols = $nasdaqApiRequest->get()->symbolsArray();
        return view('index',compact('companySymbols'));
    }

    public function store(DemoFormRequest $request, HistoryApiRequest $historyApiRequest,NasdaqApiRequest $nasdaqApiRequest)
    {
        $validatedData = $request->validated();

        //get Api Data
        $historyApiRequest->prepare($validatedData)->get();


        //get company name for symbol
        $validatedData['company'] = $nasdaqApiRequest->get()->companyNameBySymbol($validatedData['company_symbol']);


        //dispatch event
        event( new SearchSubmitted($validatedData) );


        // return view
        return view('results_table',[
            'tableData'=>$historyApiRequest->getTableData(),
            'openClosedPricesGraphData'=>$historyApiRequest->getGraphData(),
            'formData' => $validatedData
        ]);

    }

}
