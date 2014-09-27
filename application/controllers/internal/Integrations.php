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

class Integrations extends CI_Controller
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
				case 'external':
					redirect(site_url());
					break;
				case 'internal':
					$this->load->model('Users');
					if (is_null($this->session->userdata('name')) || is_null($this->Users->status($this->session->userdata('name'))))
					{
						$this->session->set_userdata('version', 'external');
						redirect(site_url());
					}
			}
		}
	}

	function index()
	{
		// Get user permission
		$data['users'] = $this->Users->status($this->session->userdata('name'));
		switch ($data['users']->permission)
		{
			case 'S';
			case 'A':
				if ( !! strlen($this->input->post('section')))
				{
					$this->load->model('Copartnerships');
					$this->load->model('Memberships');
					$this->load->model('Persons');
					switch ($this->input->post('section'))
					{
						case 'export':
							switch ($this->input->post('action'))
							{
								case 'generate':
									if ( !! strlen($this->input->post('type')))
									{
										switch ($this->input->post('type'))
										{
											case 'M/ACTIVE':
												$memberships = $this->Memberships->filter();
												if ( ! is_null($memberships))
												{
													foreach ($memberships as $object)
													{
														if ( ! isset($data['persons'][$object->pid]))
														{
															$data['persons'][$object->pid] = $this->Persons->search($object->pid);
														}
														$data['memberships'][$object->pid] = $object;
													}
												}
												break;
											case 'M/EXPIRED/LAST':
												break;
											case 'M/EXPIRED/THIS':
												break;
											case 'M/B/LAST':
												break;
											case 'M/B/THIS':
												break;
											case 'M/B/NEXT':
												break;
											case 'C/ACTIVE':
												$copartnerships = $this->Copartnerships->filter();
												if ( ! is_null($copartnerships))
												{
													foreach ($copartnerships as $object)
													{
														if ( ! isset($data['persons'][$object->pid]))
														{
															$data['persons'][$object->pid] = $this->Persons->search($object->pid);
														}
														$data['copartnerships'][$object->pid] = $object;
													}
												}
												break;
											case 'C/B/LAST':
												break;
											case 'C/B/THIS':
												break;
											case 'C/B/NEXT':
												break;
											default:
												$data['error'] = 'No such type.';
										}
									}
									else
									{
										$data['error'] = 'No data received as expected.';
									}
									break;
								default:
									$data['error'] = 'No such action.';
							}
							break;
						default:
							$data['error'] = 'No data received as expected.';
					}
				}
				if (isset($data['done']))
				{
					$data['done'] = array_unique($data['done']);
				}
				$this->load->view('internal/header', $data);
				$this->load->view('internal/integrations', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Integrations.php */
/* Location: ./application/controllers/internal/Integrations.php */