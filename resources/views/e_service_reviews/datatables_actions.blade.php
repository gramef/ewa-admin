<div class='btn-group btn-group-sm'>
    @can('eServiceReviews.show')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.view_details')}}" href="{{ route('eServiceReviews.show', $id) }}" class='btn btn-link'>
            <i class="fas fa-eye"></i> </a> @endcan

    {{-- Edit removed: Super admins should be able to delete reviews but not edit them --}}

    @can('eServiceReviews.destroy') {!! Form::open(['route' => ['eServiceReviews.destroy', $id], 'method' => 'delete']) !!} {!! Form::button('<i class="fas fa-trash"></i>', [ 'type' => 'submit', 'class' => 'btn btn-link text-danger', 'onclick' => "return confirm('Are you sure you want to delete this review?')" ]) !!} {!! Form::close() !!} @endcan
</div>
