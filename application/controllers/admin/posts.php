<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends CI_Controller {
	public function newpost($draft_id = -1) {
		if ($this->load->check_session()) {
			$_is_error = false;
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= '/admin/posts/newpost';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			
			$data['f_draft_id']	= $this->input->post('txt_draft_id');
			$data['f_title']	= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']	= $this->input->post('txt_post_content');
			$data['f_cat']		= $this->input->post('txt_post_cat');
			
			// validation
			$_is_error |= ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content')));
			$_is_error |= ($this->input->post('txt_post_cat') <= 0);
			
			$_submitter = $this->input->post('form_submit');
			
			$data['_cats']			= $this->web_posting->get_categories(-1);
			if ($_submitter == 'POSTING_FORM') {
				if ($_is_error) {
					$data['errors'] = array('Mohon isi judul, kategori dan konten posting...');
				} else {
					$_result = $this->web_posting->save_post(
						$this->input->post('txt_post_title'),
						$this->input->post('txt_post_content'),
						$this->input->post('txt_post_cat'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true,
						$this->input->post('txt_draft_id')
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else if ($draft_id > 0) {
				$_draft_dump = $this->web_draft->get_draft($draft_id);
				if ($_draft_dump == null) {
					$this->output->set_header('Location: /admin/newpost/');
					return;
				}
				$data['f_draft_id']	= $draft_id;
				$data['f_title']	= $_draft_dump->f_title;
				$data['f_content']	= $_draft_dump->f_content;
				$data['f_cat']		= $_draft_dump->f_category;
			} else {
				$data['f_draft_id']	= -1;
			}
			$this->load->template_admin('admin/post_form', $data, false, "&raquo; <a href='/admin/posts'>posting</a> &raquo; posting baru");
		}
	}
	
	public function editpost($id_post = -1) {
		if ($this->load->check_session()) {
			if (!is_numeric($id_post)) $this->output->set_header('Location: /admin/posts');
			$_is_error = false;
			$data['page_title']		= $data['content_title'] = 'Edit Posting';
			$data['form_action']	= '/admin/posts/editpost/'.$id_post;
			$data['username_']		= $this->nativesession->get('user_name_');
			
			$data['f_draft_id']		= $this->input->post('txt_draft_id');
			$data['f_title']		= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']		= $this->input->post('txt_post_content');
			$data['f_cat']			= $this->input->post('txt_post_cat');
			// validation
			$_is_error |= ((!$this->input->post('txt_post_title')) || (!$this->input->post('txt_post_content')));
			$_is_error |= ($this->input->post('txt_post_cat') <= 0);
			
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			$data['_cats']			= $this->web_posting->get_categories(-1);
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'POSTING_FORM') {
				if ($_is_error) {
					$data['errors'] = array('Mohon isi judul, kategori dan konten posting...');
				} else {
					$_result = $this->web_posting->save_post(
						$this->input->post('txt_post_title'),
						$this->input->post('txt_post_content'),
						$this->input->post('txt_post_cat'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$this->input->post('txt_draft_id'),
						$id_post
					);
					if ($_result) {
						$data['infos']	 = array('Posting berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_posting->get_post($id_post);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/posts');
					return;
				}
				$data['f_post_id']	= $_dump->id_berita;
				$data['f_title']	= $_dump->judul;
				$data['f_content']	= $_dump->isi_berita;
				$data['f_cat']		= $_dump->id_kategori;
				if ($_dump->f_id_draft != 0) { // ada draf...
					$_draft_dump = $this->web_draft->get_draft($_dump->f_id_draft);
					if ($_draft_dump != null) {
						$data['f_title']	= $_draft_dump->f_title;
						$data['f_content']	= $_draft_dump->f_content;
						$data['f_cat']		= $_draft_dump->f_category;
					}
					$data['f_draft_id']	= $_dump->f_id_draft;
				} else $data['f_draft_id']	= -1; // no draft
			}
			$this->load->template_admin('admin/post_form', $data, false, "&raquo; <a href='/admin/posts'>posting</a> &raquo; edit posting");
		}
	}
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_posting');
			$this->load->model ('web_draft');
			$this->load->model ('web_functions');
			
			$data['page_title'] = 'Daftar Posting';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_ipp = $this->input->get('n'); // item per page
			$_cur = $this->input->get('p'); // current page (zero-based)
			$_maxpage = $this->input->get('x');
			$_filter = intval($this->input->get('cat'));

			$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
			if ($_maxpage === false) {
				$_n = $this->web_posting->count_posts($_filter);
				$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
			}
			
			$data['_drafts']	= $this->web_draft->get_drafts();
			$data['_posts']		= $this->web_posting->get_posts($_ipp, $_cur+1, $_filter);
			$data['_cats']		= $this->web_posting->get_categories(-1);
			$data['_paging']	= $this->web_functions->pagination(
				$_maxpage,
				$_cur,
				2,
				'/admin/posts',
				'cat='.$_filter.'&amp;n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_filter'] = $_filter;
			$data['_ipp'] = $_ipp;
			$this->load->template_admin('admin/post_list', $data, false, "&raquo; posting");
		}
	}
	public function postsavedraft() {
		$_datenow = date('d-m-Y H:i:s');
		$_return_data = array(
			'status'	=> 'Error',
			'message'	=> 'No session. Please login...',
			'datestr'	=> $_datenow,
			'newid'		=> -1
		);
		if ($this->load->check_session(true, json_encode($_return_data))) {
			
			//$_is_error = false
			$data['f_title']	= htmlentities($this->input->post('txt_post_title'));
			$data['f_content']	= $this->input->post('txt_post_content');
			$data['f_cat']		= $this->input->post('txt_post_cat');
			$data['f_draft_id']	= $this->input->post('txt_draft_id');
			
			$draft_id = $this->input->post('txt_draft_id');
			$_submitter = $this->input->post('form_submit');
			
			if ($_submitter == 'POSTING_FORM') {
				$this->load->model ('web_posting');
				
				$_result = $this->web_posting->save_post_draft(
					$this->input->post('txt_post_title'),
					$this->input->post('txt_post_content'),
					$this->input->post('txt_post_cat'),
					$this->nativesession->get('user_id_'),
					$this->nativesession->get('user_name_'),
					$this->input->post('txt_post_id'),
					$draft_id
				);
				if ($_result) {
					$_return_data['status'] = 'OK';
					$_return_data['message'] = 'Draft saved';
					$_return_data['newid'] = $_result;
				}
				else $_return_data['message'] = 'Error while saving data. Please check content and try again...';
				$this->output->append_output(json_encode($_return_data));
			}
		}
	}
	public function categories($page = 1) {
		if ($this->load->check_session()) {
			$this->load->model ('web_posting');
			$data['page_title'] = 'Daftar Kategori';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_cats']	= $this->web_posting->get_categories();
			$this->load->template_admin('admin/category_list', $data, false, "&raquo; <a href='/admin/posts'>posting</a> &raquo; kategori");
		}
	}
	
	public function preview() {
		$this->load->model('web_posting');
		$this->load->model('web_link');
		
		$data['other_posts'] = array();
		$data['daftar_tautan'] = $this->web_link->get_links();
		
		$data['_posting'] = new stdclass;
		$data['_posting']->judul = "[Preview]: {$this->input->post('txt_post_title')}";
		$data['_posting']->isi_berita = $this->input->post('txt_post_content');
		$data['_posting']->creator = $this->nativesession->get('user_name_');
		$data['_posting']->tanggal = date('Y-m-d H:i:s');
		
		$data['page_title'] = $data['_posting']->judul;
		$this->load->template_posting('posting', $data);
	
	}
	// AJAX
	public function deletepost() {
		if (!$this->load->check_session(true)) return;
		$this->load->model('web_posting');
		$p_id= $this->input->post('_postid');
		if ($this->web_posting->delete_post($p_id)) {
			$this->output->append_output("OK");
		} else {
			$this->output->append_output("FAIL");
		}
	}
}