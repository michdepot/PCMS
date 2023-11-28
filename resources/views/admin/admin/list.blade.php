@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>List ({{ $getRecord->total() }})</h1>
              </div>
              <div class="col-sm-6" style="text-align: right">
                <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">Add New Admin</a>
            </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
                <div class="col-11 mx-auto">

                @include('_message')

                <div class="card" style="border-top-left-radius: 15px; border-top-right-radius:15px;">
                  <div class="card-header" style="background-color: #B8DEFF; border-top-left-radius: 15px; border-top-right-radius:15px;">
                    {{-- <h3 class="card-title">Admin</h3> --}}

                        <!-- Search Field -->
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="" action="">
                                    <div class="input-group form-group" style="padding: 20px">
                                        <input type="text" name="searchbar" value="{{ Request::get('searchbar') }}" class="form-control form-control-lg" placeholder="Type your keywords here" style="border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default" style="border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
                                                <i class="fa fa-search"></i>
                                                Search for Admin
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                  </div>

                <!-- form start -->
                <form method="" action="">
                    {{-- {{ csrf_field() }} --}}
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-3">
                            {{-- <label for="name">Name</label> --}}
                            <input type="text" class="form-control" id="name" name="name" value="{{ Request::get('name') }}" placeholder="Search Name" autocomplete="name">
                            </div>

                            <div class="form-group col-md-3">
                                {{-- <label for="email">Email</label> --}}
                                <input type="text" class="form-control" id="email" name="email" value="{{ Request::get('email') }}" placeholder="Search Email" autocomplete="on">
                            </div>

                            <div class="form-group col-md-3">
                                {{-- <label for="email">Email</label> --}}
                                <input type="date" class="form-control" id="date" name="date" value="{{ Request::get('date') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{  url('admin/admin/list') }}" class="btn btn-success">Reset</a>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                    {{-- <!-- card footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.card footer --> --}}

                </form>
                {{-- @include('assets.searchfilter') --}}

                  <!-- /.card-header -->
                  <div class="card-body">

                    {{-- change ID to example1 if needed ang PDF converter --}}
                    <table id="example" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Action</th>
                        {{-- <th>Action</th> --}}
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($getRecord as $value)
                            <tr>
                                <td>{{ $value->id}}</td>
                                <td>{{ $value->name}}</td>
                                <td>{{ $value->email}}</td>
                                <td></td>
                                <td>{{ date('M d, Y (h:i A)', strtotime($value->created_at))}}</td>
                                <td></td>
                                <td>
                                    <a href="{{ url('admin/admin/edit/'.$value->id)}}" class="btn btn-success">Edit</a>
                                    <a href="{{ url('admin/admin/delete/'.$value->id)}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                      {{-- <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Joined</th>
                        <th>Status</th>
                      </tr>
                      </tfoot> --}}
                    </table>
                    <div style="padding:10px; float:right;">
                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                    </div>

                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

@endsection
