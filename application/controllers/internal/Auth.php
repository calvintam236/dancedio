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

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->agent->is_browser('Internet Explorer') || ($this->agent->is_browser('Firefox') && ! $this->agent->is_mobile()) || $this->agent->is_browser('Safari'))
		{
			redirect('http://browsehappy.com');
		}
		else
		{
			switch ($this->session->userdata('version'))
			{
				case NULL:
					$this->session->set_userdata('version', 'external');
					break;
				case 'internal':
					if (is_null($this->session->userdata('name')))
					{
						$this->session->set_userdata('version', 'external');
					}
			}
		}
	}

	function index()
	{
		switch ($this->session->userdata('version'))
		{
			case 'external':
				$this->load->model('Users');
				// Validate user information
				if ( ! is_null($this->input->server('PHP_AUTH_USER')) && ! is_null($this->input->server('PHP_AUTH_PW')) && $this->Users->check($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW')))
				{
					$this->session->set_userdata('version', 'internal');
					$this->session->set_userdata('name', strtolower($this->input->server('PHP_AUTH_USER')));
					redirect(site_url());
				}
				// Prompt for user information
				else
				{
					$this->output->set_header('WWW-Authenticate: Basic realm="Please login to continue."');
				}
				break;
			case 'internal':
				redirect(site_url());
		}
	}
}


/* End of file Auth.php */
/* Location: ./application/models/internal/Auth.php */