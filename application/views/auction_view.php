<?php 
echo 'hola';
	// https://github.com/squeeks/Pusher-PHP
	/*require('../libraries/Pusher/Pusher.php');

	$key = '131de32e0bed65790199';
	$secret = '69d5b8a4d4f0696b3c7a';
	$app_id = '27903';

	$pusher = new Pusher($key, $secret, $app_id);
	$pusher->trigger('my-channel', 'my-event', array('message' => 'hello world') );*/
?>

<!--<scipt>
	var pusher = new Pusher('131de32e0bed65790199'); // Replace with your app key
	var channel = pusher.subscribe('my-channel');
	
	channel.bind('my-event', function(data) {
	  alert('An event was triggered with message: ' + data.message);
	});
</scipt>-->