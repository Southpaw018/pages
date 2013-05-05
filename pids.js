//Global vars
var count = 60;

$(document).ready(function() {
	//Init rail slider
	$('#rail-status').slides({
		play: 5000,
		preload: true
	});

	//Weather
	$('#weather div').load('accuweather.php');

	//Page reload countdown
	var interval = setInterval("countdown()",1000);
});

function countdown() {
	if (count < 1) {
		$('#countdown').css('color','#ff0000');
		if (count % 10 == 0) {location.reload();}
	}
	$('#countdown').text(count);
	count--;
};