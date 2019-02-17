<a href="#" class="btn btn-xs btn-link upP {{$max == true ? 'disabled' : null}}" data-direction="up">
	<i class="fa fa-fw fa-caret-up"></i>
</a>
<a class="btn btn-xs number {{$min == true && $max == true ? 'btn-danger' : 'btn-default'}} disabled">{{$priority}}</a>
<a href="#" class="btn btn-xs btn-link downP {{$min == true ? 'disabled' : null}}" data-direction="down">
	<i class="fa fa-fw fa-caret-down"></i>
</a>