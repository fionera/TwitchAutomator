<?php

require( __DIR__ . "/../app/class.php");

$vod = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_GET['vod']);

$vodclass = new TwitchVOD();
$vodclass->load( TwitchHelper::vod_folder() . DIRECTORY_SEPARATOR . $vod . '.json');

$start_offset = (int)$_GET['start'] ?: 0;

?>

<link href="style.css" rel="stylesheet" />

<div class="video-player">

	<video id="video" src="<?php echo 'vods/' . $vod . '.mp4'; ?>" controls width="1280"></video>


	<div class="video-chapters">

		<?php foreach ($vodclass->chapters as $game) { ?>

			<?php $proc = ( round($vodclass->duration_seconds) / $game['duration'] ) / 100 ; ?> <!-- TODO: Fix this, can't do math -->

			<!-- <?php echo $game['duration']; ?> / <?php echo round($vodclass->duration_seconds); ?> -->

			<div title="<?php echo $game['title'] . ' | ' . $game['game_name']; ?>" class="video-chapter" style="width: <?php echo $proc; ?>%" onclick="scrub(<?php echo $game['offset']; ?>, <?php echo $game['duration']; ?>);">
				<div class="video-chapter-title"><?php echo $game['title']; ?></div>
				<div class="video-chapter-game"><?php echo $game['game_name']; ?></div>
			</div>

		<?php } ?>

	</div>

	<div class="video-cut">
		<button class="button" onclick="cut_video('in')">Mark in</button>
		<button class="button" onclick="cut_video('out')">Mark out</button>
		<button class="button" onclick="submit_cut();">Submit cut</button>
		<input class="input" id="value_in" placeholder="In timestamp">
		<input class="input" id="value_out" placeholder="Out timestamp">
		<input class="input" id="cut_video_cmd">
	</div>

</div>

<script type="text/javascript">

	let start_offset = <?php echo $start_offset; ?>;
	let game_offset = <?php echo $vodclass->game_offset; ?>;
	
	let time_in = "";
	let time_out = "";

	if( start_offset > 0 ){
		document.getElementById('video').currentTime = start_offset;
	}

	function cut_video( t ){

		let cmd = document.getElementById('cut_video_cmd');

		let current_time = document.getElementById('video').currentTime;

		if(t == 'in') time_in = Math.round(current_time);
		if(t == 'out') time_out = Math.round(current_time);
		
		document.getElementById('value_in').value = time_in;
		document.getElementById('value_out').value = time_out;
		
	}

	function submit_cut(){
		if( time_in && time_out ){
			location.href = 'cut.php?vod=<?php echo $vod; ?>&start=' + time_in + '&end=' + time_out;
		}
	}

	function scrub(s, d){
		document.getElementById("video").currentTime = s;

		time_in = Math.round(s-game_offset);
		time_out = Math.round(s+d-game_offset);

		document.getElementById('value_in').value = time_in;
		document.getElementById('value_out').value = time_out;
	}

</script>