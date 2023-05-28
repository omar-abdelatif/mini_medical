@extends('layouts.app')
@section('header')
    <header class="header header-sticky">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-menu') }}"></use>
                </svg>
            </button>
            <a class="header-brand d-md-none" href="#">
                <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('icons/brand.svg#full') }}"></use>
                </svg>
            </a>
            <ul class="header-nav d-none d-md-flex">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">لوحة التحكم</a>
                </li>
            </ul>
            <ul class="header-nav ms-auto"></ul>
            <ul class="header-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <svg class="icon me-2">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('My profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-account-logout') }}"></use>
                                </svg>
                                {{ __('Logout') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="header-divider"></div>
        <section class="content-header w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 d-inline-flex align-items-center justify-content-between w-100">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">الرئيسية</a>
                            </li>
                            <li class="breadcrumb-item active">كل المقابر</li>
                        </ol>
                        <button type="button" class="btn btn-success" data-coreui-toggle="modal" data-coreui-target="#addnew" data-coreui-whatever="@mdo">
                            <b>إضافة تشخيص</b>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </header>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="diagnoses">
                <div class="diagmoses-title text-center text-white bg-dark p-3 rounded mt-5 w-50 mx-auto">
                    <h2>التشخيصات السابقة "ل{{$patient->name}}"</h2>
                </div>
                <div class="diagnoses-content">
                    @if (session('success'))
                        <div class="alert alert-success text-center mt-5">
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    @elseif ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger text-center mt-5">
                                <p class="mb-0">{{ $error }}</p>
                            </div>
                        @endforeach
                    @endif
                    <table id="table" class="table table-dark table-hover table-striped borderd-table display align-middle text-center mt-5" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">تاريخ التشخيص</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            @if ($diagnosesCount > 0)
                                @foreach ($diagnoses as $diagnose)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">{{ $diagnose->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning rounded" data-coreui-toggle="modal" data-coreui-target="#edit{{$diagnose->id}}" data-coreui-whatever="@mdo">
                                                <b>المزيد</b>
                                            </button>
                                            <div class="modal fade" id="edit{{$diagnose->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title text-decoration-underline text-dark" id="exampleModalLabel">تعديل التشخيص الخاص ب{{$patient->name}}</h1>
                                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-dark">
                                                            <form action="{{route('diagnoses.update')}}" method="post">
                                                                @csrf
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <input type="hidden" class="form-control" name="id" value="{{$diagnose->id}}">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="diagnose">
                                                                                    <b>التشخيص</b>
                                                                                </label>
                                                                                <textarea name="diagnose" id="diagnose" class="form-control mb-3 text-center pt-3" id="diagnose" cols="30" rows="10" placeholder="التشخيص الكامل">{{$diagnose->diagnose}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="cure">
                                                                                    <b>العلاج</b>
                                                                                </label>
                                                                                <textarea name="cure" class="form-control mb-3 text-center pt-3" id="cure" cols="30" rows="10" placeholder="العلاج">{{$diagnose->cure}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="field mt-3">
                                                                                <button type="submit" class="btn btn-success w-100 text-white">
                                                                                    <b>تعديل</b>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{route('diagnoses.destroy', $diagnose->id)}}" class="btn btn-danger">
                                                <b>حذف</b>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h1 class="text-center mt-4">لا توجد تشخيصات</h1>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-decoration-underline" id="exampleModalLabel">إضافة بيانات جديدة</h1>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark-gradient">
                    <form action="{{route('diagnoses.create')}}" method="post">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <input type="hidden" name="id" value="{{$patient->id}}">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="diagnose">
                                            <b>التشخيص</b>
                                        </label>
                                        <textarea name="diagnose" id="diagnose" class="form-control mb-3 text-center pt-3" id="diagnose" cols="30" rows="10" placeholder="التشخيص الكامل"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cure">
                                            <b>العلاج</b>
                                        </label>
                                        <textarea name="cure" class="form-control mb-3 text-center pt-3" id="cure" cols="30" rows="10" placeholder="العلاج"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field mt-3">
                                        <button type="submit" class="btn btn-success w-100 text-white">
                                            <b>إضافة</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
