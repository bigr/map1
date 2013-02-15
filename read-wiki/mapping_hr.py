# -*- coding: utf-8 -*-

wikiMapping = {
	'lat': [{
		'cond': lambda x: (ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"z\. širina") in x,
		'val': lambda x: x[ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"z\. širina"]
	}],
	'lon': [{
		'cond': lambda x: (ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"z\. dužina") in x,
		'val': lambda x: x[(ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"z\. dužina")]
	}],
	'name': [{
		'cond': lambda x: (ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"ime") in x,
		'val': lambda x: x[(ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"ime")]
	}],
	'place': [
		{		
		    'cond': lambda x: ur"Infookvir\s+grad|Grad|Naselje u Hrvatskoj|Općina|Naselje u Hrvatskoj" in x,
		    'val': lambda x: 'urb'
		}
	],
	'population': [{
		'cond': lambda x: (ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"brojstan|broj\sstanovnika") in x,
		'val': lambda x: x.integer(x[(ur"Infookvir\s+\w+|Grad|Naselje u Hrvatskoj|Općina",ur"brojstan|broj\sstanovnika")],ur"\.")
	}]
}
