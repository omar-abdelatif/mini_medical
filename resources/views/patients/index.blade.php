@extends('layouts.app')
@section('header')
    <header class="header header-sticky nav-success">
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
                    <a class="nav-link" href="{{ route('dashboard.index') }}">لوحة التحكم</a>
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
                                <a href="{{ route('dashboard.index') }}">الرئيسية</a>
                            </li>
                            <li class="breadcrumb-item active">كل المقابر</li>
                        </ol>
                        <button type="button" class="btn btn-success" data-coreui-toggle="modal" data-coreui-target="#addnew" data-coreui-whatever="@mdo">
                            <b>إضافة ظابط</b>
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
            <div class="form">
                <div class="form-title text-center mt-5 bg-dark p-3 text-white w-50 mx-auto rounded">
                    <h2>كل البيانات</h2>
                </div>
                <div class="form-content mt-5">
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
                                <th class="text-center">الإسم</th>
                                <th class="text-center">الرقم القومي</th>
                                <th class="text-center">المحمول</th>
                                <th class="text-center">الرتبة</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($patientsCount > 0)
                            <?php $i = 1 ?>
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="text-center">{{$patient->name}}</td>
                                        <td class="text-center">{{$patient->ssn}}</td>
                                        <td class="text-center">{{$patient->phone}}</td>
                                        <td class="text-center">{{$patient->degree}}</td>
                                        <td class="text-center">
                                            <a href="{{url('destroy/'.$patient->id)}}" class="btn btn-danger text-white">
                                                <b>حذف</b>
                                            </a>
                                            <button type="button" class="btn btn-warning rounded" data-coreui-toggle="modal" data-coreui-target="#edit{{$patient->id}}" data-coreui-whatever="@mdo">
                                                <b>عرض</b>
                                            </button>
                                            <div class="modal fade" id="edit{{$patient->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title text-decoration-underline text-dark" id="exampleModalLabel">تعديل {{$patient->name}}</h1>
                                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-dark">
                                                            <form action="{{route('lieutenant.update')}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <input type="hidden" class="form-control" name="id" value="{{$patient->id}}">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="name">
                                                                                    <b>الإسم</b>
                                                                                </label>
                                                                                <input type="text" name="name" class="form-control mb-3" value="{{$patient->name}}" id="name" placeholder="الإسم كامل">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="phone">
                                                                                    <b>المحمول</b>
                                                                                </label>
                                                                                <input type="number" class="form-control mb-3" value="{{$patient->phone}}" name="phone" placeholder="رقم المحمول" id="phone">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="address">
                                                                                    <b>العنوان</b>
                                                                                </label>
                                                                                <input type="text" class="form-control mb-3" name="address" value="{{$patient->address}}" placeholder="العنوان" id="address">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="ssn">
                                                                                    <b>الرقم القومي</b>
                                                                                </label>
                                                                                <input type="number" class="form-control mb-3" name="ssn" value="{{$patient->ssn}}" placeholder="الرقم القومي" id="ssn">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="date">
                                                                                    <b>تاريخ الميلاد</b>
                                                                                </label>
                                                                                <input type="date" class="form-control mb-3" value="{{$patient->birthdate}}" name="birthdate" id="date">
                                                                            </div>
                                                                            <div class="form-group text-center">
                                                                                <label for="male">
                                                                                    <b>ذكر</b>
                                                                                </label>
                                                                                <input type="radio" class="mb-3" name="gender" value="ذكر" id="male" {{$patient->gender == 'ذكر' ? 'checked' : ''}}>
                                                                                <label for="male">
                                                                                    <b>أنثى</b>
                                                                                </label>
                                                                                <input type="radio" class="mb-3" name="gender" value="أنثى" id="male" {{$patient->gender == 'أنثى' ? 'checked' : ''}}>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="military_number">
                                                                                    <b>الرقم العسكري</b>
                                                                                </label>
                                                                                <input type="number" name="military_number" value="{{$patient->military_number}}" class="form-control mb-3" id="military_number" placeholder="الرقم العسكري">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="degree">
                                                                                    <b>الرتبة</b>
                                                                                </label>
                                                                                <input type="text" name="degree" value="{{$patient->degree}}" class="form-control mb-3" id="degree" placeholder="الرتبة">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="specialization">
                                                                                    <b>السلاح</b>
                                                                                </label>
                                                                                <input type="text" name="specialization" value="{{$patient->specialization}}" class="form-control mb-3" id="specialization" placeholder="السلاح">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="image">
                                                                                    <b>الصورة الشخصية</b>
                                                                                </label>
                                                                                <input type="file" name="img" id="image" value="{{$patient->img}}" class="form-control mb-3" accept="image/*">
                                                                            </div>
                                                                            <div class="img">
                                                                                <img src="{{asset('assets/imgs/'.$patient->img)}}" width="100" class="rounded-circle" alt="{{$patient->name}}">
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
                                            <a href="{{route('diagnoses.index', $patient->id)}}" class="btn btn-info">
                                                <b>إضافة تشخيص</b>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h1 class="text-center mt-3">لا توجد بيانات حاليا</h1>
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
                    <form action="{{route('lieutenant.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">
                                            <b>الإسم</b>
                                        </label>
                                        <input type="text" name="name" class="form-control mb-3" id="name" placeholder="الإسم كامل">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">
                                            <b>المحمول</b>
                                        </label>
                                        <input type="number" class="form-control mb-3" name="phone" placeholder="رقم المحمول" id="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">
                                            <b>العنوان</b>
                                        </label>
                                        <input type="text" class="form-control mb-3" name="address" placeholder="العنوان" id="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="ssn">
                                            <b>الرقم القومي</b>
                                        </label>
                                        <input type="number" class="form-control mb-3" name="ssn" placeholder="الرقم القومي" id="ssn">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">
                                            <b>تاريخ الميلاد</b>
                                        </label>
                                        <input type="date" class="form-control mb-3" name="birthdate" id="date">
                                    </div>
                                    <div class="form-group text-center">
                                        <label for="male">
                                            <b>ذكر</b>
                                        </label>
                                        <input type="radio" class="mb-3" name="gender" value="ذكر" id="male">
                                        <label for="female">
                                            <b>أنثى</b>
                                        </label>
                                        <input type="radio" class="mb-3" name="gender" value="ذكر" id="female">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="military_number">
                                            <b>الرقم العسكري</b>
                                        </label>
                                        <input type="number" name="military_number" class="form-control mb-3" id="military_number" placeholder="الرقم العسكري">
                                    </div>
                                    <div class="form-group">
                                        <label for="degree">
                                            <b>الرتبة</b>
                                        </label>
                                        <input type="text" name="degree" class="form-control mb-3" id="degree" placeholder="الرتبة">
                                    </div>
                                    <div class="form-group">
                                        <label for="specialization">
                                            <b>السلاح</b>
                                        </label>
                                        <input type="text" name="specialization" class="form-control mb-3" id="specialization" placeholder="السلاح">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">
                                            <b>الصورة الشخصية</b>
                                        </label>
                                        <input type="file" name="img" id="image" class="form-control mb-3" accept="image/*">
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
