<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<div class="orange">
		<div class="container_16 clearfix">
			<div class="grid_16 form">
				<h3>Skip if he/ she is a non-member</h3>
				<form method="post">
					<input type="text" name="pid/card/code" placeholder="PERSONS ID/ CARD/ VALUES CODE" maxlength="14" pattern="^(\d{1,6})|([a-fA-F0-9]{14})$" autocomplete="off" required autofocus />
					<button>NEXT</button>
				</form>
			</div>
		</div>
	</div>
<?php
if ( ! is_null($this->input->post('pid/card/code')) && is_null($this->input->post('category')) && ( ! is_null($persons['request']) || ! is_null($values))):
?>
	<section class="gray">
		<div class="container_16 clearfix">
<?php
	if ( ! is_null($persons['request'])):
?>
			<div class="grid_4">
<?php
		if ( ! is_null($persons['request']->fid)):
?>
				<img src="data:image/jpeg;base64,<?php echo $files[$persons['request']->fid]; ?>" alt="" />
<?php
		else:
?>
				<?php echo img('resources/images/missing.png')."\n"; ?>
<?php
		endif;
?>
			</div>
			<div class="grid_12">
				<h3>#<?php echo sprintf('%06d', $persons['request']->pid); ?>: <?php echo $persons['request']->firstname.' '.$persons['request']->lastname; ?></h3>
<?php
		if ( !! $jobs):
			if (isset($jobs->jid)):
				$data = array('BOD' => 'BOARD OF DIRECTORS', 'MANAGEMENT' => 'MANAGEMENT', 'HOST' => 'HOST', 'DJ' => 'DJ', 'TAXI' => 'TAXI DANCER');
?>
				<p><?php echo $data[$jobs->category]; ?></p>
<?php
			else:
?>
				<p>MULTI-JOBS</p>
<?php
			endif;
?>
				<p>ACTIVE UNTIL <?php echo date('m/d/Y', $jobs->expiration); ?></p>
<?php
		elseif ( !! $memberships):
			$data = array('A' => 'ASSOCIATE', 'R' => 'REGULAR', 'S' => 'STUDENT');
?>
				<p><?php echo $data[$memberships->type]; ?></p>
				<p>ACTIVE UNTIL <?php echo date('m/d/Y', $memberships->expiration); ?></p>
<?php
		else:
?>
				<p>NON-MEMBER/ MEMBERSHIP/ JOB EXPIRED</p>
<?php
		endif;
?>
			</div>
<?php
	elseif ( ! is_null($values)):
		$data = array('G' => 'GIFT', 'P' => 'PASS');
?>
			<div class="grid_4">
				<h3><?php echo $data[$values->type]; ?></h3>
				<p>???</p>
			</div>
<?php
	endif;
?>
		</div>
	</section>
<?php
endif;
if ( ! is_null($designations)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Select an event and payment method</h3>
		<form method="post">
			<input type="hidden" name="category" value="E/D" />
<?php
	if ( ! is_null($this->input->post('pid/card/code')) && is_null($this->input->post('category'))):
		if ( ! is_null($persons['request'])):
?>
			<input type="hidden" name="pid" value="<?php echo $persons['request']->pid; ?>" />
<?php
		elseif ( ! is_null($values)):
?>
			<input type="hidden" name="vid" value="<?php echo $values->vid; ?>" />
<?php
		endif;
	endif;
	$count = 0;
	foreach ($designations as $object):
?>
			<div class="grid_4">
				<input type="checkbox" name="did[]" value="<?php echo $object->did; ?>" />
				<table>
					<tr>
						<th><?php echo $events[$object->eid]->label; ?></th>
					</tr>
				</table>
				<table>
					<tr>
						<td colspan="2"><?php echo date('h:iA', $object->begin); ?> &ndash; <?php echo date('h:iA', $object->end); ?></td>
					</tr>
<?php
		if (isset($instructions['persons']) && ! is_null($instructions['persons'][$object->eid])):
			$data = array();
			foreach ($instructions['persons'][$object->eid] as $item):
				if (isset($persons[$item->pid])):
					$data[] = $persons[$item->pid]->firstname;
				endif;
			endforeach;
			sort($data);
?>
					<tr>
						<td colspan="2"><?php echo implode(' &amp; ', $data); ?></td>
					</tr>
<?php
		endif;
		if (isset($instructions['genres']) && ! is_null($instructions['genres'][$object->did]) && ! is_null($genres)):
			$data = array();
			foreach ($instructions['genres'][$object->did] as $item):
				foreach ($genres as $thing):
					if ($thing->gid == $item->gid):
						$data[] = $thing->name;
					endif;
				endforeach;
			endforeach;
			sort($data);
?>
					<tr>
						<td colspan="2"><?php echo implode(' &amp; ', $data); ?></td>
					</tr>
<?php
		endif;
?>
					<tr>
<?php
		if ( ! is_null($locations)):
			foreach ($locations as $item):
				if ($item->lid == $events[$object->eid]->lid):
?>
						<td><?php echo $item->name; ?></td>
<?php
				endif;
			endforeach;
		endif;
		$data = array('C' => 'CLASS', 'P' => 'PARTY', 'S' => 'SPECIAL', 'R' => 'RENTAL', 'MIX' => 'MIXED');
?>
						<td><?php echo $data[$events[$object->eid]->category]; ?></td>
					</tr>
				</table>
				<table>
					<tr>
<?php
		if ( ! is_null($events[$object->eid]->price)):
			if ( ! is_null($events[$object->eid]->discount)):
				if ($events[$object->eid]->price - $events[$object->eid]->discount > 0.00):
?>
						<td colspan="5">$<?php echo number_format($events[$object->eid]->price, 2, '.', ''); ?>/ $<?php echo number_format($events[$object->eid]->price - $events[$object->eid]->discount, 2, '.', ''); ?></td>
<?php
				else:
?>
						<td colspan="5">$<?php echo number_format($events[$object->eid]->price, 2, '.', ''); ?>/ FREE</td>
<?php
				endif;
			else:
?>
						<td colspan="5">$<?php echo number_format($events[$object->eid]->price, 2, '.', ''); ?></td>
<?php
			endif;
		else:
?>
						<td colspan="5">FREE</td>
<?php
		endif;
?>
						<td colspan="2"><?php echo $arrivals['count'][$object->did]; ?></td>
					</tr>
				</table>
<?php
		if ( ! is_null($events[$object->eid]->price) && ! ( ! is_null($this->input->post('pid/card/code')) && is_null($this->input->post('category')) && ! is_null($persons['request']) && (( !! $memberships && !is_null($events[$object->eid]->discount) && $events[$object->eid]->price - $events[$object->eid]->discount == 0.00) || !! $jobs))):
			if ( ! is_null($this->input->post('pid/card/code')) && is_null($this->input->post('category')) && ! is_null($persons['request']) && !! $memberships):
?>
				<input type="text" name="amount[<?php echo $object->did; ?>]" value="<?php echo number_format($events[$object->eid]->price - $events[$object->eid]->discount, 2, '.', ''); ?>" placeholder="AMOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
<?php
			else:
?>
				<input type="text" name="amount[<?php echo $object->did; ?>]" value="<?php echo number_format($events[$object->eid]->price, 2, '.', ''); ?>" placeholder="AMOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
<?php
			endif;
		else:
?>
				<input type="text" name="amount[<?php echo $object->did; ?>]" placeholder="AMOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
<?php
		endif;
?>
			</div>
<?php
		if ( ! (($count + 1) % 4) || ($count + 1) == count($designations)):
?>
			<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
?>
			<div class="grid_16">
				<button type="submit" name="payment" value="CA/CHK">CASH/ CHECK</button>
				<button type="submit" name="payment" value="CC/DC">CREDIT/ DEBIT CARD</button>
				<button type="submit" name="payment" value="">FREE</button>
			</div>
		</form>
	</div>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Select floor type and payment method</h3>
		<form method="post">
			<datalist id="amount">
				<option value="8.00">
				<option value="9.00">
				<option value="10.00">
				<option value="35.00">
				<option value="55.00">
				<option value="65.00">
				<option value="75.00">
			</datalist>
			<input type="hidden" name="category" value="FLOOR" />
<?php
if ( ! is_null($this->input->post('pid/card/code')) && is_null($this->input->post('category'))):
	if ( ! is_null($persons['request'])):
?>
			<input type="hidden" name="pid" value="<?php echo $persons['request']->pid; ?>" />
<?php
	elseif ( ! is_null($values)):
?>
			<input type="hidden" name="vid" value="<?php echo $values->vid; ?>" />
<?php
	endif;
endif;
?>
			<div class="grid_16">
				<select name="type" required>
					<option value="" selected disabled>TYPE</option>
<?php
$data = array('P' => 'PRACTICE', 'PL' => 'PRIVATE LESSON', 'RR' => 'ROOM RENTAL');
foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
endforeach;
?>
				</select>
				<input list="amount" name="amount" placeholder="AMOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
<?php
if (is_null($this->input->post('pid/card/code'))):
?>
				<input type="text" name="fullname" placeholder="FULL NAME" maxlength="60" pattern="^[a-zA-Z \-'+]*$" />
<?php
endif;
?>
				<button type="submit" name="payment" value="CA/CHK">CASH/ CHECK</button>
				<button type="submit" name="payment" value="CC/DC">CREDIT/ DEBIT CARD</button>
				<button type="submit" name="payment" value="">FREE</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>REGISTERED</h3>
			</div>
			<div class="grid_12">
<?php
if ( ! is_null($arrivals['available'])):
?>
				<h3><?php echo count($arrivals['available']); ?> RESULT(S)</h3>
<?php
else:
?>
				<h3>NO RECORD</h3>
<?php
endif;
?>
			</div>
		</div>
	</section>
<?php
if ( ! is_null($arrivals['available'])):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Reverse within 30 minutes</h3>
		<form method="post">
			<datalist id="reason">
				<option value="Mistake">
				<option value="Changed mind">
				<option value="Illness">
				<option value="Too easy">
				<option value="Too difficult">
			</datalist>
<?php
	$count = 0;
	foreach ($arrivals['available'] as $object):
?>
			<div class="grid_4">
				<table>
					<tr>
<?php
		switch ($object->category):
			case 'E/D':
?>
						<th>EVENT/ DESIGNATION</th>
<?php
				break;
			case 'FLOOR':
?>
						<th>FLOOR FEE</th>
<?php
		endswitch;
?>
					</tr>
				</table>
				<table>
					<tr>
<?php
		if ( ! is_null($object->did)):
?>
						<th colspan="2"><?php echo $events[$designations[$object->did]->eid]->label; ?></th>
<?php
		elseif ( ! is_null($object->type)):
?>
						<th colspan="2"><?php echo $data[$object->type]; ?></th>
<?php
		endif;
?>
					</tr>
<?php
		if ( ! is_null($object->pid) && ! is_null($persons[$object->pid])):
?>
					<tr>
						<th colspan="2">#<?php echo sprintf('%06d', $object->pid); ?>: <?php echo $persons[$object->pid]->firstname[0].' '.$persons[$object->pid]->lastname; ?></th>
					</tr>
<?php
		endif;
?>
					<tr>
						<th colspan="2"><?php echo date('h:i:sA', $object->time); ?></th>
					</tr>
					<tr>
<?php
		if ( ! is_null($orders[$object->oid]->tid)):
			switch ($transactions[$orders[$object->oid]->tid]->payment):
				case 'CA/CHK';
				case 'CC/DC':
?>
						<td><?php echo $transactions[$orders[$object->oid]->tid]->payment; ?></td>
						<td>$<?php echo $object->amount; ?></td>
<?php
					break;
				case '';
				case NULL:
?>
						<td colspan="2">FREE</td>
<?php
			endswitch;
		else:
?>
						<td colspan="2">FREE</td>
<?php
		endif;
?>
					</tr>
				</table>
				<input type="hidden" name="aid[]" value="<?php echo $object->aid; ?>" />
				<input list="reason" name="reason[<?php echo $object->aid; ?>]" placeholder="REASON" maxlength="200" />
			</div>
<?php
		if ( ! (($count + 1) % 4) || ($count + 1) == count($arrivals['available'])):
?>
			<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
?>
			<div class="grid_16">
				<button type="submit">REVERSE</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
endif;
?>