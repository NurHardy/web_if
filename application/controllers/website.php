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
		
		$data['newest_post'] = $this->web_posting->get_newest_posts(3);
		$data['other_posts'] = array();
        $data['other_posts'][0] = $this->web_posting->get_newest_posts(5,1);
		$data['other_posts'][1] = $this->web_posting->get_newest_posts(5,2);
		$data['other_posts'][2] = $this->web_posting->get_newest_posts(5,3);
		$data['other_posts'][3] = $this->web_posting->get_newest_posts(5,4);
		$data['other_posts'][4] = $this->web_posting->get_newest_posts(5,5);
		
		$data['daftar_event'] = $this->web_event->get_nearest_event(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$this->load->template_home('home', $data);
	}
	
	public function news($_id = 0, $_slug = null) {
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
				$_filter = intval($this->input->get('cat'));

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
					'cat='.$_filter.'&amp;n='.$_ipp
				);
				$data['_ctr'] = $_cur*$_ipp;
				$data['_ipp'] = $_ipp;
				$data['page_title'] = "Daftar Posting";
				$this->load->template_posting('posting_list', $data);
			} else {
				$data['_posting'] = $this->web_posting->get_post($_id, true, $_slug);
				$this->load->helper('url');
				if (!$data['_posting']) {
					$data['page_title'] = 'Berita tidak ditemukan';
					$this->load->template_posting('error/notfound', $data);
					//$this->output->set_header('Location: /news');
					return;
				}
				$_nslug = $data['_posting']->f_slug;
				if ((!empty($_nslug)) && (strcmp($_nslug, $_slug)!=0)) { // slug berbeda/lama
					$this->output->set_header("Location: /news/{$data['_posting']->id_berita}/{$_nslug}");
					return;
				}
				$this->web_posting->hit_post($data['_posting']->id_berita);
				$data['page_title'] = $data['_posting']->judul;
				$this->load->template_posting('posting', $data);
			}
		} else {
		}
		
	}
	
	public function staff() 
	{ 
		$this->load->model('web_staff');
		$this->load->model('web_link');
		$data['page_title'] = 'Daftar Staff';
        $data['_staff']   = $this->web_staff->get_staff(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('staff', $data);
	}
	
	public function struktur_organisasi() 
	{ 
		$this->load->model('web_staff');
		$this->load->model('web_link');
		$data['page_title'] = 'Struktur Organisasi';
		$data['kajur'] = $this->web_staff->get_jabatan(1);
		$data['sekre'] = $this->web_staff->get_jabatan(2);
		$data['kmhs'] = $this->web_staff->get_jabatan(3);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('struktur_org', $data);
	}
	
	/*--------------------AKADEMIK------------------------------*/
	public function kurikulum($_kurikulum = null, $_kode = null) 
	{ 
		$this->load->model('web_link');
		$this->load->model('web_matkul');
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		if (empty($_kurikulum)) {
			$data['page_title'] = 'Kurikulum';
			$data['matkul'] = array_fill(0, 12, array());
			$data['matkul_2007'] = array_fill(0, 12, array());
			for ($_c=0;$_c<12;$_c++) $data['matkul'][$_c] = $this->web_matkul->get_matkul_smt($_c+1);
			for ($_c=0;$_c<12;$_c++) $data['matkul_2007'][$_c] = $this->web_matkul->get_matkul_2007_smt($_c+1);
			$this->load->template_akademik('kurikulum', $data);
		} else {
			if ($_kurikulum == 2012) {
				$data['page_title'] = 'Mata Kuliah'.htmlentities($_kode);
				$data['content_title'] = 'Kurikulum 2012';
				if ((($_kode) == false)){
					$data['page_title'] = 'Halaman tidak ditemukan';
					$this->load->template_posting('error/notfound', $data);
					//$this->output->set_header('Location: /');
					return;
				}
				else {
					$data['matkul'] = $this->web_matkul->get_matkul($_kode);
					$this->load->template_akademik('matkul', $data);
				}
			} 
			else if ($_kurikulum == 2007) { 
				$data['page_title'] = 'Mata Kuliah'.htmlentities($_kode);
				$data['content_title'] = 'Kurikulum 2007';
				$data['matkul_2007'] = $this->web_matkul->get_matkul_2007($_kode);
				$this->load->template_akademik('matkul_2007', $data);
			} 
			else{
				$data['page_title'] = 'Halaman tidak ditemukan';
				$this->load->template_posting('error/notfound', $data);
				$this->output->set_header('Location: /kurikulum');
			}	
		}
	}
	
	public function agenda() 
	{ 
		$this->load->model('web_link');
		$this->load->model('web_event');
		$data['page_title'] = 'Agenda Terdekat';
		$data['daftar_event'] = $this->web_event->get_nearest_event(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_akademik('agenda', $data);
	}
	
	public function page($_id) {
		$this->load->model('web_page');
		$this->load->model('web_link');
		
		$data['other_posts'] = array();
        //$data['other_posts'] = $this->web_posting->get_newest_posts(5);
		
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$data['_page'] = $this->web_page->get_page($_id);
		if (!$data['_page']) {
			$data['page_title'] = 'Halaman tidak ditemukan';
			$this->load->template_posting('error/notfound', $data);
			//$this->output->set_header('Location: /');
			return;
		}
		$data['page_title'] = $data['_page']->f_title;
		$this->load->template_posting('page', $data);
	}
	
	public function feed() {
		$this->output->set_header('Content-Type: application/rss+xml; charset=utf-8');
		$this->load->model('web_posting');
		$this->load->helper('url');
		$data['_posts']		= $this->web_posting->get_newest_posts(10);
		$this->load->view("rss", $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */