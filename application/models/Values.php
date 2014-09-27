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

class Values extends CI_Model
{
	function check($vid, $code = NULL)
	{
		if ( !! strlen($vid))
		{
			$this->db->where('vid', $vid);
		}
		if ( !! strlen($code))
		{
			$this->db->where('code', $code);
		}
		$values = $this->db->where('redeemed', FALSE)->order_by('vid', 'desc')->limit(1)->get('values');
		switch ($values->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				return $values->result()[0]->type;
		}
	}

	function filter($type = NULL)
	{
		if ( !! strlen($type))
		{
			$this->db->where('type', strtoupper($type));
		}
		$values = $this->db->where('redeemed', FALSE)->order_by('vid', 'desc')->get('values');
		switch ($values->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $values->result();
		}
	}

	function add($code, $type, $expiration)
	{
		$this->db->set('code', strtoupper($code))->set('type', strtoupper($type));
		if ( !! strlen($expiration))
		{
			$this->db->set('expiration', strtotime($expiration.'T05:00'));
		}
		$this->db->insert('values');
		return $this->db->insert_id();
	}

	function redeem($vid)
	{
		$this->db->where('vid', $vid)->where('redeemed', FALSE)->set('redeemed', TRUE)->update('values');
		return $this->db->affected_rows();
	}
}


/* End of file Values.php */
/* Location: ./application/models/Values.php */