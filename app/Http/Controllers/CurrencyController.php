<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class CurrencyController extends Controller
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
        $currencies = File::get(base_path('public/currency.json'));
        $results = json_decode($currencies);
        return view('currency.index', compact('results', 'dpage_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dpage_id = "currency_add";
        return view('currency.add', compact('dpage_id'));
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
                'currency_name'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }


            $currency_exchanges = [];
            for($i = 0; $i < count($request->currency_exchange_name); $i++) {
                if($request->currency_exchange_name[$i] != null){
                    $currency_exchange_id = $i+1;
                    $add_currency_exchanges = ['currency_exchange_id'=>$currency_exchange_id, 'currency_exchange_name'=>$request->currency_exchange_name[$i], 'currency_exchange_value' =>$request->currency_exchange_value[$i]];
                    array_push($currency_exchanges,$add_currency_exchanges);
                }
            }

            $currency = [];
            $last_currency_id = 0;

            if(File::exists(base_path('public/currency.json'))) {
                $currencies = File::get(base_path('public/currency.json'));
                $all_currencies = json_decode($currencies);
                if(!empty($all_currencies)){
                    $currency = $all_currencies;
                    $last_record = end($all_currencies);
                    $last_currency_id = $last_record->currency_id;
                }
            }

            $currency_id = $last_currency_id +1;

            $add_currency = ['currency_id'=>$currency_id, 'currency_name'=>$request->currency_name, 'currency_exchanges'=>$currency_exchanges];
            array_push($currency,$add_currency);

            $add_currency = json_encode($currency);
            $txt = File::put(base_path('public/currency.json'), $add_currency);

            return redirect(route('currencies.index'))->with('success_error', 'Saved successfully');
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
        $currencies = File::get(base_path('public/currency.json'));
        $get_currencies = json_decode($currencies, true);

        $currency_exchange_results = [];
        foreach($get_currencies as $key => $get_currency) {
            if($get_currency['currency_id'] == $id) {
                $currency_exchange_results = $get_currencies[$key];
            }
        }

        return view('currency.view', compact('currency_exchange_results', 'id'));
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
        $currencies = File::get(base_path('public/currency.json'));
        $get_currencies = json_decode($currencies, true);

        foreach($get_currencies as $key => $get_currency) {
            if($get_currency['currency_id'] == $id) {
                $result_page = $get_currencies[$key];
            }
        }

        return view('currency.edit', compact('result_page', 'dpage_id', 'id'));
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
                'currency_name'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }

            $currencies = File::get(base_path('public/currency.json'));
            $get_currencies = json_decode($currencies, true);

            foreach($get_currencies as $key => $get_currency) {
                if($get_currency['currency_id'] == $id) {
                    $get_currencies[$key]['currency_name'] = $request->currency_name;
                }
            }

            $get_currencies = array_values($get_currencies);
            $add_currency = json_encode($get_currencies);

            $txt = File::put(base_path('public/currency.json'), $add_currency);

            return redirect(route('currencies.index'))->with('success_error', 'Saved successfully');
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
            $currencies = File::get(base_path('public/currency.json'));
            $get_currencies = json_decode($currencies, true);

            foreach($get_currencies as $key => $get_currency) {
                if($get_currency['currency_id'] == $id) {
                    unset($get_currencies[$key]);
                }
            }
            $get_currencies = array_values($get_currencies);
            $add_currency = json_encode($get_currencies);

            $txt = File::put(base_path('public/currency.json'), $add_currency);
            return redirect()->back()->with('success_error', 'Deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('failed_error', 'Sorry, an error occurred, please try again');
        }
    }

}
