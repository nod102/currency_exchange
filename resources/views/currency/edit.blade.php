@extends('layouts.master')
@section('admin_content')

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
                            <form action="{{ route('currencies.update', $id) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

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

                                    <div class="form-group col-md-8">
                                        <label class="form-label" for="exampleInputText1">اسم العملة </label>
                                        <input type="text" name="currency_name" required class="form-control"
                                            id="exampleInputText1" value="{{$result_page['currency_name']}}" required placeholder="اسم العملة">
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
