<?php
return [
	'label' => 'Counter',
	'description' => 'This Plugin can caculator which how many visiters come to your site.',
	'params' => [
		[
			'name' => 'class_sfx',
			'type' => 'text',
			'label' => 'Class suffix',
			'description' => 'Add a class suffix to a extension'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'initialvalue',
			'type' => 'text',
			'label' => 'Counter initial value',
			'description' => 'The counter begin from this number',
			'default' => 0
		],
		[
			'name' => 'digit_type',
			'type' => 'select',
			'label' => 'Digital counter type',
			'description' => 'The counter type of digit',
			'default' => 'default',
			'options' => [
				'default' => 'Default',
				'bluesky' => 'Blue Sky',
				'blushdw' => 'Blue Shadow',
				'bubble' => 'Bubble',
				'creampuff' => 'Cream Puff',
				'curly' => 'Curly',
				'embwhite' => 'Embossed',
				'gold' => 'Gold',
				'ledgreen' => 'Led Green',
				'ledred' => 'Led Red',
				'ledyellow' => 'Led Yellow',
				'links' => 'Links',
				'odoblack' => 'Odometer Black',
				'odowhite' => 'Odometer White',
				'plainblue' => 'Plain Blue',
				'silkscreen' => 'Silk Screen',
				'twotone' => 'Two Tone',
				'wedgie' => 'Wedgie',
				'rainbow' => 'Rainbow',
				'colorful' => 'Colorful',
				'sticker' => 'Sticker'
			]
		],
		[
			'name' => 'number_digits',
			'type' => 'select',
			'label' => 'Min number digits',
			'description' => 'The totally number of digit to display (the default is 6)',
			'default' => 6,
			'options' => [
				1 => 1,
				2 => 2,
				3 => 3,
				4 => 4,
				5 => 5,
				6 => 6,
				7 => 7,
				8 => 8,
				9 => 9
			]
		]
	]
];