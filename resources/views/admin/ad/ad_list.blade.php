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
    <?if($adList->isEmpty()){?>
    	There are no ads.
    <?} else {?>
    	<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">All Ads</h3>

            </div>
            <!-- /.box-header -->

            <form method="get" name="list_form" id="list_form">
            {!! csrf_field() !!}

	            <div class="controls">
	            	<div class="btn-group">
	            		<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
	            		<button type="submit" onclick="$('#list_form').attr('action', '{{ url('admin/ad/delete') }}');" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
	            	</div>
	            </div>

	            <div class="box-body">

	              <table id="ad_list_table" class="table table-bordered table-striped table-hover">
	                <thead>
	                <tr>
	                	<th></th>
	                  	<th>#Id</th>
	                  	<th>Ad IP</th>
	                  	<th>Location</th>
	                  	<th>Ad Title</th>
	                  	<th>User #Id</th>
	                  	<th>User Name</th>
	                  	<th>User E-Mail</th>
	                  	<th>Ad Promo</th>
	                  	<th>Publish Date</th>
	                  	<th>Active</th>
	                  	<th>Num Views</th>
	                  	<th></th>
	                  	<th></th>
	                </tr>
	                <tr>
	                	<td></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_id_search" id="ad_id_search" value="{{ isset($params['ad_id_search']) ? $params['ad_id_search'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_ip" id="ad_ip" value="{{ isset($params['ad_ip']) ? $params['ad_ip'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="location_name" id="location_name" value="{{ isset($params['location_name']) ? $params['location_name'] : ''}}" /></td>
	                  	<td width="280px;"><input type="text" class="form-control filter_field" name="ad_title" id="ad_title" value="{{ isset($params['ad_title']) ? $params['ad_title'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="user_id" id="user_id" value="{{ isset($params['user_id']) ? $params['user_id'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_puslisher_name" id="ad_puslisher_name" value="{{ isset($params['ad_puslisher_name']) ? $params['ad_puslisher_name'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_email" id="ad_email" value="{{ isset($params['ad_email']) ? $params['ad_email'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_promo" id="ad_promo" value="{{ isset($params['ad_promo']) ? $params['ad_promo'] : ''}}" /></td>
	                  	<td></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_active" id="ad_active" value="{{ isset($params['ad_active']) ? $params['ad_active'] : ''}}" /></td>
	                  	<td><input type="text" class="form-control filter_field" name="ad_view" id="ad_view" value="{{ isset($params['ad_view']) ? $params['ad_view'] : ''}}" /></td>
	                  	<td colspan="2">
	                  		<button type="submit" class="btn btn-primary" style="width: 100%;" name="search_submit" id="search_submit" onclick="onclick="$('#list_form').attr('action', '{{ url('admin/ad') }}');"">
                            	<span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Search
                        	</button>
                        </td>
	                </tr>
	                </thead>
	                <tbody>
	                
	                <?foreach($adList as $k => $v){?>
	                	@include('admin.common.ad_row')
	                <?}//end of foreach?>
	                
	                </tbody>
	              </table>
	              
	              <div class="row">
		            	<div class="col-md-12">
		                    <nav>
		                        <?=$adList->appends($params)->links()?>
		                    </nav>
		                </div>
		            </div>
	              
	            </div>
            <!-- /.box-body -->
            </form>
            
            
         </div>
         <!-- /.box -->
         
         
    <?}//end of if adlist?>
    

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

        $('.filter_field').keypress(function(e){
        	if(e.which == 13) {
        		e.preventDefault();
            	$('#search_submit').click();
            }    
        });
	});
    </script>
@endsection
