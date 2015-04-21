<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<div class="orange">
		<div class="container_16 clearfix">
			<div class="grid_16 form">
				<h3>Skip if you want to add a new member</h3>
				<form method="post">
					<input type="text" name="pid/lastname/card" placeholder="PERSONS ID/ LAST NAME/ CARD" maxlength="30" pattern="^(\d{1,6})|([a-zA-Z \-']+)|([a-fA-F0-9]{14})$" autocomplete="off" required autofocus />
					<button>SEARCH</button>
				</form>
			</div>
		</div>
	</div>
<?php
if (isset($persons) && ! is_null($persons) && ! isset($persons->pid)):
?>
	<form method="post">
<?php
	foreach ($persons as $object):
?>
		<section class="gray">
			<div class="container_16 clearfix">
				<div class="grid_4">
					<button type="submit" name="pid" value="<?php echo $object->pid; ?>">#<?php echo sprintf('%06d', $object->pid); ?></button>
				</div>
				<div class="grid_12">
					<h3><?php echo $object->firstname.' '.$object->lastname; ?></h3>
<?php
		if ( ! is_null($object->address) && ! is_null($object->city) && ! is_null($object->state) && ! is_null($object->zipcode)):
?>
					<p><?php echo $object->address.', '.$object->city.', '.$object->state.' '.sprintf('%05d', $object->zipcode); ?></p>
<?php
		endif;
		if ( ! is_null($object->email) && ! is_null($object->cellphone)):
?>
					<p><?php echo $object->email.' / '.$object->cellphone; ?></p>
<?php
		endif;
?>
				</div>
			</div>
		</section>
<?php
	endforeach;
?>
	</form>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Enter information for a person</h3>
		<form method="post" enctype="multipart/form-data">
			<datalist id="city">
				<option value="ALAMEDA">
				<option value="ALAMO">
				<option value="ALBANY">
				<option value="AMERICAN CANYON">
				<option value="ANTIOCH">
				<option value="AUSTIN">
				<option value="BELMONT">
				<option value="BERKELEY">
				<option value="BRENTWOOD">
				<option value="CONCORD">
				<option value="CUPERTINO">
				<option value="DALY CITY">
				<option value="DANVILLE">
				<option value="DAVIS">
				<option value="DUBLIN">
				<option value="EAST PALO ALTO">
				<option value="EL CERRITO">
				<option value="EL SOBRANTE">
				<option value="EMERYVILLE">
				<option value="FAIRFIELD">
				<option value="FOSTER CITY">
				<option value="FREMONT">
				<option value="HAYWARD">
				<option value="HERCULES">
				<option value="LIVERMORE">
				<option value="MARTINEZ">
				<option value="MILLBRAE">
				<option value="MILPITAS">
				<option value="MOUNTAIN VIEW">
				<option value="NAPA">
				<option value="NEVADA CITY">
				<option value="NEWARK">
				<option value="OAKLAND">
				<option value="PALO ALTO">
				<option value="PIEDMONT">
				<option value="PINOLE">
				<option value="PITTSBURG">
				<option value="PLEASANT HILL">
				<option value="PLEASANTION">
				<option value="REDWOOD CITY">
				<option value="RICHMOND">
				<option value="SACRAMENTO">
				<option value="SAN BRUNO">
				<option value="SAN CARLOS">
				<option value="SAN FRANCISCO">
				<option value="SAN JOSE">
				<option value="SAN LEANDRO">
				<option value="SAN MATEO">
				<option value="SAN PABLO">
				<option value="SAN RAFAEL">
				<option value="SAN RAMON">
				<option value="SANTA CLARA">
				<option value="SANTA CRUZ">
				<option value="SANTA ROSA">
				<option value="SAUSALITO">
				<option value="SEBASTOPOL">
				<option value="SOUTH SAN FRANCISCO">
				<option value="STOCKTON">
				<option value="UNION CITY">
				<option value="VALLEJO">
				<option value="WALNUT CREEK">
			</datalist>
			<datalist id="state">
				<option value="AL">
				<option value="AK">
				<option value="AZ">
				<option value="AR">
				<option value="CA">
				<option value="CO">
				<option value="CT">
				<option value="DE">
				<option value="FL">
				<option value="GA">
				<option value="HI">
				<option value="ID">
				<option value="IL">
				<option value="IN">
				<option value="IA">
				<option value="KS">
				<option value="KY">
				<option value="LA">
				<option value="ME">
				<option value="MD">
				<option value="MA">
				<option value="MI">
				<option value="MN">
				<option value="MS">
				<option value="MO">
				<option value="MT">
				<option value="NE">
				<option value="NV">
				<option value="NH">
				<option value="NJ">
				<option value="NM">
				<option value="NY">
				<option value="NC">
				<option value="ND">
				<option value="OH">
				<option value="OK">
				<option value="OR">
				<option value="PA">
				<option value="RI">
				<option value="SC">
				<option value="SD">
				<option value="TN">
				<option value="TX">
				<option value="UT">
				<option value="VT">
				<option value="VA">
				<option value="WA">
				<option value="WV">
				<option value="WI">
				<option value="WY">
			</datalist>
			<datalist id="reason[persons]">
				<option value="Mistake">
				<option value="Duplicated">
				<option value="Emigrated">
				<option value="Deceased">
			</datalist>
<?php
if (isset($persons) && ! is_null($persons) && isset($persons->pid)):
?>
			<div class="grid_4">
<?php
	if ( ! is_null($persons->fid)):
?>
				<img src="data:image/jpeg;base64,<?php echo $files[$persons->fid]; ?>" alt="" />
<?php
	else:
?>
				<?php echo img('resources/images/missing.png')."\n"; ?>
<?php
	endif;
?>
			</div>
			<div class="grid_12">
				<input type="text" name="pid" value="<?php echo sprintf('%06d', $persons->pid); ?>" readonly />
				<input type="text" name="firstname" value="<?php echo $persons->firstname; ?>" placeholder="FIRST NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
				<input type="text" name="lastname" value="<?php echo $persons->lastname; ?>" placeholder="LAST NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
				<input type="text" name="address" value="<?php echo $persons->address; ?>" placeholder="ADDRESS" maxlength="50" pattern="^(\d+[0-9a-zA-Z #\-']{3,})|(P.O. BOX \d+)$" />
				<input list="city" name="city" value="<?php echo $persons->city; ?>" placeholder="CITY" maxlength="30" pattern="^[a-zA-Z .\-']+$" />
				<input list="state" name="state" value="<?php echo $persons->state; ?>" placeholder="STATE" maxlength="2" pattern="^[a-zA-Z]{2}$" />
<?php
	if ( ! is_null($persons->zipcode)):
?>
				<input type="text" name="zipcode" value="<?php echo sprintf('%05d', $persons->zipcode); ?>" placeholder="ZIP CODE" maxlength="5" pattern="^\d{5}$" />
<?php
	else:
?>
				<input type="text" name="zipcode" placeholder="ZIP CODE" maxlength="5" pattern="^\d{5}$" />
<?php
	endif;
?>
				<input type="email" name="email" value="<?php echo $persons->email; ?>" placeholder="EMAIL" maxlength="260" required />
				<input type="tel" name="cellphone" value="<?php echo $persons->cellphone; ?>" placeholder="CELL PHONE" maxlength="10" pattern="^\d{10}$" required />
				<input type="tel" name="homephone" value="<?php echo $persons->homephone; ?>" placeholder="HOME PHONE" maxlength="10" pattern="^\d{10}$" />
				<input type="tel" name="emergencyphone" value="<?php echo $persons->emergencyphone; ?>" placeholder="EMERGENCY PHONE" maxlength="10" pattern="^\d{10}$" />
				<input type="number" name="birthmonth" value="<?php echo $persons->birthmonth; ?>" placeholder="BIRTH MONTH" min="1" max="12" />
				<textarea name="note" maxlength="500" placeholder="NOTE"><?php echo $persons->note; ?></textarea>
				<input type="text" name="card" value="<?php echo $persons->card; ?>" placeholder="CARD" maxlength="14" pattern="^[a-fA-F0-9]{14}$" />
				<input type="file" name="photo" />
				<input list="reason[persons]" name="reason" placeholder="REASON" maxlength="200" />
			</div>
			<div class="grid_16">
<?php
else:
?>
			<div class="grid_16">
				<input type="text" name="firstname" placeholder="FIRST NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
				<input type="text" name="lastname" placeholder="LAST NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
				<input type="text" name="address" placeholder="ADDRESS" maxlength="50" pattern="^(\d+[0-9a-zA-Z #\-']{3,})|(P.O. BOX \d+)$" />
				<input list="city" name="city" placeholder="CITY" maxlength="30" pattern="^[a-zA-Z .\-']+$" />
				<input list="state" name="state" placeholder="STATE" maxlength="2" pattern="^[a-zA-Z]{2}$" />
				<input type="text" name="zipcode" placeholder="ZIP CODE" maxlength="5" pattern="^\d{5}$" />
				<input type="email" name="email" placeholder="EMAIL" maxlength="260" required />
				<input type="tel" name="cellphone" placeholder="CELL PHONE" maxlength="10" pattern="^\d{10}$" required />
				<input type="tel" name="homephone" placeholder="HOME PHONE" maxlength="10" pattern="^\d{10}$" />
				<input type="tel" name="emergencyphone" placeholder="EMERGENCY PHONE" maxlength="10" pattern="^\d{10}$" />
				<input type="number" name="birthmonth" placeholder="BIRTH MONTH" min="1" max="12" />
				<textarea name="note" maxlength="500" placeholder="NOTE"></textarea>
				<input type="text" name="card" placeholder="CARD" maxlength="14" pattern="^[a-fA-F0-9]{14}$" />
				<input type="file" name="photo" />
<?php
endif;
?>
				<div class="clear"></div>
<?php
if (isset($persons) && ! is_null($persons) && isset($persons->pid)):
?>
				<button type="submit" name="action" value="edit/disable">EDIT/ DISABLE</button>
<?php
else:
?>
				<button type="submit" name="action" value="add">ADD</button>
<?php
endif;
?>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
if (isset($persons) && ! is_null($persons) && isset($persons->pid)):
?>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>MEMBERSHIP</h3>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($memberships)):
		$data = array('A' => 'ASSOCIATE', 'R' => 'REGULAR', 'S' => 'STUDENT');
?>
				<h3>SINCE <?php echo date('m/d/Y', $memberships[0]->since); ?></h3>
				<p><?php echo $data[$memberships[0]->type]; ?></p>
				<p>ACTIVE UNTIL <?php echo date('m/d/Y', $memberships[0]->expiration); ?></p>
<?php
		if ( ! is_null($memberships[0]->oid)):
?>
				<p>ORDER ID #<?php echo $memberships[0]->oid; ?></p>
<?php
		endif;
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
	$data = array('A' => 'ASSOCIATE', 'R' => 'REGULAR', 'S' => 'STUDENT');
	if ( ! is_null($memberships)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>View &amp; maintain membership history</h3>
		<form method="post">
			<datalist id="reason[memberships]">
				<option value="Mistake">
				<option value="Cancelled">
				<option value="Disapproved">
			</datalist>
			<input type="hidden" name="extra" value="memberships" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
<?php
		$count = 0;
		foreach ($memberships as $object):
?>
			<div class="grid_4">
				<input type="hidden" name="mid[]" value="<?php echo $object->mid; ?>" />
				<table>
					<tr>
						<th><?php echo $data[$object->type]; ?></th>
					</tr>
				</table>
				<table>
					<tr>
						<td><?php echo date('Y-m-d', $object->since); ?></td>
					</tr>
					<tr>
						<td><?php echo date('Y-m-d', $object->expiration); ?></td>
					</tr>
				</table>
				<input list="reason[memberships]" name="reason[<?php echo $object->mid; ?>]" placeholder="REASON" maxlength="200" />
				<button type="submit" name="action" value="edit/cancel">EDIT/ CANCEL</button>
			</div>
<?php
			if ( ! (($count + 1) % 4) && ($count + 1) < count($memberships)):
?>
			<div class="clear"></div>
<?php
			endif;
			$count++;
		endforeach;
?>
		</form>
	</div>
<?php
	endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Select membership type and date range</h3>
		<form method="post">
			<input type="hidden" name="extra" value="memberships" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
<?php
	if ( ! is_null($memberships)):
?>
			<input type="hidden" name="mid" value="<?php echo $memberships[0]->mid; ?>" />
<?php
	endif;
?>
			<div class="grid_16">
				<select name="type" required>
					<option value="" selected disabled>TYPE</option>
<?php
	foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
	endforeach;
?>
				</select>
<?php
	if ( ! is_null($memberships)):
?>
				<input type="date" name="since" value="<?php echo date('Y-m-d', $memberships[0]->since); ?>" required />
<?php
		if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 year', $memberships[0]->expiration)); ?>" required />
<?php
		else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 year', $memberships[0]->expiration)); ?>" required />
<?php
		endif;
	elseif (date('G') >= 5):
?>
				<input type="date" name="since" min="<?php echo date('Y-m-d', strtotime('-1 month', strtotime('today'))); ?>" value="<?php echo date('Y-m-d', strtotime('today')); ?>" required />
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 year', strtotime('yesterday'))); ?>" required />
<?php
	else:
?>
				<input type="date" name="since" min="<?php echo date('Y-m-d', strtotime('-1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('today')); ?>" required />
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 year', strtotime('-1 day', strtotime('yesterday')))); ?>" required />
<?php
	endif;
?>
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>COPARTNERSHIP</h3>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($copartnerships)):
?>
				<h3>SINCE <?php echo date('m/d/Y', $copartnerships[0]->since); ?></h3>
				<p>ACTIVE UNTIL <?php echo date('m/d/Y', $copartnerships[0]->expiration); ?></p>
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
	if ( ! is_null($copartnerships)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>View &amp; maintain copartnership history</h3>
		<form method="post">
			<datalist id="reason[copartnerships]">
				<option value="Mistake">
				<option value="Cancelled">
				<option value="Disapproved">
			</datalist>
			<input type="hidden" name="extra" value="jobs" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
<?php
		$count = 0;
		foreach ($copartnerships as $object):
?>
			<div class="grid_4">
				<input type="hidden" name="cid[]" value="<?php echo $object->cid; ?>" />
				<table>
					<tr>
						<td>SINCE <?php echo date('Y-m-d', $object->since); ?></td>
					</tr>
<?php
			if (($count + 1) < count($copartnerships)):
?>
					<tr>
						<td><?php echo date('Y-m-d', $object->expiration); ?></td>
					</tr>
				</table>
				<table>
					<tr>
						<td><?php echo $object->bio; ?></td>
					</tr>
					<tr>
						<td><?php echo anchor($object->url); ?></td>
					</tr>
				</table>
<?php
			else:
?>
				</table>
<?php
				if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', $copartnerships[0]->expiration)); ?>" required />
<?php
				else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', $copartnerships[0]->expiration)); ?>" required />
<?php
				endif;
?>
				<textarea name="bio" maxlength="200" placeholder="BIO"></textarea>
				<input type="url" name="url" placeholder="URL" maxlength="150" />
<?php
			endif;
?>
				<input list="reason[copartnerships]" name="reason[<?php echo $object->cid; ?>]" placeholder="REASON" maxlength="200" />
				<button type="submit" name="action" value="edit/cancel">EDIT/ CANCEL</button>
			</div>
<?php
			if ( ! (($count + 1) % 4) && ($count + 1) < count($copartnerships)):
?>
			<div class="clear"></div>
<?php
			endif;
			$count++;
		endforeach;
?>
		</form>
	</div>
<?php
	endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Start new copartnership as teacher</h3>
		<form method="post">
			<input type="hidden" name="extra" value="copartnerships" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
<?php
	if ( ! is_null($copartnerships)):
?>
			<input type="hidden" name="cid" value="<?php echo $copartnerships[0]->cid; ?>" />
<?php
	endif;
?>
			<div class="grid_16">
<?php
	if ( ! is_null($copartnerships)):
?>
				<input type="date" name="since" value="<?php echo date('Y-m-d', $copartnerships[0]->since); ?>" readonly />
<?php
		if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', $copartnerships[0]->expiration)); ?>" required />
<?php
		else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', $copartnerships[0]->expiration)); ?>" required />
<?php
		endif;
	elseif (date('G') >= 5):
?>
				<input type="date" name="since" min="<?php echo date('Y-m-d', strtotime('-1 month', strtotime('today'))); ?>" value="<?php echo date('Y-m-d', strtotime('today')); ?>" required />
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" required />
<?php
	else:
?>
				<input type="date" name="since" min="<?php echo date('Y-m-d', strtotime('-1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', strtotime('today')); ?>" required />
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" required />
<?php
	endif;
?>
				<textarea name="bio" maxlength="200" placeholder="BIO"></textarea>
				<input type="url" name="url" placeholder="URL" maxlength="150" />
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>JOB</h3>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($jobs)):
?>
				<h3><?php echo count($jobs); ?> RESULT(S)</h3>
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
	$data = array('BOD' => 'BOARD OF DIRECTORS', 'MANAGEMENT' => 'MANAGEMENT', 'HOST' => 'HOST', 'DJ' => 'DJ', 'TAXI' => 'TAXI DANCER');
	if ( ! is_null($jobs)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Edit job(s) information</h3>
		<form method="post">
			<datalist id="reason">
				<option value="Mistake">
				<option value="Quitted">
			</datalist>
			<input type="hidden" name="extra" value="jobs" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
<?php
		$count = 0;
		foreach ($jobs as $object):
?>
			<div class="grid_4">
				<input type="hidden" name="jid[]" value="<?php echo $object->jid; ?>" />
				<table>
					<tr>
						<th><?php echo $data[$object->category]; ?></th>
					</tr>
				</table>
<?php
			if (date('G') >= 5):
?>
				<input type="date" name="expiration[<?php echo $object->jid; ?>]" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" value="<?php echo date('Y-m-d', $object->expiration); ?>" required />
<?php
			else:
?>
				<input type="date" name="expiration[<?php echo $object->jid; ?>]" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" value="<?php echo date('Y-m-d', $object->expiration); ?>" required />
<?php
			endif;
?>
				<input type="text" name="title[<?php echo $object->jid; ?>]" value="<?php echo $object->title; ?>" placeholder="TITLE" maxlength="20" pattern="^[a-zA-Z \-']+$" />
				<textarea name="bio[<?php echo $object->jid; ?>]" maxlength="200" placeholder="BIO"><?php echo $object->bio; ?></textarea>
				<input list="reason" name="reason[<?php echo $object->jid; ?>]" placeholder="REASON" maxlength="200" />
			</div>
<?php
			if ( ! (($count + 1) % 4) || ($count + 1) == count($jobs)):
?>
			<div class="clear"></div>
<?php
			endif;
			$count++;
		endforeach;
?>
			<div class="grid_16">
				<button type="submit" name="action" value="edit/cancel">EDIT/ CANCEL</button>
			</div>
		</form>
	</div>
<?php
	endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Assign new job for a person</h3>
		<form method="post">
			<input type="hidden" name="extra" value="jobs" />
			<input type="hidden" name="pid" value="<?php echo $persons->pid; ?>" />
			<div class="grid_16">
				<select name="category" required>
					<option value="" selected disabled>CATEGORY</option>
<?php
	foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
	endforeach;
?>
				</select>
<?php
	if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))); ?>" required />
<?php
	else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))); ?>" required />
<?php
	endif;
?>
				<input type="text" name="title" placeholder="TITLE" maxlength="20" pattern="^[a-zA-Z \-']+$" />
				<textarea name="bio" maxlength="200" placeholder="BIO"></textarea>
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
endif;
?>