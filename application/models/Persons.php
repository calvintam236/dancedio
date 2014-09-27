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

class Persons extends CI_Model
{
	function search($pid, $firstname = NULL, $lastname = NULL, $email = NULL, $card = NULL)
	{
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		if ( !! strlen($firstname))
		{
			$this->db->like('firstname', strtoupper($firstname), 'after');
		}
		if ( !! strlen($lastname))
		{
			$this->db->like('lastname', strtoupper($lastname), 'after');
		}
		if ( !! strlen($email))
		{
			$this->db->where('email', $email);
		}
		if ( !! strlen($card))
		{
			$this->db->where('card', strtoupper($card));
		}
		$persons = $this->db->where('disabled', FALSE)->order_by('pid', 'asc')->get('persons');
		switch ($persons->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				return $persons->result()[0];
			default:
				return $persons->result();
		}
	}

	function add($pid, $firstname, $lastname, $address, $city, $state, $zipcode, $email, $cellphone, $homephone = NULL, $emergencyphone = NULL, $birthmonth = NULL, $note = NULL, $card = NULL, $fid = NULL)
	{
		if ( !! strlen($pid))
		{
			$this->db->set('pid', $pid);
		}
		$this->db->set('firstname', strtoupper($firstname))->set('lastname', strtoupper($lastname));
		if ( !! strlen($address))
		{
			$this->db->set('address', strtoupper($address));
		}
		if ( !! strlen($city))
		{
			$this->db->set('city', strtoupper($city));
		}
		if ( !! strlen($state))
		{
			$this->db->set('state', strtoupper($state));
		}
		if ( !! strlen($zipcode))
		{
			$this->db->set('zipcode', $zipcode);
		}
		$this->db->set('email', strtolower($email));
		if ( !! strlen($cellphone))
		{
			$this->db->set('cellphone', $cellphone);
		}
		if ( !! strlen($homephone))
		{
			$this->db->set('homephone', $homephone);
		}
		if ( !! strlen($emergencyphone))
		{
			$this->db->set('emergencyphone', $emergencyphone);
		}
		if ( !! strlen($birthmonth))
		{
			$this->db->set('birthmonth', $birthmonth);
		}
		if ( !! strlen($note))
		{
			$this->db->set('note', $note);
		}
		if ( !! strlen($card))
		{
			$this->db->set('card', strtoupper($card));
		}
		if ( !! strlen($fid))
		{
			$this->db->set('fid', $fid);
		}
		$this->db->insert('persons');
		return $this->db->insert_id();
	}

	function edit($pid, $firstname, $lastname, $address, $city, $state, $zipcode, $email, $cellphone, $homephone = NULL, $emergencyphone = NULL, $birthmonth = NULL, $note = NULL, $card = NULL, $fid = NULL)
	{
		$this->db->where('pid', $pid)->where('disabled', FALSE);
		if ( !! strlen($firstname))
		{
			$this->db->set('firstname', strtoupper($firstname));
		}
		if ( !! strlen($lastname))
		{
			$this->db->set('lastname', strtoupper($lastname));
		}
		if ( !! strlen($address))
		{
			$this->db->set('address', strtoupper($address));
		}
		if ( !! strlen($city))
		{
			$this->db->set('city', strtoupper($city));
		}
		if ( !! strlen($state))
		{
			$this->db->set('state', strtoupper($state));
		}
		if ( !! strlen($zipcode))
		{
			$this->db->set('zipcode', $zipcode);
		}
		$this->db->set('email', strtolower($email))->set('cellphone', $cellphone);
		if ( !! strlen($homephone))
		{
			$this->db->set('homephone', $homephone);
		}
		else
		{
			$this->db->set('homephone', NULL);
		}
		if ( !! strlen($emergencyphone))
		{
			$this->db->set('emergencyphone', $emergencyphone);
		}
		else
		{
			$this->db->set('emergencyphone', NULL);
		}
		if ( !! strlen($birthmonth))
		{
			$this->db->set('birthmonth', $birthmonth);
		}
		if ( !! strlen($note))
		{
			$this->db->set('note', $note);
		}
		else
		{
			$this->db->set('note', NULL);
		}
		if ( !! strlen($card))
		{
			$this->db->set('card', strtoupper($card));
		}
		if ( !! strlen($fid))
		{
			$this->db->set('fid', $fid);
		}
		$this->db->update('persons');
		return $this->db->affected_rows();
	}

	function disable($pid, $reason)
	{
		$this->db->where('pid', $pid)->where('disabled', FALSE)->set('reason', $reason)->set('disabled', TRUE)->update('persons');
		return $this->db->affected_rows();
	}
}


/* End of file Persons.php */
/* Location: ./application/models/Persons.php */