@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Magic Keywords') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.Magic Keywords') }}</li>
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

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin_common.All Magic Keywords') }}</h3>
        </div>
        <!-- /.box-header -->

        <form method="get" name="list_form" id="list_form">
        {!! csrf_field() !!}

            <div class="controls">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <button type="submit" onclick="$('#list_form').attr('action', '{{ url('admin/magic/delete') }}');" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
                </div>

                <a href="{{ url('admin/magic/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-o"></i> {{ trans('admin_common.New Magic Keyword') }}</a>
            </div>

            <div class="box-body">
                @if($mkList->isEmpty())
                    {{ trans('admin_common.There are no magic keywords.') }}
                @else
                    <div class="table-responsive">
                        <table id="ad_list_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('admin_common.#Id') }}</th>
                                    <th>{{ trans('admin_common.Keyword') }}</th>
                                    <th>{{ trans('admin_common.Count') }}</th>
                                    <th>{{ trans('admin_common.Url') }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control filter_field" name="keyword_id_search" id="keyword_id_search" value="{{ isset($params['keyword_id_search']) ? $params['keyword_id_search'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="keyword" id="keyword" value="{{ isset($params['keyword']) ? $params['keyword'] : ''}}" /></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;" name="search_submit" id="search_submit" onclick="$('#list_form').attr('action', '{{ url('admin/magic') }}');">
                                            <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('admin_common.Search') }}
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mkList as $k => $v)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="keyword_id[]" value="{{ $v->keyword_id }}">
                                        </td>
                                        <td>{{ $v->keyword_id }}</td>
                                        <td>{{ $v->keyword }}</td>
                                        <td>{{ $v->keyword_count }}</td>
                                        <td>{{ $v->keyword_url }}</td>
                                        <td><a href="{{ url('admin/magic/edit/' . $v->keyword_id) }}"><i class="fa fa-edit"></i> {{ trans('admin_common.Edit') }}</a></td>
                                        <td><a href="{{ url('admin/magic/delete/' . $v->keyword_id) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> {{ trans('admin_common.Delete') }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                {{ $mkList->appends($params)->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
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