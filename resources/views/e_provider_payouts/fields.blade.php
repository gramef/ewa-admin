@if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Method Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('method', trans("lang.e_provider_payout_method"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('method', ['Bank' => trans('lang.bank'),'Cash' => trans('lang.cash')], null, ['class' => 'select2 form-control', 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_method_help") }}</div>
        </div>
    </div>

    <!-- Full Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('full_name', trans("lang.e_provider_payout_full_name"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_full_name_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_full_name_help") }}</div>
        </div>
    </div>

    <!-- Bank Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('bank_name', trans("lang.e_provider_payout_bank_name"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_bank_name_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_bank_name_help") }}</div>
        </div>
    </div>

    <!-- Account Number Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('account_number', trans("lang.e_provider_payout_account_number"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('account_number', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_account_number_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_account_number_help") }}</div>
        </div>
    </div>

    <!-- IBAN Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('iban', trans("lang.e_provider_payout_iban"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('iban', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_iban_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_iban_help") }}</div>
        </div>
    </div>

    <!-- Sort Code Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('sort_code', trans("lang.e_provider_payout_sort_code"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('sort_code', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_sort_code_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_sort_code_help") }}</div>
        </div>
    </div>


    @if(auth()->user()->hasRole('admin'))
        <!-- Receipt PDF Upload Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('receipt_pdf', trans("lang.e_provider_payout_receipt_pdf"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
            <div class="col-md-9">
                {!! Form::file('receipt_pdf', ['class' => 'form-control']) !!}
                <div class="form-text text-muted">{{ trans("lang.e_provider_payout_receipt_pdf_help") }}</div>
            </div>
        </div>
    @endif

</div>
<div class="d-flex flex-column col-sm-12 col-md-6">
    @if(auth()->user()->hasRole('provider'))
        <!-- E Provider Id Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('e_provider_id', trans("lang.e_provider_payout_e_provider_id"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
            <div class="col-md-9">
                {!! Form::select('e_provider_id', $eProvider, null, ['data-empty'=>trans("lang.e_provider_payout_e_provider_id_placeholder"), 'class' => 'select2 not-required form-control',]) !!}
                <div class="form-text text-muted">{{ trans("lang.e_provider_payout_e_provider_id_help") }}</div>
            </div>
        </div>
    @endif
    @if(auth()->user()->hasRole('admin'))
            <!-- E Provider Id Field -->
            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                {!! Form::label('e_provider_id', trans("lang.e_provider_payout_e_provider_id"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                <div class="col-md-9">
                    {{Form::hidden('e_provider_id', request('id'))}}
                    {{$eProvider->name}}
                </div>
            </div>
    @endif
    <!-- Amount Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('amount', trans("lang.e_provider_payout_amount"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_amount_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">{{setting('default_currency','$')}}</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Note Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('note', trans("lang.e_provider_payout_note"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => trans("lang.e_provider_payout_note_placeholder"), 'readonly' => auth()->user()->hasRole('admin')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_provider_payout_note_help") }}</div>
        </div>
    </div>



    @if($eProviderPayoutFile)
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('receipt_pdf', trans("lang.e_provider_payout_receipt_pdf"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
            <div class="col-md-9">
                <a href="{{ asset('storage/app/public/' . $eProviderPayoutFile) }}" target="_blank" class="btn btn-default">
                    {{ trans('lang.view_receipt') }}
                </a>
            </div>
        </div>
    @endif
</div>

@if($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <!-- Paid Checkbox -->
    @if(auth()->user()->hasRole('provider'))
        <div class="d-flex flex-row justify-content-between align-items-center">
            {!! Form::label('paid', trans("lang.e_provider_payout_paid"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('paid', 0, ['id'=>"hidden_paid"]) !!}
            <span class="icheck-{{setting('theme_color')}}">
                {!! Form::checkbox('paid', 1, null) !!} <label for="paid"></label> </span>
        </div>
    @endif
    <button type="submit" class="btn bg-{{ setting('theme_color') }} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.e_provider_payout') }}
    </button>

    <a href="{!! route('eProviderPayouts.index') !!}" class="btn btn-default">
        <i class="fas fa-undo"></i> {{ trans('lang.cancel') }}
    </a>
</div>
