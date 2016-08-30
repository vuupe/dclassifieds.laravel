@extends('admin.layout.admin_index_layout')
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ads
        <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ads</li>
      </ol>
    </section>
    
    

    <!-- Main content -->
    <section class="content">
    
    @if (session()->has('message'))
    <div class="alert alert-info alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-info"></i> Information</h4>
		{!! session('message') !!}
	</div>
	@endif
    
	
    	<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">All Ads</h3>
              
            </div>
            <!-- /.box-header -->
            
            <form method="post" name="list_form" id="list_form" action="{{ url('admin/category/delete') }}">
            {!! csrf_field() !!}
            
	            <div class="controls">
	            	<div class="btn-group">
	            		<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
	            		<button type="submit" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
	            	</div>
	            </div>
	              
	            <div class="box-body">
	              
	              <table id="ad_list_table" class="table table-bordered table-striped table-hover">
	                <thead>
	                <tr>
	                	<th></th>
	                  	<th>#Id</th>
	                  	<th>Location</th>
	                  	<th>Ad Title</th>
	                  	<th>Ad Promo</th>
	                  	<th>Publish Date</th>
	                  	<th>Active</th>
	                  	<th>Num Views</th>
	                  	<th></th>
	                  	<th></th>
	                </tr>
	                </thead>
	                <tbody>
	                
	                </tbody>
	              </table>
	              
	            </div>
            <!-- /.box-body -->
            </form>
            
            
         </div>
         <!-- /.box -->
    

    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}" />
    <!-- iCheck -->
  	<link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
    <!-- iCheck -->
	<script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
    
    <script>
    $(function () {
        $('#ad_list_table').DataTable({"order": [], 
            "pageLength": 10,
           	"ajax": '<?=url('admin/ad/axlist')?>',
           	"serverSide": true,
           	"columns": [
                        { "orderable": false },
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        { "orderable": false },
                        { "orderable": false }
                      ]
        });

        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $("input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $("input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });
	});
    </script>
@endsection
