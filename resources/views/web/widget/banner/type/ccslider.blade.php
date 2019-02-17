<div class="container">
	<div id="ccslider{{$widget->id}}" class="slider{{$config->ccslider_effect_type}} ccslider">
		@if (count($banner) > 0 )
			@foreach ( $banner as $b )
			@php $b->image = \App\Models\Image::render($b->image) @endphp
			<img src="{{$b->image}}" alt="{{$b->title}}" data-caption-position="{{$config->caption_position}}" data-href="{{$b->href}}" /> 
			@endforeach
		@else
			No data to render
		@endif
	</div>
</div>

<link rel="stylesheet" href="{{asset('public/plugins/ccslider/css/ccslider.css')}}" />
<style type="text/css">
	.ccslider {background: {{$config->background_color}}}
	.slider3d, .slider2d, #slider2d-frame {width: {{$config->width}}px; height: {{$config->height}}px}
	.slider-timer {left: {{$config->width/2 - 10}}px; top: {{$config->height/2 - 15}}px}
	.slider-caption {width: {{$config->width}}px !important}
</style>
<script type="text/javascript" src="{{asset('public/plugins/ccslider/js/jquery.ccslider.min.js')}}"></script>
@php $ccsliderEffect = 'ccslider_effect_'. $config->ccslider_effect_type @endphp
<script type="text/javascript">
	$( function(){
		$('#ccslider{{$widget->id}}').ccslider({
	        effectType: '{{$config->ccslider_effect_type}}',
	        effect: '{{$config->$ccsliderEffect}}',
	        @if ( $config->ccslider_effect_type == '2d' ) _2dOptions: @else _3dOptions: @endif
	        {
				imageWidth: '{{$config->width}}',
				imageHeight: '{{$config->height}}'
			},
			pauseTime: '{{$config->interval}}',
			@if ($config->caption_display != 'yes' ) captions: false @endif
		});
	});
</script>