<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="form wrapper">
<?php
if ( ! isset($continue)):
?>
		<h2>New application: new appliant only</h2>
		<p>If you didn't provide, or don't want to provide us your email address, please fill in the form at the door.<br>* indicates required.</p>
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
			<input type="email" value="<?php echo $this->session->tempdata('email'); ?>" readonly />
			<input type="text" name="firstname" placeholder="FIRST NAME*" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
			<input type="text" name="lastname" placeholder="LAST NAME*" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
			<input type="text" name="address" placeholder="ADDRESS" maxlength="50" pattern="^(\d+[0-9a-zA-Z #\-']{3,})|(P.O. BOX \d+)$" />
			<span>Valid format: (NO) (STREET)[ (ST/ AVE/ DR/ CT/ WY/ SQ/ LN/ PL/ CIR)][ #(SUITE/ APARTMENT)]/ P.O. BOX (NO)</span>
			<input list="city" name="city" placeholder="CITY" maxlength="30" pattern="^[a-zA-Z .\-']+$" />
			<input list="state" name="state" placeholder="STATE" maxlength="2" pattern="^[a-zA-Z]{2}$" />
			<input type="text" name="zipcode" placeholder="ZIP CODE" maxlength="5" pattern="^\d{5}$" />
			<input type="tel" name="cellphone" placeholder="CELL PHONE*" maxlength="10" pattern="^\d{10}$" required />
			<input type="tel" name="homephone" placeholder="HOME PHONE" maxlength="10" pattern="^\d{10}$" />
			<input type="tel" name="emergencyphone" placeholder="EMERGENCY PHONE" maxlength="10" pattern="^\d{10}$" />
			<span>Valid format: 5101234567</span>
			<input type="number" name="birthmonth" placeholder="BIRTH MONTH" min="1" max="12" />
			<button type="submit" name="continue" value="2">Continue</button>
		</form>
<?php
			break;
		case 2:
?>
		<h2>[2] Your membership options</h2>
		<p>* indicates required.</p>
		<form method="post">
			<select name="type" required>
				<option value="" selected disabled>TYPE*</option>
<?php
			$data = array('A' => 'ASSOCIATE', 'R' => 'REGULAR', 'S' => 'STUDENT');
			foreach ($data as $object => $item):
?>
				<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
			endforeach;
?>
			</select>
			<button type="submit" name="continue" value="3">Continue</button>
		</form>
<?php
			break;
		case 3:
?>
		<h2>[3] Make your payment</h2>
		<p>* indicates required.</p>
		<form method="post">
			<input type="hidden" name="token" />
			<input type="text" placeholder="CARD NUMBER*" maxlength="19" data-stripe="number" required />
			<input type="text" placeholder="CARD SECURITY CODE*" maxlength="4" data-stripe="cvc" required />
			<input type="number" placeholder="EXPIRATION MONTH*" min="1" max="12" data-stripe="exp-month" required />
			<input type="number" placeholder="EXPIRATION YEAR*" min="<?php echo date('Y'); ?>" max="<?php echo date('Y', strtotime('+20 years')); ?>" data-stripe="exp-year" required />
			<button type="submit" name="continue" value="">Continue</button>
		</form>
<?php
			break;
		case FALSE:
?>
		<h2>Thank you! Please keep your record</h2>
		<p>You'll be receiving an email regards to your application and payment.<br>Print the invoice to collect your card after 5 business days, and ready to be photographed at the door.</p>
<?php
	endswitch;
endif;
?>
	</section>