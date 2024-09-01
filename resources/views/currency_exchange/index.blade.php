
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
                                        <h4 class="card-title">عرض قيمة التبادل</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                                            <thead>
                                                <tr>
                                                    <th>اسم العملة</th>
                                                    <th> قيمة التبادل</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($results)
                                                @foreach($results as $result_currency)
                                                @foreach($result_currency->currency_exchanges as $result_page)
                                                <tr>
                                                        <td>{{$result_page->currency_exchange_name}}</td>
                                                        <td>{{$result_page->currency_exchange_value}}</td>
                                                            <td>
                                                                <a class="btn btn-sm btn-icon text-primary flex-end" data-bs-toggle="tooltip" href="{{ route('currencies.currency_exchange.edit',[$result_currency->currency_id,$result_page->currency_exchange_id]) }}" aria-label="تعديل العملة" data-bs-original-title="تعديل العملة">
                                                                    <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                                <a class="btn btn-sm btn-icon text-danger " data-bs-toggle="tooltip" href="javascript:void(0)" onclick="if(confirm('Are you sure you want to delete')){event.preventDefault();document.getElementById('delete-form-{{$result_page->currency_exchange_id}}').submit();}else{event.preventDefault();}" aria-label="حذف العملة" data-bs-original-title="حذف العملة">
                                                                    <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                                <form id="delete-form-{{$result_page->currency_exchange_id}}" method="post" action="{{ route('currency_exchange.destroy',$result_page->currency_exchange_id) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="currency_id" value="{{$result_currency->currency_id}}">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endforeach
                                                        @endif

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

            </div>
        </div>

@endsection
