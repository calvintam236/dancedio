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

class Administrations extends CI_Controller
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
			case 'A':
				if ( !! strlen($this->input->post('section')))
				{
					$this->load->model('Copartnerships');
					$this->load->model('Memberships');
					$this->load->model('Persons');
					switch ($this->input->post('section'))
					{
						case 'import':
							switch ($this->input->post('action'))
							{
								case 'process':
									if ( !! strlen($this->input->post('json')))
									{
										$json = json_decode($this->input->post('json'));
										if ( ! is_null($json))
										{
											if (isset($json->persons))
											{
												foreach ($json->persons as $object)
												{
													if ( !! strlen($object->pid) && !! strlen($object->firstname) && !! strlen($object->lastname))
													{
														if (is_null($this->Persons->search($object->pid)))
														{
															$this->Persons->add(
																$object->pid,
																$object->firstname,
																$object->lastname,
																$object->address,
																$object->city,
																$object->state,
																$object->zipcode,
																$object->email,
																$object->cellphone,
																$object->homephone,
																$object->emergencyphone,
																$object->birthmonth,
																$object->note//,
																//$object->card
															);
															$data['done'][] = 'You added person(s).';
														}
														else
														{
															$this->Persons->edit(
																$object->pid,
																$object->firstname,
																$object->lastname,
																$object->address,
																$object->city,
																$object->state,
																$object->zipcode,
																$object->email,
																$object->cellphone,
																$object->homephone,
																$object->emergencyphone,
																$object->birthmonth//,
																//$object->note,
																//$object->card
															);
															$data['done'][] = 'You edited person(s).';
														}
													}
													else
													{
														$data['error'] = 'Cannot add person(s) due to missing required data.';
													}
												}
											}
											if (isset($json->memberships))
											{
												foreach ($json->memberships as $object)
												{
													if ( !! strlen($object->pid) && ! is_null($this->Persons->search($object->pid)))
													{
														if ( !! strlen($object->type))
														{
															if (is_null($this->Memberships->check($object->pid)))
															{
																$this->Memberships->add(
																	$object->type,
																	$object->pid,
																	$object->since,
																	$object->expiration
																);
																$data['done'][] = 'You added membership(s).';
															}
														}
														else
														{
															$data['error'] = 'Cannot add membership(s) due to missing required data.';
														}
													}
													else
													{
														$data['error'] = 'Cannot add membership(s) due to person(s) does not exist.';
													}
												}
											}
											if (isset($json->copartnerships))
											{
												foreach ($json->copartnerships as $object)
												{
													if ( !! strlen($object->pid) && ! is_null($this->Persons->search($object->pid)))
													{
														if (is_null($this->Copartnerships->check($object->pid)))
														{
															if ( !! strlen($object->since) && !! strlen($object->expiration))
															{
																$this->Copartnerships->add(
																	$object->pid,
																	$object->since,
																	$object->expiration,
																	$object->bio,
																	$object->url
																);
															}
															elseif (date('G') >= 5)
															{
																$this->Copartnerships->add(
																	$object->pid,
																	date('Y-m-d', strtotime('today')),
																	date('Y-m-d', strtotime('+1 month', strtotime('yesterday'))),
																	$object->bio,
																	$object->url
																);
															}
															else
															{
																$this->Copartnerships->add(
																	$object->pid,
																	date('Y-m-d', strtotime('today')),
																	date('Y-m-d', strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))),
																	$object->bio,
																	$object->url
																);
															}
															$data['done'][] = 'You added copartnership(s).';
														}
													}
													else
													{
														$data['error'] = 'Cannot add membership(s) due to person(s) does not exist.';
													}
												}
											}
										}
										else
										{
											$data['error'] = 'Cannot decode. Validate syntax.';
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
				$this->load->view('internal/administrations', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Administrations.php */
/* Location: ./application/controllers/internal/Administrations.php */