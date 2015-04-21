<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="form wrapper">
		<h2><?php echo $persons->firstname.' '.$persons->lastname; ?></h2>
<?php
if ( ! is_null($copartnerships->bio)):
?>
		<p><?php echo $copartnerships->bio; ?></p>
<?php
else:
?>
		<p>Bio not available.</p>
<?php
endif;
if ( ! is_null($copartnerships->url)):
?>
		<?php echo anchor($copartnerships->url, '<button>Website</button>')."\n"; ?>
<?php
endif;
?>
	</section>
		