@extends('layouts.master')
@section('admin_content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        jQuery('.page_num').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });
        //
        $(document).on("change", "#currency_id", function () {
            var currency_id = this.value;
            var map_url = "{{route('currencies.show','id')}}";
            var currency_name = document.getElementById('currency_name');
            currency_name.value = $(this).find("option:selected").attr('data-currencyname');

            map_url = map_url.replace('id', currency_id);
            $.get(map_url, function(data){
                $("#currency_exchange_id").html(data);
            });
        });

        $(document).on("change", "#currency_exchange_id", function () {
            var currency_exchange_name = document.getElementById('currency_exchange_name');
            var currency_exchange_value = document.getElementById('currency_exchange_value');
            currency_exchange_name.value = $(this).find("option:selected").attr('data-currencyexchangename');
            currency_exchange_value.value = $(this).find("option:selected").attr('data-currencyexchangevalue');
        });

    });
</script>

<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">اضف كمية</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('currency_amount.update', $result_page->id) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <input type="hidden" name="currency_name" id="currency_name" value="{{$result_page->currency_name}}">
                                <input type="hidden" name="currency_exchange_name" id="currency_exchange_name" value="{{$result_page->currency_exchange_name}}">
                                <input type="hidden" name="currency_exchange_value" id="currency_exchange_value" value="{{$result_page->currency_exchange_value}}">

                                @if(session('success_error'))
                                <div class="alert alert-success" role="alert">
                                    {{session('success_error')}}
                                </div>
                                @endif

                                @if(session('failed_error'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('failed_error')}}
                                </div>
                                @endif

                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="exampleInputText1">اختار اسم العملة </label>
                                        <select name="currency_id" id="currency_id" required class="form-control">
                                            <option value="">اختار العملة</option>
                                            @if($currency_results)
                                                @foreach($currency_results as $currency_result)
                                                    <option value="{{$currency_result['currency_id']}}" {{$currency_result['currency_id'] == $result_page->currency_id ? "selected" : ""}} data-currencyName="{{$currency_result['currency_name']}}">{{$currency_result['currency_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="exampleInputText1">اختار عملة التبادل </label>
                                        <select name="currency_exchange_id" id="currency_exchange_id" required class="form-control">
                                            <option value="">اختار عملة التبادل</option>
                                            @if($currency_exchange_results['currency_exchanges'])
                                                @foreach($currency_exchange_results['currency_exchanges'] as $currency_exchange_result)
                                                    <option value="{{$currency_exchange_result['currency_exchange_id']}}" {{$currency_exchange_result['currency_exchange_id'] == $result_page->currency_exchange_id ? "selected" : ""}} data-currencyexchangename="{{$currency_exchange_result['currency_exchange_name']}}" data-currencyexchangevalue="{{$currency_exchange_result['currency_exchange_value']}}">{{$currency_exchange_result['currency_exchange_name']}} - {{$currency_exchange_result['currency_exchange_value']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="exampleInputText1">الكمية </label>
                                        <input type="text" name="amount" required class="form-control page_num"
                                            id="exampleInputText1" placeholder="الكمية" value="{{$result_page->amount}}">
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
