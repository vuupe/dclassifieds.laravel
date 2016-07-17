@extends('admin.layout.admin_index_layout')
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Locations
        <small>add/edit locations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Locations</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<?if(empty($location_list)){?>
    	There are no location, go and add some locations.
    <?} else {?>
    	<div class="box">
            <div class="box-header">
              <h3 class="box-title">All Locations</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th>#Id</th>
                  <th>Location Name</th>
                  <th>Location Slug</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($location_list as $k => $v){?>
                	@include('admin.common.location_row', ['v' => $v, 'parent' => []])
                <?}//end of foreach?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    <?}?>

    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}" />
@endsection

@section('js')
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
    
    <script>
    $(function () {
        $('#example1').DataTable({"order": []});
	});
    </script>
@endsection
