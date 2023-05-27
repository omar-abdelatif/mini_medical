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
    <h1 class="text-center mt-5">This Patient With Name {{$patient->name}} Has Diagnoses With Count
        {{
            $patient->diagnoses
        }}
    </h1>
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
                                        <textarea name="diagnose" id="" class="form-control mb-3 text-center pt-3" id="diagnose" cols="30" rows="10" placeholder="التشخيص الكامل"></textarea>
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
