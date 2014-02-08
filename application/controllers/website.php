<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('web_posting');
		$this->load->model('web_event');
		$this->load->model('web_link');
		
		$data['page_title'] = 'Home';
		//$data['page_additional_head'] = "<base href='/informatika/' /><!--[if IE]></base><![endif]-->";
		
		$data['newest_post'] = $this->web_posting->get_newest_posts(1);
        $data['other_posts'] = $this->web_posting->get_newest_posts(5);
		$data['daftar_event'] = $this->web_event->get_nearest_event(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$this->load->template_home('home', $data);
	}
	
	public function news($_id) {
		$this->load->model('web_posting');
		$this->load->model('web_link');
		
		$data['_posting'] = $this->web_posting->get_post($_id);
		if (!$data['_posting']) {
			$this->output->set_header('Location: /');
			return;
		}
		$data['page_title'] = $data['_posting'][0]->judul;
        $data['other_posts'] = $this->web_posting->get_newest_posts(5);
		
		//$data['daftar_event'] = $this->web_posting->get_nearest_event(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$this->load->template_posting('posting', $data);
	}
	
	public function page($_id) {
		$this->load->model('web_page');
		$this->load->model('web_link');
		
		$data['_page'] = $this->web_page->get_page($_id);
		if (!$data['_page']) {
			$this->output->set_header('Location: /');
			return;
		}
		$data['page_title'] = $data['_page'][0]->f_title;
		$data['other_posts'] = array();
        //$data['other_posts'] = $this->web_posting->get_newest_posts(5);
		
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$this->load->template_posting('page', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */