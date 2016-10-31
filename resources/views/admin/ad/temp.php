                                <div class="form-group required {{ $errors->has('ad_price_type_1') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
                                    <label for="ad_price_type_1" class="control-label">{{ trans('publish_edit.Price') }}</label>
                                    <div>
                                        <div class="pull-left checkbox"><input type="radio" name="price_radio" id="price_radio" value="1" {{ Util::getOldOrModelValue('price_radio', $ad_detail, 'ad_price') > 0 ? 'checked' : '' }}></div>
                                        <div class="pull-left" style="margin-left:5px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="ad_price_type_1" name="ad_price_type_1" value="{{ Util::getOldOrModelValue('ad_price_type_1', $ad_detail, 'ad_price') }}" />
                                                <div class="input-group-addon">{{ config('dc.site_price_sign') }}</div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div>
                                            <label class="radio-inline">
                                                @if(empty(old('price_radio')) && $ad_detail->ad_free == 1)
                                                    <input type="radio" name="price_radio" id="price_radio" value="2" checked> {{ trans('publish_edit.Free') }}
                                                @else
                                                    <input type="radio" name="price_radio" id="price_radio" value="2" {{ Util::getOldOrModelValue('price_radio', $ad_detail) == 2 ? 'checked' : '' }}> {{ trans('publish_edit.Free') }}
                                                @endif
                                            </label>
                                        </div>

                                        <div class="clearfix"></div>

                                        @if ($errors->has('ad_price_type_1'))
                                            <div class="clearfix"></div>
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ad_price_type_1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>