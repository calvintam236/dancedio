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

class Copartnerships extends CI_Model
{
	function available()
	{
		if (date('G') >= 5)
		{
			$this->db->where('expiration >=', strtotime('today 5am'));
		}
		else
		{
			$this->db->where('expiration >=', strtotime('yesterday 5am'));
		}
		$copartnerships = $this->db->where('cancelled', FALSE)->order_by('cid', 'desc')->get('copartnerships');
		switch ($copartnerships->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $copartnerships->result();
		}
	}

	function check($pid)
	{
		$copartnerships = $this->db->where('pid', $pid)->where('cancelled', FALSE)->order_by('cid', 'desc')->limit(1)->get('copartnerships');
		switch ($copartnerships->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				if ((date('G') >= 5 && $copartnerships->result()[0]->expiration >= strtotime('today 5am')) || $copartnerships->result()[0]->expiration >= strtotime('yesterday 5am'))
				{
					return $copartnerships->result()[0];
				}
				else
				{
					return FALSE;
				}
		}
	}

	function history($pid)
	{
		$copartnerships = $this->db->where('pid', $pid)->order_by('cid', 'desc')->get('copartnerships');
		switch ($copartnerships->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $copartnerships->result();
		}
	}

	function filter()
	{
		if (date('G') >= 5)
		{
			$this->db->where('expiration >=', strtotime('today 5am'));
		}
		else
		{
			$this->db->where('expiration >=', strtotime('yesterday 5am'));
		}
		$copartnerships = $this->db->get('copartnerships');
		switch ($copartnerships->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $copartnerships->result();
		}
	}

	function add($pid, $since, $expiration, $bio = NULL, $url = NULL)
	{
		$this->db->set('pid', $pid)->set('since', strtotime($since.'T05:00'))->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($bio))
		{
			$this->db->set('bio', $bio);
		}
		if ( !! strlen($url))
		{
			$this->db->set('url', strtolower($url));
		}
		$this->db->insert('copartnerships');
		return $this->db->insert_id();
	}
	
	function edit($cid, $expiration, $bio = NULL, $url = NULL)
	{
		$this->db->where('cid', $cid)->where('cancelled', FALSE)->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($bio))
		{
			$this->db->set('bio', $bio);
		}
		if ( !! strlen($url))
		{
			$this->db->set('url', strtolower($url));
		}
		$this->db->update('copartnerships');
		return $this->db->affected_rows();
	}

	function cancel($cid)
	{
		$this->db->where('cid', $cid)->where('cancelled', FALSE)->set('cancelled', TRUE)->update('copartnerships');
		return $this->db->affected_rows();
	}
}


/* End of file Copartnerships.php */
/* Location: ./application/models/Copartnerships.php */