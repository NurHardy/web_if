<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_page');
			$this->load->model ('web_functions');
			
			$data['page_title'] = 'Daftar Halaman';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_ipp = $this->input->get('n'); // item per page
			$_cur = $this->input->get('p'); // current page (zero-based)
			$_maxpage = $this->input->get('x');

			$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
			if ($_maxpage === false) {
				$_n = $this->web_page->count_pages();
				$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
			}
			
			//$data['_drafts']	= $this->web_draft->get_drafts();
			$data['_pages']		= $this->web_page->get_pages($_ipp, $_cur+1);
			$data['_paging']	= $this->web_functions->pagination(
				$_maxpage,
				$_cur,
				2,
				'/admin/pages',
				'n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_ipp'] = $_ipp;
			
			$this->load->template_admin('admin/page_list', $data, false, '&raquo; halaman');
		}
	}
	public function editpage($id_page = -1) {
		if ($this->load->check_session()) {
			if (!is_numeric($id_page)) $this->output->set_header('Location: /admin/pages');
			$data['page_title']		= $data['content_title'] = 'Edit Halaman';
			$data['form_action']	= '/admin/pages/editpage/'.$id_page;
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_title']		= htmlentities($this->input->post('f_title'));
			$data['f_content']		= $this->input->post('f_content');
			$data['f_permalink']	= htmlentities($this->input->post('f_permalink'));
			
			$this->load->model ('web_page');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$_plinkchk = $this->web_page->check_permalink($data['f_permalink'], $id_page);
					if ($_plinkchk != null) {
						$data['errors'][] = 'Permalink: '.$_plinkchk;
						goto selesai;
					}
					$_result = $this->web_page->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$id_page
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_page->get_page($id_page);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/pages');
					return;
				}	
				$data['f_title']	= $_dump->f_title;
				$data['f_content']	= $_dump->f_content;
				$data['f_permalink']= $_dump->f_permalink;
			}
			selesai:
			$this->load->template_admin('admin/page_form', $data, false, "&raquo; <a href='/admin/pages/'>halaman</a> &raquo; edit halaman");
		}
	}
	
	public function newpage() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Halaman Baru';
			$data['form_action']= '/admin/pages/newpage';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_title']	= htmlentities($this->input->post('f_title'));
			$data['f_content']	= $this->input->post('f_content');
			$data['f_permalink']= $this->input->post('f_permalink');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$this->load->model ('web_page');
					$_plinkchk = $this->web_page->check_permalink($data['f_permalink']);
					if ($_plinkchk != null) {
						$data['errors'][] = 'Permalink: '.$_plinkchk;
						goto selesai;
					}
					$_result = $this->web_page->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$this->load->template_admin('admin/page_form', $data, false, "&raquo; <a href='/admin/pages/'>halaman</a> &raquo; halaman baru");
		}
	}
	
	public function checkpermalink() {
		if ($this->load->check_session(true)) {
			$_plink = $this->input->post('plink');
			$this->load->model ('web_page');
			$_chk_res = $this->web_page->check_permalink($_plink);
			if ($_chk_res === null) {
				$this->output->append_output("<span class='info_fine_mark'>Permalink valid.</span>");
			} else {
				$this->output->append_output("<span class='info_error_mark'>".$_chk_res."</span>");
			}
		}
	}
	public function preview() {
		$this->load->model('web_page');
		$this->load->model('web_link');
		
		$data['other_posts'] = array();
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$data['_page'] = new stdclass;
		$data['_page']->f_title = "[Preview]: ".$this->input->post('f_title');
		$data['_page']->f_content = $this->input->post('f_content');
		$data['_page']->f_creator = $this->nativesession->get('user_name_');
		$data['_page']->f_date_submit = date('Y-m-d H:i:s');
		
		$data['page_title'] = $data['_page']->f_title;
		$this->load->template_posting('page', $data);
	}
}