<div class='btn-group btn-group-sm'>
    @can('eProviderPayouts.edit')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.e_provider_payout_edit')}}" href="{{ route('eProviderPayouts.edit', $id) }}" class='btn btn-link'>
            <i class="fas fa-edit"></i> </a>
    @endcan

</div>
