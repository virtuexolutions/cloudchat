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
                    <div class="card">
                        <div class="container">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                 
                                          <b>ID :</b>{{$device->id}}<br>
                                          <b>Divice ID :</b>{{$device->device_id}}<br>
                                          <b>device Name # :</b>{{ $device->deviceName }}<br>
                                          @foreach($device->devicelog as $index => $devlog)
                                            @if($devlog->Status == 1 && !empty($devlog->record) ) 
                                              <h3> Call Logs</h3>
                                                <table class="table">
                                                  <thead>
                                                      <th>Type</th>
													  <th>Name</th>
                                                      <th>phoneNumber</th>
                                                      <th>dateTime</th>
                                                      <th>duration</th>
                                                    </thead>
                                                    @if($devlog->record)
                                                    <tbody>
                                                      @foreach(json_decode($devlog->record) as $k =>$v)
                                                          <tr>
                                                              <td>{{$v->type}}</td>
															  <td>{{$v->name}}</td>
                                                              <td>{{$v->phoneNumber}}</td>
                                                              <td>{{$v->dateTime}}</td>
                                                              <td>{{$v->duration}}</td>
                                                              
                                                          </tr>
                                                      @endforeach
                                                    </tbody>
                                                    @endif
                                              </table>
                                             @endif 
                                          @endforeach 
                                        </div>
                                    </div>
                             
                                </div>
                              
                        </div>
                    </div>
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