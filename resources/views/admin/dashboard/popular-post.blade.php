<a class="list-group-item" href="{{ route('adminPostEdit', ['id' => $p->id]) }}">
	<b class="text-primary">{{ str_limit($p->title, 35) }}</b> 
	<small class="text-danger"><i class="fa fa-fw fa-user"></i>{{$p->userName}}</small>
	<small><i class="fa fa-fw fa-calendar"></i>{{ str_limit($p->createdAt, 10) }}</small>
	<span class="badge hasTooltip" title="Visit">{{$p->visit}}<i class="fa fa-eye"></i></span>
</a>