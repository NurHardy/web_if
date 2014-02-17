<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Media extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_media');
			$this->load->helper('url');
			$data['page_title'] = 'Daftar Media Terunggah';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_medias']	= $this->web_media->get_media();
			
			$data['sitebase_']  = base_url();//$this->config->base_url();
			$this->load->template_admin('admin/media_list', $data, false, "&raquo; media");
		}
	}
	public function newmedia() {
		if ($this->load->check_session()) {
			$this->load->model ('web_media');
			$data['page_title'] = 'Unggah file baru';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/media_form', $data, false, "&raquo; <a href='/admin/media'>media</a> &raquo; upload");
		}
	}
	public function upload() {
		if ($this->load->check_session(true)) {
			$this->load->model ('web_media');
			$data['page_title'] = 'Daftar Media Terunggah';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'MEDIA_POST_FORM') {
				// proses UPLOAD =============================================
				$tanggal = date("Y-m-d H:i:s");

				$file_type_id = -1;
				$validexts_image = array("png","jpeg","jpg","gif");
				$validexts_docs  = array("pdf","doc","docx","xls","xlsx","ppt","pptx","txt","rtf");

				$maxsize = 5 * 1024 * 1024; //1048576; // = 1 Mb // Silakan diubah sesuai kebutuhan

				$succs=0;
				if (!isset($_FILES['f_files_'])) return;
				if (count($_FILES['f_files_']['name']) > 0) {
					$uploader_ = $_SERVER['REMOTE_ADDR'];
					$id_g = date('dmY');
					$_files_ = array(); // array of array [is_success?, message, address]
					for ($c_ = 0; $c_ < count($_FILES['f_files_']['name']); $c_++) {
						if (!empty($_FILES['f_files_']['name'][$c_])) {
							$filesize = $_FILES['f_files_']['size'][$c_];
							$ekstensi = strtolower(end(explode(".", $_FILES['f_files_']['name'][$c_])));
							if 		(in_array($ekstensi, $validexts_image))	$file_type_id = 1;
							else if (in_array($ekstensi, $validexts_docs))	$file_type_id = 2;
							
							if (($file_type_id != -1) && ($filesize <= $maxsize)) {
								// memastikan tidak ada nama file yang sama
								$uploadedfile = sprintf("/assets/media/m%s_%s",$id_g,$_FILES['f_files_']['name'][$c_]);
								$file_c = 1;
								while (file_exists("..".$uploadedfile)) {
									$uploadedfile = sprintf("/assets/media/m%s_%d_%s",$id_g,$file_c,$_FILES['f_files_']['name'][$c_]);
									$file_c++;
								}
								//$thumbimg    = sprintf("assets/thumbs/th_asset%d.cox",$id_g);
								if (move_uploaded_file($_FILES['f_files_']['tmp_name'][$c_], FCPATH.$uploadedfile)) 
								{
									//list($width_, $height_) = getimagesize($uploadedfile);
									//make_thumb($uploadedfile,$thumbimg,$ekstensi);
									$_result = $this->web_media->save_media(
										array(
											$_FILES['f_files_']['name'][$c_],
											$uploadedfile,
											$ekstensi,
											$file_type_id,
											$filesize),
										$uploader_,
										$this->nativesession->get('user_id_'),
										$this->nativesession->get('user_name_')
									);
									if ($_result) {
										$data['infos'][] = 'File berhasil diunggah...';
										$succs++;
										$_files_[] = array(true,"Upload berhasil.",'');
									} else {
										$_files_[] = array(false,"[Query failed] Error mengupload ".$_FILES['f_files_']['name'][$c_].". Silakan coba lagi.",null);
										$data['errors'][] = 'Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.';
									}
								} else {
									$_files_[] = array(false,"[Move error] Error mengupload ".$_FILES['f_files_']['name'][$c_].". Silakan coba lagi.",null);
								}
							} else { // jika tidak valid / terlalu besar
								$_files_[] = array(false,"Error mengupload ".$_FILES['f_files_']['name'][$c_].". Ukuran dan jenis file harus sesuai.",null);
							}
						} // end is empty f_files_[c_]
					} // end for
				} else $IS_SUBMIT_ = false; // end if count(files)
			}
			selesai:
			$this->output->append_output(print_r($_files_));
		}
	}
}