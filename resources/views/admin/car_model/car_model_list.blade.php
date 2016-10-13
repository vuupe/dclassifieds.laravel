@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Car Models') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.Car Models') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
    @if (session()->has('message'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> {{ trans('admin_common.Information') }}</h4>
        {!! session('message') !!}
    </div>
    @endif

    @if($modelData->isEmpty())
        {{ trans('admin_common.There are no car models.') }}
    @else
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin_common.All Car Models') }}</h3>
            </div>
            <!-- /.box-header -->

            <form method="get" name="list_form" id="list_form" action="{{ url('admin/carmodel/delete') }}">
            {!! csrf_field() !!}

                <div class="controls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                        <button type="submit" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
                    </div>

                    <a href="{{ url('admin/carmodel/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-o"></i> {{ trans('admin_common.New Car Model') }}</a>
                    <a href="{{ url('admin/carmodel/import') }}" class="btn btn-primary btn-sm"><i class="fa fa-files-o"></i> {{ trans('admin_common.Import Car Models from csv') }}</a>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="list_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('admin_common.#Id') }}</th>
                                    <th>{{ trans('admin_common.Car Brand/Model') }}</th>
                                    <th>{{ trans('admin_common.Car Brand') }}</th>
                                    <th>{{ trans('admin_common.Car Model') }}</th>
                                    <th>{{ trans('admin_common.Active') }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control filter_field" name="car_model_id_search" id="car_model_id_search" value="{{ isset($params['car_model_id_search']) ? $params['car_model_id_search'] : ''}}" /></td>
                                    <td></td>
                                    <td><input type="text" class="form-control filter_field" name="car_brand_name" id="car_brand_name" value="{{ isset($params['car_brand_name']) ? $params['car_brand_name'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="car_model_name" id="car_model_name" value="{{ isset($params['car_model_name']) ? $params['car_model_name'] : ''}}" /></td>
                                    <td>
                                        <select class="form-control filter_field" name="car_model_active" id="car_model_active">
                                            @foreach($yesnoselect as $k => $v){?>
                                                @if(isset($params['car_model_active']) && is_numeric($params['car_model_active']))
                                                    @if($params['car_model_active'] == $k)
                                                        <option value="{{ $k }}" selected>{{ $v }}</option>
                                                    @else
                                                        <option value="{{ $k }}">{{ $v }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;" name="search_submit" id="search_submit" onclick="$('#list_form').attr('action', '{{ url('admin/carmodel') }}');">
                                            <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('admin_common.Search') }}
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelData as $k => $v)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="car_model_id[]" value="<?=$v['car_model_id']?>">
                                        </td>
                                        <td>{{ $v['car_model_id'] }}</td>
                                        <td>{{ $v->brand->car_brand_name }}/{{ $v['car_model_name'] }}</td>
                                        <td>{{ $v->brand->car_brand_name }}</td>
                                        <td>{{ $v['car_model_name'] }}</td>
                                        <td>
                                            @if($v['car_model_active'] == 1)
                                                <span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
                                            @else
                                                <span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
                                            @endif
                                        </td>
                                        <td><a href="{{ url('admin/carmodel/edit/' . $v['car_model_id']) }}"><i class="fa fa-edit"></i> {{ trans('admin_common.Edit') }}</a></td>
                                        <td><a href="{{ url('admin/carmodel/delete/' . $v['car_model_id']) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> {{ trans('admin_common.Delete') }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <?=$modelData->appends($params)->links()?>
                            </nav>
                        </div>
                    </div>
                </div>
            <!-- /.box-body -->
            </form>
        </div>
        <!-- /.box -->
    @endif
    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
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
