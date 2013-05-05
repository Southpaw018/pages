//Global vars
var count = 60;

$(document).ready(function() {
	//Init rail slider
	$('#rail-status').slidesjs({
		width: 409,
		height: 245,
		navigation: {active: false},
		play: {
			active: false,
			interval: 5000,
			auto: true,
			effect: "fade"
		},
		effect: {
			fade: {
				speed: 800,
				crossfade: true
			}
		}
	});

	//Weather
	$('#weather div').load('accuweather.php');

	//Page reload countdown
	//var interval = setInterval("countdown()",1000);
});

function countdown() {
	if (count < 1) {
		$('#countdown').css('color','#ff0000');
		if (count % 10 == 0) {location.reload();}
	}
	$('#countdown').text(count);
	count--;
};