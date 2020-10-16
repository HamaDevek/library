@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-book"></i>
        </span> Resrvationes </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            </li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="mdi mdi-checkbox-marked-circle font-32"></i><strong class="pr-1">Success !</strong>
                    {{session('success')}}
                </div>
                @endif
                @if(count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="mdi mdi-close-circle font-32"></i><strong class="pr-1">Error !</strong> {{$error}}
                </div>
                @endforeach
                @endif

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Resrvationes</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="cat" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body " style="overflow: auto">

                                        <h4 class="mt-0 header-title">Resrvationes table</h4>
                                        
                                        <table id="datatable-buttons" cellspacing="0"
                                            class="table table-striped table-bordered dt-responsive nowrap datatable "
                                            style="border-collapse: collapse; border-spacing: 0; ">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student Name</th>
                                                    <th>Student Phone</th>
                                                    <th>Book Name</th>
                                                    <th>Amount</th>
                                                    <th>State</th>
                                                    <th>Created By</th>
                                                    <th>Financial penalty</th>
                                                    <th>Days</th>
                                                    <th>Backed Date</th>
                                                    <th>Expire Date</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$value->student->s_name}}</td>
                                                    <td>{{$value->student->s_phone}}</td>
                                                    <td>{{$value->book->b_name}}</td>
                                                    <td>{{$value->g_amount}}</td>
                                                    <td>{!! $value->g_state == 1 ?'<span
                                                            class="badge bg-success badge-pill">Done</span>' :'<span
                                                            class="badge bg-danger badge-pill">Not Backed</span>' !!}
                                                    </td>
                                                    <td>{{$value->admin->name}}</td>
                                                    <td>{{$value->g_price}}</td>
                                                    @php
                                                    $temp = '0 day';
                                                    $back = new DateTime($value->g_back);
                                                    $expire = new DateTime($value->g_expire);
                                                    if($expire < $back){ $temp=date_diff($back, $expire)->format('%R%a days'); } @endphp <td>
                                                        {{ $value->g_state == 1 ? $temp :'' }}</td>
                                                        <td>{{$value->g_back}}</td>
                                                        <td>{{$value->g_expire}}</td>
                                                        <td>{{$value->created_at}}</td>
                                                        <td>
                                                            <div class="btn-group m-b-10">
                                                                <button type="button"
                                                                    class="btn btn-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Actions</button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{route('resrvation.edit',$value->id)}}">{{ $value->g_state == 1 ? 'Not Backed' :'Done'}}</a>
                                                                    
                                                                    <div class="dropdown-divider"></div>
                                                                    <form
                                                                        action="{{route('resrvation.destroy',$value->id)}}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger">Delete</button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                                
                                                @endforeach
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
    </div>
</div>
@endsection