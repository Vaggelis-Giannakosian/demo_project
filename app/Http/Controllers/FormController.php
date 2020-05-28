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

        //check for null api response and return to index
        if(( $historyApiData = $historyApiRequest->getTableData() ) === null)
            return redirect()
                ->back()
                ->withStatus('There was an unexpected error. Please try again');

        //get company name for symbol
        $validatedData['company'] = $nasdaqApiRequest->get()->getCompanyNameBySymbol($validatedData['company_symbol']);

        //dispatch search form submitted event
        event( new SearchFormSubmitted($validatedData) );

        // return view
        return view('results_table',[
            'tableData'=>$historyApiData,
            'openClosedPricesGraphData'=>$historyApiRequest->getGraphData(),
            'formData' => $validatedData
        ]);
    }

}
