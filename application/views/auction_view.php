<div class="row">
	<div class="twelve columns">
		<span id="price">10</span>
		<input id="new-bid" type="button"/>
		<ul id="bids">
			<li id="bids-li"></li>
		</ul>
	</div>
</div>

<script>
	var pusher = new Pusher('131de32e0bed65790199');
	var channel = pusher.subscribe('my-channel');
	
	channel.bind('my-event', function(data) {
	  alert('An event was triggered with message: ' + data.message);
	  $('#bids-li').before(data.message);
	});
	
	$("#new-bid").click(function() {
		var message = $('#price').html() + 5;
	  $.ajax({
		  type: "GET",
		  url: base_url + "auction/push/" + message,
		}).done(function( msg ) {
			// None
		});
	});
</script>

