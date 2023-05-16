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
				@if($screenshot)
				<form method="get" action="/admin/media/destroy/">
				<div class="row">
					
                  	@foreach($screenshot as $row)
						<div class="col-md-2" style="height: 100px;margin-bottom:100px;">
							<div class="checkbox">
								<label><input type="checkbox" class="checkbox" value="{{$row->id}}" name="checked[]"></label><br />

							</div>
							<a href="{{$row->url}}" data-source="http://500px.com/photo/32736307" title="Into The Blue" style="width:193px;height:125px;">
<image class="imageGallery" width="150" height="150" src="{{$row->url}}">
	</a>
						  
						</div>
					@endforeach
					<div class="col-md-12">
						
						<button class="btn btn-danger">Delete</button>
					</div>
				</div>		
				</form>		  
                 @endif
            </div>
				{{ $screenshot->links('custom-pagination-links') }}
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