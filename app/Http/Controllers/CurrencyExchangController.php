<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class CurrencyExchangController extends Controller
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
    public function index($id)
    {
        $dpage_id = "currency_list";
        $currencies = File::get(base_path('public/currency.json'));
        $get_currencies = json_decode($currencies);
        $results = array_filter($get_currencies, function($item) use ($id){
            return $item->currency_id == $id;
        });

        return view('currency_exchange.index', compact('results', 'dpage_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($currency_id)
    {
        $dpage_id = "currency_add";
        return view('currency_exchange.add', compact('dpage_id', 'currency_id'));
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
                'currency_id'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }

            $currency = [];
            $last_currency_id = 0;


            $currencies = File::get(base_path('public/currency.json'));
            $get_currencies = json_decode($currencies, true);

            foreach($get_currencies as $key => $get_currency) {
                if($get_currency['currency_id'] == $request->currency_id) {
                    foreach($get_currency['currency_exchanges'] as $key_one_currency => $one_currency) {
                            $last_record = end($get_currencies[$key]['currency_exchanges']);
                            $currency_exchange_id = $last_record['currency_exchange_id'];
                    }

                    $get_currencies[$key]['currency_exchanges'];
                    for($i = 0; $i < count($request->currency_exchange_name); $i++) {
                        if($request->currency_exchange_name[$i] != null){
                            $currency_exchange_id = $currency_exchange_id + 1;
                            $add_currency_exchanges = ['currency_exchange_id'=>$currency_exchange_id, 'currency_exchange_name'=>$request->currency_exchange_name[$i], 'currency_exchange_value' =>$request->currency_exchange_value[$i]];
                            array_push($get_currencies[$key]['currency_exchanges'],$add_currency_exchanges);
                        }
                    }

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
    public function edit($currency_id, $currency_exchange_id)
    {
        $dpage_id = "currency_list";
        $currencies = File::get(base_path('public/currency.json'));
        $get_currencies = json_decode($currencies, true);

        foreach($get_currencies as $key => $get_currency) {
            if($get_currency['currency_id'] == $currency_id) {
                foreach($get_currency['currency_exchanges'] as $key_one_currency => $one_currency) {
                    if($one_currency['currency_exchange_id'] == $currency_exchange_id) {
                        $result_page = $get_currencies[$key]['currency_exchanges'][$key_one_currency];
                    }
                }
            }
        }

        return view('currency_exchange.edit', compact('result_page', 'dpage_id', 'currency_id', 'currency_exchange_id'));
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
                'currency_exchange_name'=>'required',
                'currency_exchange_value'=>'required'
            ]);

            if($validateData->fails()){
                return redirect()->back()->with('failed_error', $validateData->errors()->first());
            }

            $currencies = File::get(base_path('public/currency.json'));
            $get_currencies = json_decode($currencies, true);

            foreach($get_currencies as $key => $get_currency) {
                if($get_currency['currency_id'] == $request->currency_id) {
                    foreach($get_currency['currency_exchanges'] as $key_one_currency => $one_currency) {
                        if($one_currency['currency_exchange_id'] == $id) {
                            $get_currencies[$key]['currency_exchanges'][$key_one_currency]['currency_exchange_name'] = $request->currency_exchange_name;
                            $get_currencies[$key]['currency_exchanges'][$key_one_currency]['currency_exchange_value'] = $request->currency_exchange_value;
                        }
                    }
                }
            }

            $get_currencies = array_values($get_currencies);
            $add_currency = json_encode($get_currencies);

            $txt = File::put(base_path('public/currency.json'), $add_currency);

            return redirect(route('currencies.currency_exchange.index', $request->currency_id))->with('success_error', 'Saved successfully');
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
    public function destroy(Request $request, $currency_id)
    {
        try{
            $currencies = File::get(base_path('public/currency.json'));
            $get_currencies = json_decode($currencies, true);

            foreach($get_currencies as $key => $get_currency) {
                if($get_currency['currency_id'] == $request->currency_id) {
                    foreach($get_currency['currency_exchanges'] as $key_one_currency => $one_currency) {
                        if($one_currency['currency_exchange_id'] == $currency_id) {
                            unset($get_currencies[$key]['currency_exchanges'][$key_one_currency]);
                        }
                    }
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
