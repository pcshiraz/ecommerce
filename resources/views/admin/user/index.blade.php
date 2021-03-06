@extends('layouts.app')
@section('title', 'کاربرها - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('admin.sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.user') }}">کاربرها</a></li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.user') }}">
                            <div class="form-group">
                                <label for="search">نام/عنوان/شماره/ایمیل</label>
                                <input name="search" id="search" type="text" class="form-control" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i class="fa fa-search"></i>ارسال
                                جستجو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">کاربرها
                    <a href="{{route('admin.user.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i> ایجاد کاربر جدید</a>
                </div>

                <div class="card-body">
                    @include('global.top-table-options',['route' => 'admin.user.export'])

                    @if($users->count())
                    <table id="users" class="table table-hover table-striped table-bordered two-axis" cellspacing="0">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">@sortablelink('last_name', 'نام')</th>
                            <th scope="col">@sortablelink('mobile', 'شماره همراه')</th>
                            <th scope="col">@sortablelink('credit', 'موجودی')</th>
                            <th scope="col">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td scope="row" class="align-middle">
                                    {{$user->name}}
                                </td>
                                <td scope="row" class="align-middle text-center">
                                    {{ $user->mobile }}
                                </td>
                                <td scope="row" class="align-middle text-center">
                                    {{ \App\Utils\MoneyUtil::format($user->credit) }}
                                </td>

                                <td scope="row" class="align-middle">
                                    <a href="{{ route('admin.user.invoice', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-warning"
                                       data-toggle="tooltip" data-placement="top" title="لیست فاکتورهای کاربر"><i
                                                class="fa fa-calculator"></i></a>
                                    <a href="{{ route('admin.user.transaction', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-info"
                                       data-toggle="tooltip" data-placement="top" title="اسناد مالی کاربر"><i
                                                class="fa fa-money"></i></a>
                                    <a href="{{ route('admin.user.ticket', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" data-placement="top" title="درخواست ها و تیکت های کاربر"><i
                                                class="fa fa-ticket"></i></a>
                                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش کاربر"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.user.delete',['id' => $user->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="حذف کاربر"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                    @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $users])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
