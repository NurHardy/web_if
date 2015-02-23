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
		$this->load->model('web_pengumuman');
		$this->load->model('web_slider');
		
		$data['page_title'] = 'Home';
		//$data['page_additional_head'] = "<base href='/informatika/' /><!--[if IE]></base><![endif]-->";
		
		$data['newest_post'] = $this->web_posting->get_newest_posts(3);
		$data['other_posts'] = array();
        $data['other_posts'][0] = $this->web_posting->get_newest_posts(5,1);
		$data['other_posts'][1] = $this->web_posting->get_newest_posts(5,2);
		$data['other_posts'][2] = $this->web_posting->get_newest_posts(5,3);
		$data['other_posts'][3] = $this->web_posting->get_newest_posts(5,4);
		$data['other_posts'][4] = $this->web_posting->get_newest_posts(5,5);
		
		$data['daftar_event'] = $this->web_event->get_nearest_event(3);
		$data['daftar_pengumuman'] = $this->web_pengumuman->get_newst_nounce(2);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$data['_homeslides'] = $this->web_slider->get_slides();
		
		$this->load->template_home('home', $data);
	}
	
	public function news($_id = 0, $_slug = null) {
		$this->load->model('web_posting');
		$this->load->model('web_link');
		
		$data['other_posts'] = $this->web_posting->get_newest_posts(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		if (is_numeric($_id)) {
			if ($_id <= 0) { // list news
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
					base_url('/news/'),
					'cat='.$_filter.'&amp;n='.$_ipp
				);
				$nav_path = "&raquo; <a href='".base_url('/news')."'>news</a>";
				$data['cat_name'] = "semua berita";
				if ($_filter != 0) {
					$data['cat_name'] = $this->web_posting->get_name_categori($_filter);
					$nav_path .= " &raquo; ".$data['cat_name'];
				}
				$data['_ctr'] = $_cur*$_ipp;
				$data['_ipp'] = $_ipp;
				$data['page_title'] = "Daftar Posting";
				
				$this->load->template_posting('posting_list', $data,false,false,$nav_path);
			} else {//menampilkan news
				$data['_posting'] = $this->web_posting->get_post($_id, true, $_slug);
				$this->load->helper('url');
				if (!$data['_posting']) { // tidak ditemukan
					$data['page_title'] = 'Berita tidak ditemukan';
					$this->load->template_posting('error/notfound', $data);
					return;
				}
				$_nslug = $data['_posting']->f_slug;
				if ((!empty($_nslug)) && (strcmp($_nslug, $_slug)!=0)) { // slug berbeda/lama
					$this->output->set_header("Location: ".base_url("/news/{$data['_posting']->id_berita}/{$_nslug}"));
					return;
				}
				$this->web_posting->hit_post($data['_posting']->id_berita);
				$data['page_title'] = $data['_posting']->judul;
				$this->load->template_posting('posting', $data,false,false,"&raquo; news");
			}
		} else {
			$this->output->set_header('Location: '.base_url('/news'));
		}
	}
	
	public function staff($detail=null) 
	{ 
		$this->load->model('web_staff');
		$this->load->model('web_link');
		$data['daftar_tautan'] = $this->web_link->get_links();

		if(empty($detail)){
			$data['page_title'] = 'Daftar Staff';
			$data['_staff']   = $this->web_staff->get_staff();
			$this->load->template_profil('list_staff', $data ,false,'&raquo; profil &raquo; staff');
		}
		else{
			$data['page_title'] = 'Detail Staff';
			$data['_staff']   = $this->web_staff->get_staff();
			$data['_staff_detail']   = $this->web_staff->get_staff_id($detail);
			$this->load->template_profil('detail_staff', $data ,false,'&raquo; profil &raquo; staff' );
		}
	}
	
	public function galeri($album = null) 
	{ 
		$this->load->model('web_galeri');
		$this->load->model('web_link');
		
		if (empty($album)){		
			$data['page_title'] = 'Galeri';
			$data['album'] = 'yes';
			$data['daftar_album'] = $this->web_galeri->get_album();
			$data['daftar_tautan'] = $this->web_link->get_links();
			$this->load->template_profil('galeri', $data);
		} else {
			$data['page_title'] = 'Album '.htmlentities($album);
			$data['album'] = 'no';
			$data['daftar_album'] = $this->web_galeri->get_album();
			$data['daftar_foto'] = $this->web_galeri->get_foto_album($album);
			$data['daftar_tautan'] = $this->web_link->get_links();
			$this->load->template_profil('galeri', $data);
		}
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
	
	/*---------------------Penelitian--------------------------------*/
	public function penelitian($tahun=null) 
	{ 
		$this->load->model('web_penelitian');
		$this->load->model('web_link');
		$this->load->model('web_functions');
		$_ipp = 15; // item per page
		$_cur = $this->input->get('p'); // current page (zero-based)
		$_maxpage = $this->input->get('x');

		$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
		if ($_maxpage === false) {
			$_n = $this->web_penelitian->count_penelitian();
			$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
		}
		
		

		if(empty($tahun)){
		$data['page_title'] = 'Penelitian';
		$data['table'] = 'No';
		$data['data_penelitian_'] = null;
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('penelitian', $data);
		}
		else{
		$data['_paging']	= $this->web_functions->pagination(
			$_maxpage,
			$_cur,
			2,
			base_url("/penelitian/$tahun/"),
			'n='.$_ipp
		);
		$data['count_stat'] = $_ipp * $_cur + 1;
		$data['page_title'] = 'Penelitian';
		$data['table'] = 'Yes';
		$data['data_penelitian_'] = $this->web_penelitian->get_penelitian(15, $_cur+1,$tahun);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('penelitian', $data);
		}
	}
	
	/*---------------------Pengabdian--------------------------------*/
	public function pengabdian($tahun=null) 
	{ 
		$this->load->model('web_pengabdian');
		$this->load->model('web_link');
		$this->load->model('web_functions');
		$_ipp = 15; // item per page
		$_cur = $this->input->get('p'); // current page (zero-based)
		$_maxpage = $this->input->get('x');

		$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
		if ($_maxpage === false) {
			$_n = $this->web_pengabdian->count_pengabdian();
			$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
		}
		
		

		if(empty($tahun)){
		$data['page_title'] = 'Pengabdian';
		$data['table'] = 'No';
		$data['data_pengabdian_'] = null;
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('pengabdian', $data);
		}
		else{
		$data['_paging']	= $this->web_functions->pagination(
			$_maxpage,
			$_cur,
			2,
			base_url("/pengabdian/$tahun/"),
			'n='.$_ipp
		);
		$data['count_stat'] = $_ipp * $_cur + 1;
		$data['page_title'] = 'Pengabdian';
		$data['table'] = 'Yes';
		$data['data_pengabdian_'] = $this->web_pengabdian->get_pengabdian(15, $_cur+1,$tahun);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('pengabdian', $data);
		}
	}
	
	
	/*--------------------KEMAHASISWAAN------------------------------*/
	
	public function data_mahasiswa($tingkat=null) 
	{ 
		$this->load->model('web_mahasiswa');
		$this->load->model('web_link');
		$this->load->model('web_functions');
		$_ipp = 15; // item per page
		$_cur = $this->input->get('p'); // current page (zero-based)
		$_maxpage = $this->input->get('x');

		$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
		if ($_maxpage === false) {
			$_n = $this->web_mahasiswa->count_mhs();
			$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
		}
		
		if(empty($tingkat)){
		$data['page_title'] = 'Data Mahasiswa Aktif';
		$data['table'] = 'No';
		$data['data_mhs'] = null;
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('data_mahasiswa', $data);
		}
		else{
		$data['_paging']	= $this->web_functions->pagination(
			$_maxpage,
			$_cur,
			2,
			base_url("/data_mahasiswa/$tingkat/"),
			'n='.$_ipp
		);
		$data['count_stat'] = $_ipp * $_cur + 1;
		$data['page_title'] = 'Data Mahasiswa Aktif';
		$data['table'] = 'Yes';
		$data['data_mhs'] = $this->web_mahasiswa->get_mahasiswa(15, $_cur+1,$tingkat);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_profil('data_mahasiswa', $data);
		}
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
			$this->load->template_akademik('kurikulum', $data, false, "&raquo; kurikulum");
		} else {
			if ($_kurikulum == 2012) {
				$data['page_title'] = 'Mata Kuliah '.htmlentities($_kode);
				$data['content_title'] = 'Kurikulum 2012';
				$data['matkul'] = $this->web_matkul->get_matkul($_kode);
				$this->load->template_akademik('matkul', $data, false, "&raquo; <a href='".base_url("/kurikulum")."'>kurikulum</a> &raquo; {$_kurikulum} &raquo; {$_kode}");
			} else if ($_kurikulum == 2007) { 
				$data['page_title'] = 'Mata Kuliah '.htmlentities($_kode);
				$data['content_title'] = 'Kurikulum 2007';
				$data['matkul'] = $this->web_matkul->get_matkul_2007($_kode);
				$this->load->template_akademik('matkul', $data, false, "&raquo; <a href='".base_url("/kurikulum")."'>kurikulum</a> &raquo; {$_kurikulum} &raquo; {$_kode}");
			} else {
				$data['page_title'] = 'Kurikulum tidak ditemukan';
				$this->load->template_posting('error/notfound', $data);
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
		$this->load->template_akademik('agenda', $data,false,'&raquo; berita &raquo; agenda');
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
			$this->load->template_profil('error/notfound', $data);
			//$this->output->set_header('Location: /');
			return;
		}
		$data['page_title'] = $data['_page']->f_title;
		$this->load->template_profil('page', $data,false,false,"&raquo; ".$data['_page']->f_title);
	}
	
	public function feed() {
		$this->output->set_header('Content-Type: application/rss+xml; charset=utf-8');
		$this->load->model('web_posting');
		$data['_posts']		= $this->web_posting->get_newest_posts(10);
		$this->load->view("rss", $data);
	}
	
	public function tentangsitus() 
	{ 
		$this->load->model('web_link');
		$this->load->model('web_event');
		$data['page_title'] = 'Tentang Situs';
		$data['daftar_event'] = $this->web_event->get_nearest_event(5);
		$data['daftar_tautan'] = $this->web_link->get_links();
		$this->load->template_akademik('tentang_situs', $data,false,'&raquo; tentang - situs');
	}
	
	public function document($idDocument, $slugDocument) {
		$this->load->model('web_document');
		$documentData = $this->web_document->get_document($idDocument);
		if (!$documentData) { // tidak ditemukan
			$data['page_title'] = 'Dokumen tidak ditemukan';
			$this->load->template_posting('error/notfound', $data);
			return;
		}
		$rightSlug = $documentData->f_slug;
		if ((!empty($rightSlug)) && (strcmp($rightSlug, $slugDocument)!=0)) { // slug berbeda/lama
			$this->output->set_header("Location: ".base_url("/document/{$documentData->f_id}/{$rightSlug}"));
			return;
		}
		
		$filePath = FCPATH.$documentData->f_file_path;
		if (!file_exists($filePath)) {
			die("Maaf, dokumen tidak ditemukan di server.");
		}
		
		$this->web_document->hit_document($documentData->f_id);
		$filename = strtolower($documentData->f_name);
		
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="'.($filename).'"');
		readfile($filePath);
	}
	
	public function _e404() {
		$this->load->view("error/error404");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */