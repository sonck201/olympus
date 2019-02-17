<?php
return [
	'label' => 'Banner',
	'description' => 'Display banner by category.',
	'params' => [
		[
			'name' => 'class_sfx',
			'type' => 'text',
			'label' => 'Class suffix',
			'description' => 'Add a class suffix to a extension.'
		],
		[
			'type' => 'spacer'
		],
		[
			'type' => 'spacer',
			'label' => 'General'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'cat_id',
			'type' => 'database',
			'label' => 'Category',
			'description' => 'Select from one of these categories.',
			'model' => 'App/Models/Category',
			'class' => 'getAllCategory',
			'categoryType' => 'banner'
		],
		[
			'name' => 'banner_type',
			'type' => 'select',
			'label' => 'Banner type',
			'description' => 'Select one of the list of banner type which can be displayed.',
			'default' => 'ccslider',
			'options' => [
				'ccslider' => 'CCSlider',
				'revolution' => 'Revolution slideshow'
			]
		],
		[
			'name' => 'background_color',
			'type' => 'text',
			'label' => 'Background color',
			'description' => 'Background color.',
			'default' => '#ccc'
		],
		[
			'name' => 'width',
			'type' => 'text',
			'label' => 'Width',
			'description' => 'Width of banner.',
			'default' => 1000
		],
		[
			'name' => 'height',
			'type' => 'text',
			'label' => 'Height',
			'description' => 'Height of banner.',
			'default' => 300
		],
		[
			'name' => 'image_width',
			'type' => 'text',
			'label' => 'Image width',
			'description' => 'Image width.',
			'default' => 400
		],
		[
			'name' => 'image_height',
			'type' => 'text',
			'label' => 'Image height',
			'description' => 'Image height.',
			'default' => 300
		],
		[
			'name' => 'interval',
			'type' => 'text',
			'label' => 'Interval',
			'description' => 'Delay between images in ms.',
			'default' => 5000
		],
		[
			'name' => 'caption_display',
			'type' => 'select',
			'label' => 'Caption display',
			'description' => 'Display caption ?.',
			'default' => 'yes',
			'options' => [
				'yes' => 'yes',
				'no' => 'no'
			]
		],
		[
			'name' => 'caption_position',
			'type' => 'select',
			'label' => 'Caption position',
			'description' => 'Caption position.',
			'default' => 'bottom',
			'options' => [
				'top' => 'Top',
				'right' => 'Right',
				'bottom' => 'Bottom',
				'left' => 'Left'
			]
		],
		[
			'type' => 'spacer'
		],
		[
			'type' => 'spacer',
			'label' => 'CC slider options'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'ccslider_effect_type',
			'type' => 'select',
			'label' => 'Effect type',
			'description' => 'Effect type.',
			'default' => '3d',
			'options' => [
				'3d' => '3D effect',
				'2d' => '2D effect'
			]
		],
		[
			'name' => 'ccslider_effect_3d',
			'type' => 'select',
			'label' => '3D Effect',
			'description' => '3D Effect.',
			'default' => 'random',
			'options' => [
				'random' => 'Random',
				'cubeUp' => 'Cube Up',
				'cubeDown' => 'Cube Down',
				'cubeRight' => 'Cube Right',
				'cubeLeft' => 'Cube Left',
				'flipUp' => 'Flip Up',
				'flipDown' => 'Flip Down',
				'flipRight' => 'Flip Right',
				'flipLeft' => 'Flip Left',
				'blindsVertical' => 'Blinds Vertical',
				'blindsHorizontal' => 'Blinds Horizontal',
				'gridBlocksUp' => 'Grid Blocks Up',
				'gridBlocksDown' => 'Grid Blocks Down',
				'gridBlocksRight' => 'Grid Blocks Right',
				'gridBlocksLeft' => 'Grid Blocks Left'
			]
		],
		[
			'name' => 'ccslider_effect_2d',
			'type' => 'select',
			'label' => '2D Effect',
			'description' => '2D Effect.',
			'default' => 'random',
			'options' => [
				'random' => 'Random',
				'cubeUp' => 'Cube Up',
				'fade' => 'Fade',
				'horizontalOverlap' => 'Horizontal Overlap',
				'verticalOverlap' => 'Vertical Overlap',
				'horizontalSlide' => 'Horizontal Slide',
				'verticalSlide' => 'Vertical Slide',
				'horizontalWipe' => 'Horizontal Wipe',
				'verticalWipe' => 'Vertical Wipe',
				'horizontalSplit' => 'Horizontal Split',
				'verticalSplit' => 'Vertical Split',
				'fadeSlide' => 'Fade Slide',
				'circle' => 'Circle',
				'fadeZoom' => 'Fade Zoom',
				'clock' => 'Clock',
				'zoomInOut' => 'Zoom In Out',
				'spinFade' => 'Spin Fade',
				'rotate' => 'Rotate'
			]
		],
		[
			'type' => 'spacer'
		],
		[
			'type' => 'spacer',
			'label' => 'Revolution slideshow options'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'sliderLayout',
			'type' => 'text',
			'label' => 'Slider layout',
			'description' => 'Slider layout.',
			'default' => 'auto'
		],
		[
			'name' => 'autoHeight',
			'type' => 'text',
			'label' => 'Auto height',
			'description' => 'Auto height.',
			'default' => 'off'
		],
		[
			'name' => 'minHeight',
			'type' => 'text',
			'label' => 'Minimum height',
			'description' => 'Minimum height.',
			'default' => 300
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'navigationArrow',
			'type' => 'select',
			'label' => 'Navigation arrow',
			'description' => 'Navigation arrow.',
			'default' => 'hesperiden',
			'options' => [
				'hesperiden' => 'Hesperiden',
				'gyges' => 'Gyges',
				'persephone' => 'Persephone',
				'metis' => 'Metis',
				'uranus' => 'Uranus'
			]
		],
		[
			'name' => 'navigationBullet',
			'type' => 'select',
			'label' => 'Navigation bullet',
			'description' => 'Navigation bullet.',
			'default' => 'hesperiden',
			'options' => [
				'hesperiden' => 'Hesperiden',
				'gyges' => 'Gyges',
				'hermes' => 'Hermes',
				'hephaistos' => 'Hephaistos',
				'persephone' => 'Persephone',
				'erinyen' => 'Erinyen'
			]
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'touchEnabled',
			'type' => 'select',
			'label' => 'Touch enabled',
			'description' => 'Enable Swipe Function : on/off.',
			'default' => 'on',
			'options' => [
				'on' => 'On',
				'off' => 'Off'
			]
		],
		[
			'name' => 'parallaxType',
			'type' => 'select',
			'label' => 'Stop on hover',
			'description' => 'Parallax type.',
			'default' => 'on',
			'options' => [
				'mouse' => 'Mouse',
				'mouse+scroll' => 'Mouse & Scroll'
			]
		]
	]
];