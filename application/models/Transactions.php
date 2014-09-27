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

class Transactions extends CI_Model
{
	function search($tid, $vid = NULL)
	{
		if ( !! strlen($tid))
		{
			$this->db->where('tid', $tid);
		}
		if ( !! strlen($vid))
		{
			$this->db->where('vid', $vid);
		}
		$transactions = $this->db->limit(1)->get('transactions');
		switch ($transactions->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $transactions->result()[0];
		}
	}

	function filter($payment = NULL)
	{
		if ( !! strlen($payment))
		{
			$this->db->where('payment', strtoupper($payment));
		}
		$transactions = $this->db->order_by('tid', 'desc')->get('transactions');
		switch ($transactions->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $transactions->result();
		}
	}

	function add($payment, $amount, $reference = NULL, $vid = NULL, $sid = NULL)
	{
		$this->db->set('time', microtime(TRUE))->set('payment', strtoupper($payment))->set('amount', $amount);
		if ( !! strlen($reference))
		{
			$this->db->set('reference', $reference);
		}
		if ( !! strlen($vid))
		{
			$this->db->set('vid', $vid);
		}
		if ( !! strlen($sid))
		{
			$this->db->set('sid', $sid);
		}
		$this->db->insert('transactions');
		return $this->db->insert_id();
	}
}


/* End of file Transactions.php */
/* Location: ./application/models/Transactions.php */