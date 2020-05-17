<?php

namespace App\Http\Controllers;


use App\Events\SearchFormSubmitted;
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
        //get validated data
        $validatedData = $request->validated();

        //make Api Request
        $historyApiRequest->prepare($validatedData)->get();

        //get company name for symbol
        $validatedData['company'] = $nasdaqApiRequest->get()->getCompanyNameBySymbol($validatedData['company_symbol']);

        //dispatch search form submitted event
        event( new SearchFormSubmitted($validatedData) );

        // return view
        return view('results_table',[
            'tableData'=>$historyApiRequest->getTableData(),
            'openClosedPricesGraphData'=>$historyApiRequest->getGraphData(),
            'formData' => $validatedData
        ]);
    }

}
