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

class Files extends CI_Model
{
	function search($content)
	{
		$files = $this->db->where('checksum', sha1($content))->order_by('fid', 'desc')->limit(1)->get('files');
		switch ($files->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $files->result()[0];
		}
	}

	function read($fid)
	{
		$files = $this->db->where('fid', $fid)->limit(1)->get('files');
		switch ($files->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $files->result()[0]->content;
		}
	}

	function write($content)
	{
		$this->db->set('checksum', sha1($content))->set('content', base64_encode($content))->insert('files');
		return $this->db->insert_id();
	}
}


/* End of file Files.php */
/* Location: ./application/models/Files.php */