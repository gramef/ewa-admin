<div class='btn-group btn-group-sm'>
    @can('eProviderSubscriptions.destroy')
        <a href="{{ route('eProviderSubscriptions.extend', $id) }}" 
           class="btn btn-link text-success"
           onclick="return confirm('Extend this subscription by 30 days?')"
           title="Extend by 30 days">
            <i class="fas fa-calendar-plus"></i> Extend
        </a>
        {!! Form::open(['route' => ['eProviderSubscriptions.destroy', $id], 'method' => 'delete']) !!}
        {!! Form::button('<i class="fas fa-ban"></i> Cancel', [
            'type' => 'submit',
            'class' => 'btn btn-link text-danger',
            'onclick' => "return confirm('Are you sure you want to cancel this subscription?')"
        ]) !!}
        {!! Form::close() !!}
    @endcan
</div>
