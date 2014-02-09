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
	
	public function news($_id = 0, $_cat = null) {
		$this->load->model('web_posting');
		$this->load->model('web_link');
		
		$data['other_posts'] = $this->web_posting->get_newest_posts(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		if (is_numeric($_id)) {
			if ($_id <= 0) {
				$this->load->model ('web_functions');
				$_ipp = $this->input->get('n'); // item per page
				$_cur = $this->input->get('p'); // current page (zero-based)
				$_maxpage = $this->input->get('x');
				$_filter = intval($_cat);

				$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
				if ($_maxpage === false) {
					$_n = $this->web_posting->count_posts($_filter);
					$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
				}
				
				$data['_posts']		= $this->web_posting->get_posts($_ipp, $_cur+1, $_filter);
				$data['_paging']	= $this->web_functions->pagination(
					$_maxpage,
					$_cur,
					2,
					'/news/',
					'n='.$_ipp
				);
				$data['_ctr'] = $_cur*$_ipp;
				$data['_ipp'] = $_ipp;
				$data['page_title'] = "Daftar Posting";
				$this->load->template_posting('posting_list', $data);
			} else {
				$data['_posting'] = $this->web_posting->get_post($_id);
				if (!$data['_posting']) {
					$this->output->set_header('Location: /news');
					return;
				}
				$data['page_title'] = $data['_posting'][0]->judul;
				$this->load->template_posting('posting', $data);
			}
		} else {
		}
		
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
	
	public function feed() {
		$this->output->set_header('Content-Type: application/rss+xml; charset=utf-8');
		$this->load->model('web_posting');
		$data['_posts']		= $this->web_posting->get_newest_posts(10);
		$this->load->view("rss", $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */