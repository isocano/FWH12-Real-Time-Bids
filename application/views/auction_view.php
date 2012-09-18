<?php 
	// https://github.com/squeeks/Pusher-PHP
	require('/var/www/html/application/libraries/Pusher/lib/Pusher.php');

	$key = '131de32e0bed65790199';
	$secret = '69d5b8a4d4f0696b3c7a';
	$app_id = '27903';

	$pusher = new Pusher($key, $secret, $app_id);
	$pusher->trigger('my-channel', 'my-event', array('message' => 'hello world') );
?>

<div class="row">
	<a href="#" id="bid">Bid</a>
	<div class="twelve columns">
		<ul id="bids">
			<li id="bids-li"></li>
		</ul>
	</div>
</div>

<script>
	var pusher = new Pusher('131de32e0bed65790199'); // Replace with your app key
	var channel = pusher.subscribe('my-channel');
	var base_url = 'http://sldm.co/';
	
	channel.bind('my-event', function(data) {
	  $('#bids-li').before(data.message);
	});
	
	$("#bid").click(function() {
		var msg = $('#bid').html();
  		$.ajax({
		  type: "GET",
		  url: base_url + "auction/push/" + msg,
		}).done(function( msg ) {
		});
	});
</script>