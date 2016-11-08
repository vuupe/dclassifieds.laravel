    <div class="modal fade" tabindex="-1" role="dialog" id="quick-category-select-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('publish_edit.Close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('publish_edit.Quick Select') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="breadcrumb" id="quick-category-select-breadcrump" style="background-color: #eff0f1; padding-left:5px;">
                                <li><a href="" class="category_selector btn-block" style="display:inline;" data-id="0">{{ trans('publish_edit.Start') }}</a></li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="quick-category-select-container">
                                @if(isset($first_level_childs) && !$first_level_childs->isEmpty())
                                    @foreach($first_level_childs as $k => $v)
                                        <a href="" class="category_selector btn-block" data-id="{{ $v->category_id }}">{{ $v->category_title }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="quick_category_loader"><img src="{{ asset('images/small_loader.gif') }}" /></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('publish_edit.Close') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->