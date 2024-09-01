<option value="">اختار عملة التبادل</option>
@if($currency_exchange_results)
    @foreach($currency_exchange_results['currency_exchanges'] as $currency_exchange_result)
        <option value="{{$currency_exchange_result['currency_exchange_id']}}" data-currencyexchangename="{{$currency_exchange_result['currency_exchange_name']}}" data-currencyexchangevalue="{{$currency_exchange_result['currency_exchange_value']}}">{{$currency_exchange_result['currency_exchange_name']}} - {{$currency_exchange_result['currency_exchange_value']}}</option>
    @endforeach
@endif

