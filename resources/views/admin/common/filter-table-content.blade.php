@if ( isset($keyword) && $keyword == true )
<div class="col-xs-6">
	<div class="input-group">
		{!! Form::text('filterKeyword', isset($filter['keywordVal']) ? $filter['keywordVal'] : null, ['class' => 'form-control input-sm', 'placeholder' => 'Input keyword for filter']) !!}
		<span class="input-group-btn"> {!! Form::button('Search', ['class' => 'btn btn-primary btn-sm']) !!} </span>
	</div>
</div>
@endif

@if ( isset($category) && $category == true )
<div class="col-xs-3">
	{!! Form::select('filterCategory', $filter['category'], isset($filter['categoryVal']) ? $filter['categoryVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($format) && $format == true )
<div class="col-xs-3">
	{!! Form::select('filterFormat', $filter['format'], isset($filter['formatVal']) ? $filter['formatVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($role) && $role == true )
<div class="col-xs-3">
	{!! Form::select('filterRole', $filter['role'], isset($filter['roleVal']) ? $filter['roleVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($status) && $status == true )
<div class="col-xs-3">
	{!! Form::select('filterStatus', $filter['status'], isset($filter['statusVal']) ? $filter['statusVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($date) && $date == true )
<div class="col-xs-3">
	{!! Form::select('filterCreated_At', $filter['date'], isset($filter['dateVal']) ? $filter['dateVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($visit) && $visit == true )
<div class="col-xs-3">
	{!! Form::select('filterVisit', $filter['visit'], isset($filter['visitVal']) ? $filter['visitVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($pageview) && $pageview == true )
<div class="col-xs-3">
	{!! Form::select('filterPageview', $filter['pageview'], isset($filter['pageviewVal']) ? $filter['pageviewVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($updated) && $updated == true )
<div class="col-xs-3">
	{!! Form::select('filterUpdated_At', $filter['updated'], isset($filter['updatedVal']) ? $filter['updatedVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($logged) && $logged == true )
<div class="col-xs-3">
	{!! Form::select('filterLogged_At', $filter['logged'], isset($filter['loggedVal']) ? $filter['loggedVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($position) && $position == true )
<div class="col-xs-3">
	{!! Form::select('filterPosition', $filter['position'], isset($filter['positionVal']) ? $filter['positionVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif

@if ( isset($widgetType) && $widgetType == true )
<div class="col-xs-3">
	{!! Form::select('filterType', $filter['type'], isset($filter['typeVal']) ? $filter['typeVal'] : null, ['class' => 'form-control input-sm']) !!}
</div>
@endif