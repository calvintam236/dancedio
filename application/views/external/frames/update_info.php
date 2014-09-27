<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="form wrapper">
<?php
if ( ! isset($continue)):
?>
		<h2>Update info: current members only</h2>
		<p>* indicates required.</p>
		<form method="post">
			<input type="email" name="email" placeholder="EMAIL*" maxlength="260" required />
<?php
	if (is_null($this->input->post('continue'))):
?>
			<span>Your email must not be used in any application.</span>
<?php
	else:
?>
			<span><?php echo $error; ?></span>
<?php
	endif;
?>
			<input type="text" name="lastname" placeholder="LAST NAME*" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
			<input type="text" name="human" placeholder="HUMAN ANSWERS 'YES'*" maxlength="3" required />
			<button type="submit" name="continue" value="1">Continue</button>
		</form>
<?php
else:
	switch ($continue):
		case 1:
?>
		<h2>[1] Your information</h2>
		<p>If you don't provide your mailing address, please pick up your membership package at the door, and you will not receive any mail from us.<br>* indicates required.</p>
		<form method="post">
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
			<input type="email" name="email" value="<?php echo $persons->email; ?>" placeholder="EMAIL*" maxlength="260" required />
			<input type="text" value="<?php echo $persons->firstname; ?>" readonly />
			<input type="text" value="<?php echo $persons->lastname; ?>" readonly />
			<span>If you found error in your name, please contact us to change.</span>
			<input type="text" name="address" value="<?php echo $persons->address; ?>" placeholder="ADDRESS" maxlength="50" pattern="^(\d+[0-9a-zA-Z #\-']{3,})|(P.O. BOX \d+)$" />
			<span>Valid format: (NO) (STREET)[ (ST/ AVE/ DR/ CT/ WY/ SQ/ LN/ PL/ CIR)][ #(SUITE/ APARTMENT)]/ P.O. BOX (NO)</span>
			<input list="city" name="city" value="<?php echo $persons->city; ?>" placeholder="CITY" maxlength="30" pattern="^[a-zA-Z .\-']+$" />
			<input list="state" name="state" value="<?php echo $persons->state; ?>" placeholder="STATE" maxlength="2" pattern="^[a-zA-Z]{2}$" />
			<input type="text" name="zipcode" value="<?php echo $persons->zipcode; ?>" placeholder="ZIP CODE" maxlength="5" pattern="^\d{5}$" />
			<input type="tel" name="cellphone" value="<?php echo $persons->cellphone; ?>" placeholder="CELL PHONE*" maxlength="10" pattern="^\d{10}$" required />
			<input type="tel" name="homephone" value="<?php echo $persons->homephone; ?>" placeholder="HOME PHONE" maxlength="10" pattern="^\d{10}$" />
			<input type="tel" name="emergencyphone" value="<?php echo $persons->emergencyphone; ?>" placeholder="EMERGENCY PHONE" maxlength="10" pattern="^\d{10}$" />
			<span>Valid format: 5101234567</span>
			<button type="submit" name="continue" value="2">Continue</button>
		</form>
<?php
			break;
		case FALSE:
?>
		<h2>Thank you! You made changes</h2>
		<p>Please update your information when you changed your contact information.</p>
<?php
	endswitch;
endif;
?>
	</section>