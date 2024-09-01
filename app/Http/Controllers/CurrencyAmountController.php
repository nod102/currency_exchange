<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use App\Models\CurrencyAmount;

class CurrencyAmountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpage_id = "currency_list";
        $results = CurrencyAmount::get();
        return view('currency_amount.index', compact('results', 'dpage_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dpage_id = "currency_add";
        $currencies = File::get(base_path('public/currency.json'));
        $currency_results = json_decode($currencies);
        return view('currency_amount.add', compact('dpage_id', 'currency_results'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //validation
            $validateData = Validator::make($request->all(), [
                'currency_id'=>'required',
                'currency_exchange_id'=>'required',
                'amount'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }

            $new_data = new CurrencyAmount;
            $new_data->currency_id = $request->currency_id;
            $new_data->currency_exchange_id = $request->currency_exchange_id;
            $new_data->amount = $request->amount;
            $new_data->currency_name = $request->currency_name;
            $new_data->currency_exchange_name = $request->currency_exchange_name;
            $new_data->currency_exchange_value = $request->currency_exchange_value;
            $new_data->save();

            return redirect(route('currency_amount.index'))->with('success_error', 'Saved successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('failed_error', 'Sorry, an error occurred, please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dpage_id = "currency_list";
        $result_page = CurrencyAmount::find($id);

        $currencies = File::get(base_path('public/currency.json'));
        $currency_results = json_decode($currencies, true);

        $currency_exchange_results = [];
        foreach($currency_results as $key => $get_currency) {
            if($get_currency['currency_id'] == $result_page->currency_id) {
                $currency_exchange_results = $currency_results[$key];
            }
        }

        return view('currency_amount.edit', compact('result_page', 'dpage_id', 'currency_results', 'currency_exchange_results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            //validation
            $validateData = Validator::make($request->all(), [
                'currency_id'=>'required',
                'currency_exchange_id'=>'required',
                'amount'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }

            $new_data = CurrencyAmount::find($id);
            $new_data->currency_id = $request->currency_id;
            $new_data->currency_exchange_id = $request->currency_exchange_id;
            $new_data->amount = $request->amount;
            $new_data->currency_name = $request->currency_name;
            $new_data->currency_exchange_name = $request->currency_exchange_name;
            $new_data->currency_exchange_value = $request->currency_exchange_value;
            $new_data->save();

            return redirect(route('currency_amount.index'))->with('success_error', 'Saved successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('failed_error', 'Sorry, an error occurred, please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $new_data = CurrencyAmount::find($id);
            $new_data->delete();
            return redirect()->back()->with('success_error', 'Deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('failed_error', 'Sorry, an error occurred, please try again');
        }
    }

}
