@extends('layouts.master')
@section('admin_content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        jQuery('.page_num').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });

        //
        $('#add3').click(function() {
            $('.block:last').before(
                '<div class="form-group col-md-12 optionBox33"><div class="row"><div class="form-group col-md-4"><input type="text" name="currency_exchange_name[]" class="form-control" placeholder="اسم عملة التبادل"></div><div class="form-group col-md-4"><input type="text" name="currency_exchange_value[]" class="form-control page_num" placeholder="قيمة التبادل"></div><span class="remove form-group col-md-2 btn btn-danger">حذف عملة التبادل</span><div class="block addinpy"></div></div></div>'
            );
        });
        $('.optionBox33').on('click', '.remove', function() {
            //var itemId = $(this).attr('id');
            $(this).parent().remove();
            //$(this).parent().hide();
        });
        //
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
                                <h4 class="card-title">اضف عملة</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('currency_exchange.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="currency_id" required value="{{$currency_id}}">

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

                                    <div class="form-group col-md-12 optionBox33">
                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <input type="text" name="currency_exchange_name[]" class="form-control"
                                                    placeholder="اسم عملة التبادل">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="currency_exchange_value[]"
                                                    class="form-control page_num" placeholder="قيمة التبادل">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <span class="btn btn-primary" id="add3">اضف عملة تبادل جديدة</span>
                                            </div>

                                            <div class="block addinpy"></div>
                                        </div>
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
