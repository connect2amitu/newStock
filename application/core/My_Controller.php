<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * check if admin is login
	 * @return boolean retrun true on successfully login status else redirect to index page
	 */
	public function is_admin_login()
	{
		if ( $this->session->userdata('admin_id')!='' ) 
		{
			return true;
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	/**
	 * Pagination Confrigration Function
	 * @param  string $url        url of pagination
	 * @param  int $total_rows total number of records
	 * @return array             
	 */
	public function paginationConfig($url, $total_rows)
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url($url);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = PER_PAGE;
		$config['num_links'] = $total_rows;		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";		
		$this->pagination->initialize($config);
		return $config;

	}

}

/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */
