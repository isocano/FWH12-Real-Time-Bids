<?php 
	$resources_plugin = $this->config->item('resources_plugin');
	$resources = $this->config->item('resources');
	$base_url = $this->config->item('base_url');
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
		
<head>
	<meta charset="utf-8">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php echo $title;?></title>
	
	<meta name="description" content="<?php echo $description;?>">
	<!-- Google will often use this as its description of your page/site. Make it good. -->
	
	<meta name="google-site-verification" content="">
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
	
	<!-- humans.txt -->
	<link rel="author" href="humans.txt" />
	
	<meta name="author" content="Saldum developer team">
	<meta name="Copyright" content="Copyright Real Time Bid 2012. All Rights Reserved.">

	<!-- Dublin Core Metadata : http://dublincore.org/ -->
	<meta name="DC.title" content="Project Name">
	<meta name="DC.subject" content="What you're about.">
	<meta name="DC.creator" content="Who made this site.">
	
	<!--  Mobile Viewport Fix
	j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
	device-width : Occupy full width of the screen in its current orientation
	initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
	maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
	-->
	<!-- Uncomment to use; use thoughtfully!
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	-->
	
	
	<link rel="shortcut icon" href="<?php echo $base_url;?>favicon.ico">
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->

		 
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<!-- The is the icon for iOS's Web Clip.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->
	
	<!-- Reset CSS -->
	<link rel="stylesheet" href="<?php echo $resources;?>css/reset.css">	 

	<!-- Foundation -->
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width">
	
	<!-- FOUNDATION --> 
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="<?php echo $resources_plugin;?>foundation3/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="<?php echo $resources_plugin;?>foundation3/stylesheets/app.css">
	
	<!-- jQuery Google -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	
	<!-- Foundation JS -->
	<script src="<?php echo $resources_plugin;?>foundation3/javascripts/modernizr.foundation.js"></script>
	<script src="<?php echo $resources_plugin;?>foundation3/javascripts/foundation.min.js"></script>
	<script src="<?php echo $resources_plugin;?>foundation3/javascripts/app.js"></script>
	
	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo $resources;?>css/core.css">

</head>
<body>