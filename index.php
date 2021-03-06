<!DOCTYPE HTML>
<html>
<head>
	<title>CC Tracker</title>
	<meta charset="UTF-8" />

	<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.slides.min.js"></script>

	<!--Our resources-->
	<link rel="stylesheet" href="css/pids.css" />
	<script type="text/javascript" src="js/pids.js"></script>
</head>

<body id="forecast-extended" class="forecast">
<div id="wrapper">
	<?php
	require('apikey.php');
	$traindata = @simplexml_load_file("http://api.wmata.com/StationPrediction.svc/GetPrediction/B07?api_key=$api_key");
	$track2 = array();
	if (isset($traindata->Trains->AIMPredictionTrainInfo))
	{
		foreach ($traindata->Trains->AIMPredictionTrainInfo as $train)
		{
			if ($train->Group == 2)
			{
				$x = array();
				$x['Line'] = (string)$train->Line;
				$x['Car'] = (string)$train->Car;
				$x['Destination'] = (string)$train->Destination;
				$x['Min'] = (string)$train->Min;
				$track2[] = $x;
				unset($x);
			}
		}
	}
	$track2 = array_pad($track2,3,array('Line' => '', 'Car' => '', 'Destination' => '', 'Min' => ''));
	?>
	<table id="pids">
		<thead>
			<tr>
				<th>LN</th>
				<th>CAR</th>
				<th>DEST</th>
				<th>MIN</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($track2 as $train)
		{
	?>	<tr>
				<td><?php echo($train['Line']);?></td>
				<td><?php echo($train['Car']);?></td>
				<td><?php echo($train['Destination']);?></td>
				<td><?php echo($train['Min']);?></td>
		</tr>
		<?php }
	?></tbody>
	</table>

	<div id="mid-wrapper">
		<div id="rail-status">
		<?php
		$incidentdata = @simplexml_load_file("http://api.wmata.com/Incidents.svc/Incidents?api_key=$api_key");
		if (count($incidentdata->Incidents->Incident) == 0)
		{
			?><div class="status"><p>There are no rail incidents at this time.</p></div><?php
		}
		else
		{
			foreach ($incidentdata->Incidents->Incident as $incident)
			{
				echo("<div class=\"status\">\n");
				$linesaffected = explode(';',(string)$incident->LinesAffected);
				echo("<p class=\"line\">");
				foreach ($linesaffected as $line)
				{
					if ($line != "") {echo("<span class=\"".trim($line)."\">&bull;</span>");}
				}
				unset($linesaffected);
				echo("</p>\n");
				echo("<p>" . (string)$incident->Description . "</p>\n");
				echo("</div>\n");
			}
		}
		?>
		</div>

		<div id="weather">
		<?php
		$nws = simplexml_load_file('http://w1.weather.gov/xml/current_obs/WASD2.xml');
		echo("Temp: " . $nws->temp_f . "°F<br />\n");
		echo("Wind: " . $nws->wind_mph . " mph " . $nws->wind_dir . "<br />\n");
		echo("Pressure: " . $nws->pressure_mb . " mb, ");
		echo($nws->pressure_tendency_mb > 0 ? "rising" : "falling");
		echo("<br />\n");
		?>
		</div>
	</div>

	<div id="bus-status"><p>Bus information is not yet available.</p></div>

	<div id="clock">
	<?php date_default_timezone_set('America/New_York'); ?>
	<p class="time"><?php echo(date("g:i A")); ?></p>
	<p class="date"><?php echo(date("n/j/Y, l")); ?></p>
	<!--<p class="ip"><?php //echo($_SERVER['HTTP_HOST']); ?></p>-->
	<p id="countdown"></p>
	</div>
	<?php
	/*To add:
		*Weather highs and lows for the day
		*Bus information
	*/
	?>
</div>
</body>
</html>
