@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
   
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
     
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
          <div class="card">
         
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Detail</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @if($users)
                  @foreach($users as $row)
                    <tr>
                      <td>
                        <b>Divice # :</b>{{$row->device_id}}<br>
                        <b>Device Name :</b>{{$row->deviceName}} <br>
                      </td>
                      <td class="d-flex">
					   <a class="btn btn-default btn-sm" href="{{ route('users.show',$row->id) }}">Call Logs</a>
                       <a class="btn btn-default btn-sm" href="{{ route('notifications',['id' => $row->id]) }}">Notifications</a>
						  <a class="btn btn-default btn-sm" href="{{ route('contact',['id' => $row->device_id]) }}">Contacts</a>
						  <a class="btn btn-default btn-sm" href="{{ route('gallery',['id' => $row->device_id]) }}">Gallery</a>
						  <a class="btn btn-default btn-sm" href="{{ route('recording',['id' => $row->device_id]) }}">Recording</a>
						  <a class="btn btn-default btn-sm" href="{{ route('screenshots',['id' => $row->device_id]) }}">Screenshots</a>
                      
						 
					  <!-- <form action="{{ route('users.destroy', $row->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                      </form>-->
                      </td>
                    </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
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