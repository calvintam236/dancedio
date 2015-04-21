<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo doctype('html5')."\n";
?>
<html lang="en-us">
<head>
	<meta charset="utf-8" />
	<title>dancedio</title>
	<?php echo meta('description', '{}'); ?>
	<?php echo meta('keywords', 'club,dancing,dance,studio'); ?>
	<?php echo meta('viewport', 'width=device-width, user-scalable=no'); ?>
	<?php echo meta('revisit-after', '1 day'); ?>
	<?php echo link_tag('../resources/images/logo.png', 'shortcut icon', 'image/jpeg'); ?>
	<?php echo link_tag('http://fonts.googleapis.com/css?family=Raleway:100,400,600,700'); ?>
	<?php echo link_tag('../resources/styles/magnetic.css'); ?>
	<?php echo link_tag('../resources/styles/calendario.css'); ?>
	<?php echo link_tag('../resources/styles/vanillabox.css'); ?>
	<script type="text/javascript" src="../resources/scripts/jquery.min.js"></script>
	<script type="text/javascript" src="../resources/scripts/migrate.min.js" defer></script>
	<script type="text/javascript" src="../resources/scripts/calendario.min.js" defer></script>
	<script type="text/javascript" src="../resources/scripts/vanillabox.min.js" defer></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#menu_icon').click(function() {
		        $('aside nav ul').toggleClass('show_menu');
		        $('#menu_icon').toggleClass('close_menu');
		    });
			$(window).resize(function() {
				if ($(window).width() > 779 && $('header nav').attr('style') !== undefined) {
					$('header nav').removeAttr('style');
				}
			});
			if ($('#calendar').length > 0) {
				var cal = $('#calendar').calendario({
<?php
if (date('G') >= 5):
?>
					month: <?php echo date('n', strtotime('today')); ?>,
					year: <?php echo date('Y', strtotime('today')); ?>,
<?php
else:
?>
					month: <?php echo date('n', strtotime('yesterday')); ?>,
					year: <?php echo date('Y', strtotime('yesterday')); ?>,
<?php
endif;
?>
					caldata: $.parseJSON($('#caldata').text()),
					weekabbrs: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
					displayWeekAbbr: true,
					displayMonthAbbr: true,
					startIn: 0,
					onDayClick: function($el, $contentEl, dateProperties) {
						if ($contentEl.length > 0) {
							$('#custom-content').html('<h3>' + dateProperties.monthname + ' ' + dateProperties.day + '</h3><div class="custom-content-reveal-inner">' + $contentEl.html() + '</div>');
							$('#custom-content-reveal').css('top', '0%');
						}
					}
				});
				$month = $('#custom-month').html(cal.getMonthName());
				$year = $('#custom-year').html(cal.getYear());
				$('#custom-prev').click(function() {
					cal.gotoPreviousMonth(updateMonthYear);
				});
				$('#custom-next').click(function() {
					cal.gotoNextMonth(updateMonthYear);
				});
				function updateMonthYear() {
					$month.html(cal.getMonthName());
					$year.html(cal.getYear());
				}
				$('#custom-content-close').click(function() {
					$('#custom-content-reveal').removeAttr('style')
				});
			}
			if ($('a.popup_iframe').length > 0) {
				$('a.popup_iframe').vanillabox({
					keyboard: false,
					preferredWidth: 670,
					repositionOnScroll: true,
					type: 'iframe',
					grouping: false
				});
			}
			if ($('a.popup_image').length > 0) {
				$('a.popup_image').vanillabox({
					keyboard: false,
					repositionOnScroll: true,
					grouping: false
				});
			}
		});
	</script>
</head>
<body>
	<aside>
		<div class="logo">
			<?php echo anchor(NULL, '<h1>dancedio</h1>'.img('resources/images/logo.png')); ?>
		</div>
		<div id="menu_icon"></div>
		<nav class="clearfix">
			<ul>
				<li><?php echo anchor(NULL, 'HOME'); ?></li>
				<li><?php echo anchor('about', 'ABOUT'); ?></li>
				<li><?php echo anchor('beginners', 'BEGINNERS'); ?></li>
				<li><?php echo anchor('services', 'SERVICES'); ?></li>
				<li><?php echo anchor('schedule', 'SCHEDULE'); ?></li>
				<li><?php echo anchor('contact', 'CONTACT'); ?></li>
			</ul>
		</nav>
		<div class="social clearfix">
			<ul>
				<li><?php echo anchor('https://facebook.com/pages/{}', '<span class="socicon">b</span>', array('class' => 'fb')); ?></li>
				<li><?php echo anchor('http://twitter.com/{}', '<span class="socicon">a</span>', array('class' => 't')); ?></li>
				<li><?php echo anchor('https://plus.google.com/{}', '<span class="socicon">c</span>', array('class' => 'g')); ?></li>
				<li><?php echo anchor('http://instagram.com/{}', '<span class="socicon">x</span>', array('class' => 'i')); ?></li>
				<li><?php echo anchor('http://4sq.com/{}', '<span class="socicon">e</span>', array('class' => 'f2')); ?></li>
			</ul>
			<ul>
				<li><?php echo anchor('http://yelp.com/biz/{}', '<span class="socicon">h</span>', array('class' => 'y')); ?></li>
				<li><?php echo anchor('http://flic.kr/ps/{}', '<span class="socicon">v</span>', array('class' => 'f')); ?></li>
			</ul>
		</div>
		<div class="rights">
			<p>&copy; <?php echo date('Y'); ?> Dancedio.</p>
			<p>All rights reserved.</p>
			<p><?php echo anchor('auth', '&gt;&gt; Authorize'); ?></p>
		</div>
	</aside>
<?php
if ( ! is_null($notices)):
?>
	<section class="important">
		<div class="wrapper">
			<ul>
<?php
	foreach ($notices as $object):
?>
				<li><strong><?php echo $object->title; ?></strong>: <?php echo $object->message; ?></li>
<?php
	endforeach;
?>
			</ul>
		</div>
	</section>
<?php
endif;
?>
	<section class="main clearfix">
