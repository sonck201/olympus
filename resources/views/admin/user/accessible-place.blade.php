@if( isset($accessiblePlace) && is_array($accessiblePlace) )
@foreach( $accessiblePlace as $ap )
<span class="bg-info"><a href="#" class="btn btn-xs btn-default"><i class="fa fa-fw fa-info-circle"></i></a>{{ ucwords($ap) }}</span>
@endforeach
@else
<span class="text-danger"><i class="fa fa-fw fa-times-circle"></i>No accessible places</span>
@endif