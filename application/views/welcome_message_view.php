<div class="row">
	<div class="twelve columns">
		<h1>Welcome to Livebidr!</h1>
		<?php if ( ! $this->session->userdata('user_id')) { ?>
	    	<?php echo $this->feisbus->get_login_button(TRUE, 'xlarge'); ?>
	    <?php } ?>  
	    <?php echo $this->feisbus->load_javascript_SDK(); ?>
	</div>
</div>