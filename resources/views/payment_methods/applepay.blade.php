<h5 class="col-12 pb-4">{!! trans('lang.app_setting_apple_pay_credentials') !!}</h5>
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Boolean Enabled Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('enable_apple_pay', trans("lang.app_setting_enable_apple_pay"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        {!! Form::hidden('enable_apple_pay', 0, ['id'=>"hidden_enable_apple_pay"]) !!}
        <div class="col-9 icheck-{{setting('theme_color')}}">
            {!! Form::checkbox('enable_apple_pay', 1, setting('enable_apple_pay')) !!}
            <label for="enable_apple_pay"></label>
        </div>
    </div>
</div>
<div class="d-flex flex-column col-sm-12 col-md-6">

</div>
