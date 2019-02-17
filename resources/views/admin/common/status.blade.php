@if ( $status == 'active' )
<button type="button" class="btn btn-xs btn-success btnActive" data-name="active">
	<i class="fa fa-fw fa-check"></i>
</button>
@elseif ( $status == 'deactive' )
<button type="button" class="btn btn-xs btn-danger btnDeactive" data-name="deactive">
	<i class="fa fa-fw fa-ban"></i>
</button>
@elseif ( $status == 'trash' )
<button type="button" class="btn btn-xs btn-warning" data-name="trash">
	<i class="fa fa-fw fa-trash"></i>
</button>
@endif
