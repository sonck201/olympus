<div class="rev_slider_wrapper">
	<div id="revolution{{$widget->id}}" class="rev_slider">
		<ul>
			@if (count((array) $banner) > 0 )
				@foreach ( $banner as $b )
					@php $b->image = \App\Models\Image::render($b->image) @endphp
					@php $feature = json_decode($b->feature) @endphp
					
					<li data-transition="random" data-link="{{$b->href}}" data-target="{{$b->target}}">
						<img src="{{$b->image}}" alt="{{$b->title}}" class="rev-slidebg" data-bgparallax="15">
						@if ( !is_null($feature) && isset($feature->{'data-frames'}) && count($feature->{'data-frames'}) > 0 )
							@php 
							$arrAttr = ['frames', 'x', 'y', 'hoffset', 'voffset', 'width', 'height', 'title', 'class'];
							$countAttr = [];
							@endphp
							@foreach ($arrAttr as $a)
								@php $countAttr[] = count($feature->{'data-'. $a}) @endphp
							@endforeach
							@php $layers = min($countAttr) @endphp
							
							@for($i=0; $i<$layers; $i++)
							<div class="{!!$feature->{'data-class'}[$i]!!}" data-x="{!!$feature->{'data-x'}[$i]!!}" data-y="{!!$feature->{'data-y'}[$i]!!}" data-hoffset="{!!$feature->{'data-hoffset'}[$i]!!}" data-voffset="{!!$feature->{'data-voffset'}[$i]!!}" data-width="{!!$feature->{'data-width'}[$i]!!}" data-height="{!!$feature->{'data-height'}[$i]!!}" data-frames='{!!$feature->{"data-frames"}[$i]!!}'>{{$feature->{'data-title'}[$i]}}</div>
							@endfor
						@endif
					</li>
				@endforeach
			@else
				No data to render
			@endif
		</ul> 
		<div class="tp-bannertimer" style="height: 5px; background-color: rgba(0, 0, 0, .25);"></div>
	</div>
</div>

<link rel="stylesheet" href="{{asset('public/plugins/revolution/css/settings.css')}}" />
<link rel="stylesheet" href="{{asset('public/plugins/revolution/css/layers.css')}}" />
<script type="text/javascript" src="{{asset('public/plugins/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript">
	$( function(){
		$('#revolution{{$widget->id}}').revolution({
			delay: '{{$config->interval}}',
			sliderLayout: '{{$config->sliderLayout}}',
			autoHeight: '{{$config->autoHeight}}',
			minHeight: '{{$config->minHeight}}',
			navigation: {
				keyboardNavigation: 'on',
			    keyboard_direction: 'horizontal',
			    onHoverStop: 'on',
				arrows: {
                    enable: true,
                    style: '{{$config->navigationArrow}}',
                    hide_onleave: false
                },
                bullets: {
                	enable: true,
                    style: '{{$config->navigationBullet}}',
                    direction: 'horizontal',
                    rtl: false,
                    container: 'slider',
                    h_align: 'center',
                    v_align: 'bottom',
                    h_offset: 0,
                    v_offset: 20,
                    space: 5,
                },
                touch: {
                    touchenabled: '{{$config->touchEnabled}}',
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: 'horizontal',
                    drag_block_vertical: true
                }
			},
			parallax: {
		        type: '{{$config->parallaxType}}',
		        origo: 'slidercenter',
		        speed: 400,
		        levels: [5,10,15,20,25,30,35,40,45,46,47,48,49,50,51,55],
		        disable_onmobile: 'on'
		    },
		});
	});
</script>