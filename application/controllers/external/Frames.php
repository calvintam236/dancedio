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

class Frames extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (($this->agent->is_browser('Internet Explorer') && $this->agent->version() <= 9))
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
					redirect(site_url());
			}
		}
	}

	function rental_inquiry()
	{
		// post data
		$this->load->view('external/frames/header');
		if (isset($data))
		{
			$this->load->view('external/frames/rental_inquiry', $data);
		}
		else
		{
			$this->load->view('external/frames/rental_inquiry');
		}
		$this->load->view('external/frames/footer');
	}

	function new_application()
	{
		if ( ! is_null($this->input->post('continue')))
		{
			$this->load->model('Memberships');
			$this->load->model('Orders');
			$this->load->model('Persons');
			$this->load->model('Transactions');
			switch ($this->input->post('continue'))
			{
				case 1:
					// POSTed: Test for humanity and unique email address
					if ( !! strlen($this->input->post('human')) && strtoupper($this->input->post('human')) != 'YES')
					{
						$data['error'] = 'Not human.';
					}
					elseif ( !! strlen($this->input->post('email')))
					{
						$persons = $this->Persons->search(NULL, NULL, NULL, $this->input->post('email'));
						if (is_null($persons))
						{
							$this->session->set_tempdata('email', $this->input->post('email'), 300);
							$data['continue'] = 1;
						}
						else
						{
							$data['error'] = 'This email address is registered. Please click '.anchor('frames/renewal', 'here').' to continue.';
						}
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
					}
					break;
				case 2:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('firstname')) && !! strlen($this->input->post('lastname')) && !! strlen($this->input->post('cellphone')))
					{
						$this->session->set_tempdata('firstname', $this->input->post('firstname'), 300);
						$this->session->set_tempdata('lastname', $this->input->post('lastname'), 300);
						if ( !! strlen($this->input->post('address')) && !! strlen($this->input->post('city')) && !! strlen($this->input->post('state')) && !! strlen($this->input->post('zipcode')))
						{
							$this->session->set_tempdata('address', $this->input->post('address'), 300);
							$this->session->set_tempdata('city', $this->input->post('city'), 300);
							$this->session->set_tempdata('state', $this->input->post('state'), 300);
							$this->session->set_tempdata('zipcode', $this->input->post('zipcode'), 300);
						}
						$this->session->set_tempdata('cellphone', $this->input->post('cellphone'), 300);
						if ( !! strlen($this->input->post('homephone')))
						{
							$this->session->set_tempdata('homephone', $this->input->post('homephone'), 300);
						}
						if ( !! strlen($this->input->post('emergencyphone')))
						{
							$this->session->set_tempdata('emergencyphone', $this->input->post('emergencyphone'), 300);
						}
						$data['continue'] = 2;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 1;
					}
					break;
				case 3:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('type')))
					{
						$this->session->set_tempdata('type', $this->input->post('type'), 300);
						$data['continue'] = 3;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 2;
					}
					break;
				case 4:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('token')))
					{
						// send to stripe
						$this->load->library('Stripe');
						$data['continue'] = 4;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 3;
					}
					break;
				default:
					$data['error'] = 'Whoops! Something wrong... Try again?';
			}
		}
		$this->load->view('external/frames/header');
		if (isset($data))
		{
			$this->load->view('external/frames/new_application', $data);
		}
		else
		{
			$this->load->view('external/frames/new_application');
		}
		$this->load->view('external/frames/footer');
	}

	function renewal()
	{
		if ( ! is_null($this->input->post('continue')))
		{
			$this->load->model('Memberships');
			$this->load->model('Orders');
			$this->load->model('Persons');
			$this->load->model('Transactions');
			switch ($this->input->post('continue'))
			{
				case 1:
					// POSTed: Test for humanity and unique email address and correct last name
					if (strtoupper($this->input->post('human')) != 'YES')
					{
						$data['error'] = 'Not human.';
					}
					elseif ( !! strlen($this->input->post('email')) && !! strlen($this->input->post('lastname')))
					{
						$data['persons'] = $this->Persons->search(NULL, NULL, NULL, $this->input->post('email'));
						if ( ! is_null($data['persons']))
						{
							if (isset($data['persons']->pid))
							{
								if ($data['persons']->lastname == strtoupper($this->input->post('lastname')))
								{
									$this->session->set_tempdata('pid', $data['persons']->pid, 300);
									$data['continue'] = 1;
								}
								else
								{
									$data['error'] = 'Your information does not match. Please try again.';
								}
							}
							else
							{
								$data['error'] = 'This email address is registered with multiple accounts. Please contact us.';
							}
						}
						else
						{
							$data['error'] = 'This email address is not registered. Please click '.anchor('frames/new_application', 'here').' to continue.';
						}
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
					}
					break;
				case 2:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('cellphone')))
					{
						$this->session->set_tempdata('email', $this->input->post('email'), 300);
						if ( !! strlen($this->input->post('address')) && !! strlen($this->input->post('city')) && !! strlen($this->input->post('state')) && !! strlen($this->input->post('zipcode')))
						{
							$this->session->set_tempdata('address', $this->input->post('address'), 300);
							$this->session->set_tempdata('city', $this->input->post('city'), 300);
							$this->session->set_tempdata('state', $this->input->post('state'), 300);
							$this->session->set_tempdata('zipcode', $this->input->post('zipcode'), 300);
						}
						$this->session->set_tempdata('cellphone', $this->input->post('cellphone'), 300);
						if ( !! strlen($this->input->post('homephone')))
						{
							$this->session->set_tempdata('homephone', $this->input->post('homephone'), 300);
						}
						if ( !! strlen($this->input->post('emergencyphone')))
						{
							$this->session->set_tempdata('emergencyphone', $this->input->post('emergencyphone'), 300);
						}
						$data['continue'] = 2;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 1;
					}
					break;
				case 3:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('type')))
					{
						$this->session->set_tempdata('type', $this->input->post('type'), 300);
						$data['continue'] = 3;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 2;
					}
					break;
				case 4:
					// POSTed: Process payment
					if ( !! strlen($this->input->post('token')))
					{
						switch ($this->session->tempdata('type'))
						{
							case 'A';
							case 'R':
								$amount = 125.00;
								break;
							case 'S':
								$amount = 60.00;
						}
						$this->load->library('Stripe');
						$return = $this->Stripe->charge_card(
							$amount,
							$this->input->post('token'),
							'Membership annual fee',
							$this->session->tempdata('email')
						);
						if (isset($return->id))
						{
							$this->Orders->add(
								'M',
								$this->Transactions->add(
									'CC/DC',
									$amount,
									$return->id
								)
							);
							$data['continue'] = 4;
						}
						else
						{
							$data['error'] = 'Your card cannot charge, please try again.';
							$data['continue'] = 3;
						}
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 3;
					}
					break;
				default:
					$data['error'] = 'Whoops! Something wrong... Try again?';
			}
		}
		$this->load->view('external/frames/header');
		if (isset($data))
		{
			$this->load->view('external/frames/renewal', $data);
		}
		else
		{
			$this->load->view('external/frames/renewal');
		}
		$this->load->view('external/frames/footer');
	}

	function update_info()
	{
		if ( ! is_null($this->input->post('continue')))
		{
			$this->load->model('Memberships');
			$this->load->model('Persons');
			switch ($this->input->post('continue'))
			{
				case 1:
					// POSTed: Test for humanity and unique email address and correct last name
					if (strtoupper($this->input->post('human')) != 'YES')
					{
						$data['error'] = 'Not human.';
					}
					elseif ( !! strlen($this->input->post('email')) && !! strlen($this->input->post('lastname')))
					{
						$data['persons'] = $this->Persons->search(NULL, NULL, NULL, $this->input->post('email'));
						if ( ! is_null($data['persons']))
						{
							if (isset($data['persons']->pid))
							{
								if ($data['persons']->lastname == strtoupper($this->input->post('lastname')))
								{
									$this->session->set_tempdata('pid', $data['persons']->pid, 300);
									$data['continue'] = 1;
								}
								else
								{
									$data['error'] = 'Your information does not match. Please try again.';
								}
							}
							else
							{
								$data['error'] = 'This email address is registered with multiple accounts. Please contact us.';
							}
						}
						else
						{
							$data['error'] = 'This email address is not registered. Please check.';
						}
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
					}
					break;
				case 2:
					// POSTed: Validate data
					if ( !! strlen($this->input->post('cellphone')))
					{
						if ( !! strlen($this->input->post('address')) && !! strlen($this->input->post('city')) && !! strlen($this->input->post('state')) && !! strlen($this->input->post('zipcode')))
						{
							$this->Persons->edit(
								$this->session->tempdata('pid'),
								NULL,
								NULL,
								$this->input->post('address'),
								$this->input->post('city'),
								$this->input->post('state'),
								$this->input->post('zipcode'),
								$this->input->post('email'),
								$this->input->post('cellphone'),
								$this->input->post('homephone'),
								$this->input->post('emergencyphone'),
								$this->input->post('birthmonth')
							);
						}
						else
						{
							$this->Persons->edit(
								$this->session->tempdata('pid'),
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								$this->input->post('email'),
								$this->input->post('cellphone'),
								$this->input->post('homephone'),
								$this->input->post('emergencyphone'),
								$this->input->post('birthmonth')
							);
						}
						$data['continue'] = 2;
					}
					else
					{
						$data['error'] = 'Whoops! Something wrong... Try again?';
						$data['continue'] = 1;
					}
					break;
				default:
					$data['error'] = 'Whoops! Something wrong... Try again?';
			}
		}
		$this->load->view('external/frames/header');
		if (isset($data))
		{
			$this->load->view('external/frames/update_info', $data);
		}
		else
		{
			$this->load->view('external/frames/update_info');
		}
		$this->load->view('external/frames/footer');
	}

	function batch_inquiry()
	{
		// post data
		$this->load->view('external/frames/header');
		if (isset($data))
		{
			$this->load->view('external/frames/batch_inquiry', $data);
		}
		else
		{
			$this->load->view('external/frames/batch_inquiry');
		}
		$this->load->view('external/frames/footer');
	}

	function search_schedule()
	{
		// post data
		if ( ! $this->input->post())
		{
			$this->load->model('Designations');
			$this->load->model('Events');
		}
		$this->load->model('Copartnerships');
		$this->load->model('Genres');
		$this->load->model('Persons');
		// Get teacher and persons data
		$data['copartnerships'] = $this->Copartnerships->available();
		if ( ! is_null($data['copartnerships']))
		{
			foreach ($data['copartnerships'] as $object)
			{
				if ( ! isset($data['persons'][$object->pid]))
				{
					$data['persons'][$object->pid] = $this->Persons->search($object->pid);
				}
			}
		}
		// Get genre data
		$data['genres'] = $this->Genres->available();
		$this->load->view('external/frames/header');
		$this->load->view('external/frames/search_schedule', $data);
		$this->load->view('external/frames/footer');
	}

	function view_bod($pid = NULL)
	{
		if ( ! is_null($pid))
		{
			$this->load->model('Jobs');
			$this->load->model('Persons');
			$data['persons'] = $this->Persons->search($pid);
			if ( ! is_null($data['persons']))
			{
				$data['jobs'] = $this->Jobs->check('bod', $pid);
				if ( ! is_null($data['jobs']))
				{
					$this->load->view('external/frames/header');
					$this->load->view('external/frames/view_bod', $data);
					$this->load->view('external/frames/footer');
				}
				else
				{
					show_404();
				}
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	function view_management($pid = NULL)
	{
		if ( ! is_null($pid))
		{
			$this->load->model('Jobs');
			$this->load->model('Persons');
			$data['persons'] = $this->Persons->search($pid);
			if ( ! is_null($data['persons']))
			{
				$data['jobs'] = $this->Jobs->check('management', $pid);
				if ( ! is_null($data['jobs']))
				{
					$this->load->view('external/frames/header');
					$this->load->view('external/frames/view_management', $data);
					$this->load->view('external/frames/footer');
				}
				else
				{
					show_404();
				}
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}

	function view_teacher($pid = NULL)
	{
		if ( ! is_null($pid))
		{
			$this->load->model('Copartnerships');
			$this->load->model('Persons');
			$data['persons'] = $this->Persons->search($pid);
			if ( ! is_null($data['persons']))
			{
				$data['copartnerships'] = $this->Copartnerships->check($pid);
				if ( ! is_null($data['copartnerships']))
				{
					$this->load->view('external/frames/header');
					$this->load->view('external/frames/view_teacher', $data);
					$this->load->view('external/frames/footer');
				}
				else
				{
					show_404();
				}
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	function press_kit()
	{
		$this->load->view('external/frames/header');
		$this->load->view('external/frames/press_kit');
		$this->load->view('external/frames/footer');
	}
}


/* End of file Frames.php */
/* Location: ./application/controllers/external/Frames.php */