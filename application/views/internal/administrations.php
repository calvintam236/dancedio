<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<div class="orange">
		<div class="container_16 clearfix">
			<div class="grid_16">
				<h3>Please scroll down for different sections</h3>
			</div>
		</div>
	</div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>IMPORT</h3>
			</div>
			<div class="grid_12">
				<h3>USE WITH CAUTIONS</h3>
				<p>Some of the data will be overwritten, if it has not overwritten, please empty tables.</p>
			</div>
		</div>
	</section>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Enter JSON format data</h3>
		<form method="post">
			<div class="grid_16">
				<input type="hidden" name="section" value="import" />
				<textarea name="json" placeholder="JSON" required></textarea>
				<button type="submit" name="action" value="process">PROCESS</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>