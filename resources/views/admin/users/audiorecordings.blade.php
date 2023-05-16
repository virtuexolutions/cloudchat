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
				<input type="checkbox" class="btn btn-primary" id="select-all-checkbox"> Select All
				<form method="get" action="/admin/audio/destroy/">
              <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                 	<th>#</th>
					<th>Divice #</th>
					<th>File</th>
					<th>Date</th>
		        </tr>
                </thead>
                <tbody>
                  @if($recording)
                  @foreach($recording as $row)
                    <tr>
						<td><input type="checkbox" class="checkbox" value="{{$row->id}}" name="checked[]"></label></td>
						<td>{{$row->device_id}}</td>
                         <td>
							 <audio controls>
								  <source src="data:audio/mp4;base64, {{$row->file}}" type="audio/ogg">
							</audio>
						</td>
						<td>{{$row->created_at}}</td>
					</tr>
                  @endforeach
                  @endif
                </tbody>
			
						
					
              </table>
		 </br></br>
						<button class="btn btn-danger">Delete</button>
		   </br>
	</form>
				{{ $recording->links('custom-pagination-links') }}
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
<script>
	$(document).ready(function(){
  // Check or uncheck all checkboxes
  $('#select-all-checkbox').click(function(){
    $('.checkbox').prop('checked', this.checked);
  });

  // Check "Select All" checkbox if all checkboxes are checked
  $('.checkbox').change(function(){
    var allChecked = true;
    $('.checkbox').each(function(){
      if(!this.checked){
        allChecked = false;
      }
    });
    $('#select-all-checkbox').prop('click', allChecked);
  });
});
</script>
@endsection