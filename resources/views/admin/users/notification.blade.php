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
											  <table class="table table-responsive">
									    	  @foreach($device->deviceLog as $val)
												@php $record = json_decode($val->record) @endphp
											    @if($record->app != "com.hola")
												 <tr>
													<td>{{ $record->app }}</td>
													<td>
															{{ $record->title }}
														{{ $record->titleBig}}
														@foreach($record->groupedMessages as $gm)
                                                                       @if(!empty($gm->text))
                                                                        <b>{{ $gm->title }}</b> : {{ $gm->text }} <br/>
                                                                      
                                                                      @endif
                                                                      @endforeach
													</td>
									  			 </tr>
												@endif
											   @endforeach
										     </table>
											
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