<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="form wrapper">
		<h2><?php echo $persons->firstname.' '.$persons->lastname; ?></h2>
<?php
if ( ! is_null($jobs->bio)):
?>
		<p><?php echo $jobs->title; ?><br><br><?php echo $jobs->bio; ?></p>
<?php
else:
?>
		<p><?php echo $jobs->title; ?><br><br>Bio not available.</p>
<?php
endif;
?>
	</section>
		