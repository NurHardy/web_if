<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Media extends CI_Controller {
	private $_mediaPath = "/assets/media/";
	private $_cpmask = 32;
	private $_uploadMaxSize = 2097152; // 2097152 = 2 * 1024 * 1024;
	private $_allowedGalleryExts = array("png","jpeg","jpg","gif");
	private $_allowedDocsExts = array(
		1 => array("doc","docx","odt"),
		2 => array("xls","xlsx"),
		3 => array("ppt","pptx","pptm"),
		4 => array("pdf"),
		5 => array("mp3"),
		6 => array("mp4"),
		7 => array("zip","7z","rar","gz","cab")
	);
	
	public function index($idAlbum = -1) {
		if ($this->load->check_session($this->_cpmask)) {
			$this->output->set_header('Location: '.base_url('/admin/media/album'));
		}
	}
	public function docs() {
		if (!$this->load->check_session($this->_cpmask)) return;
		$this->load->model ('web_document');
		$data['listDocuments']	= $this->web_document->get_documents();
		
		$data['page_title'] = 'List Dokumen';
		$data['username_']	= $this->nativesession->get('user_name_');
		$data['docIcons']	= array(
			1 => "ico_doc.png",
			2 => "ico_xls.png",
			3 => "ico_ppt.png",
			4 => "ico_pdf.png",
			7 => "ico_zip.png"
		);
		
		$this->load->template_admin('admin/document_list', $data, false,
			"&raquo; <a href='".base_url("/admin/media/")."'>Media</a> &raquo; Documents");
	}
	public function album($idAlbum = -1) {
		if (!$this->load->check_session($this->_cpmask)) return;
		$data['username_']	= $this->nativesession->get('user_name_');
		
		$this->load->model ('web_galeri');
		
		if ($idAlbum >= 0) {
			$data['page_title'] = 'Lihat Album';
			$data['dataAlbum']	= $this->web_galeri->get_album_data($idAlbum);
			if ($data['dataAlbum'] == null) {
				$this->output->set_header('Location: '.base_url('/admin/media/album'));
				return;
			}
			$data['listPhoto']	= $this->web_galeri->get_album_photos($idAlbum, -1);
			$this->load->template_admin('admin/media_album', $data, false,
				"&raquo; <a href='".base_url("/admin/media")."'>Media</a> ".
				"&raquo; <a href='".base_url("/admin/media/album")."'>Album</a> ".
				"&raquo; Album #".$data['dataAlbum']->id_album." [".htmlspecialchars($data['dataAlbum']->nama_album)."]");
		} else {
			$data['page_title'] = 'Lihat Album';
			$this->load->model ('web_media');
			$this->load->model ('web_galeri');
			$data['page_title'] = 'Daftar Album';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['listAlbum']	= $this->web_galeri->get_album(-1);
			$data['listCategory']	= $this->web_galeri->get_array_album_categories();
			
			$data['sitebase_']  = base_url();
			$this->load->template_admin('admin/media_list', $data,
				false, "&raquo; <a href='".base_url("/admin/media")."'>Media</a> &raquo; Album");
		}
	}
	public function newmedia() {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_media');
			$data['page_title'] = 'Unggah file baru';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/media_form', $data, false, "&raquo; <a href='".base_url("/admin/media")."'>media</a> &raquo; upload");
		}
	}
	public function upload() {
		if ($this->load->check_session($this->_cpmask, true)) {
			$this->load->model ('web_media');
			$data['page_title'] = 'Daftar Media Terunggah';
			$data['username_']	= $this->nativesession->get('user_name_');
			$_files_ = array(); // array of array [is_success?, message, address]
			
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
								while (file_exists(FCPATH.$uploadedfile)) {
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
			//$this->output->append_output(print_r($_files_));
			$this->output->append_output('<div id="image">Submitter=['.$this->input->post('form_submit').']</div>');
		} else {
			$this->load->showForbidden();
		}
	}
	
	public function uploadonce() {
		if ($this->load->check_session($this->_cpmask, true)) {
			$this->load->model ('web_media');
			$data['username_']	= $this->nativesession->get('user_name_');
			$_files_ = array(); // array of array [is_success?, message, address]
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'MEDIA_POST_FORM') {
				// proses UPLOAD =============================================
				$tanggal = date("Y-m-d H:i:s");

				$file_type_id = -1;
				$validexts_image = array("png","jpeg","jpg","gif");
				$validexts_docs  = array("pdf","doc","docx","xls","xlsx","ppt","pptx","txt","rtf");

				$maxsize = 5 * 1024 * 1024; //1048576; // = 1 Mb // Silakan diubah sesuai kebutuhan

				if (!isset($_FILES['f_file_'])) return;
				
				$uploader_ = $_SERVER['REMOTE_ADDR'];
				$id_g = date('dmY');
				
				if (!empty($_FILES['f_file_']['name'])) {
					$filesize = $_FILES['f_file_']['size'];
					$ekstensi = strtolower(end(explode(".", $_FILES['f_file_']['name'])));
					if 		(in_array($ekstensi, $validexts_image))	$file_type_id = 1;
					else if (in_array($ekstensi, $validexts_docs))	$file_type_id = 2;
					
					if (($file_type_id != -1) && ($filesize <= $maxsize)) {
						// memastikan tidak ada nama file yang sama
						$uploadedfile = sprintf("/assets/media/m%s_%s",$id_g,$_FILES['f_file_']['name']);
						$file_c = 1;
						while (file_exists(FCPATH.$uploadedfile)) {
							$uploadedfile = sprintf("/assets/media/m%s_%d_%s",$id_g,$file_c,$_FILES['f_file_']['name']);
							$file_c++;
						}
						//$thumbimg    = sprintf("assets/thumbs/th_asset%d.cox",$id_g);
						if (move_uploaded_file($_FILES['f_file_']['tmp_name'], FCPATH.$uploadedfile)) 
						{
							//list($width_, $height_) = getimagesize($uploadedfile);
							//make_thumb($uploadedfile,$thumbimg,$ekstensi);
							$_result = $this->web_media->save_media(
								array(
									$_FILES['f_file_']['name'],
									$uploadedfile,
									$ekstensi,
									$file_type_id,
									$filesize),
								$uploader_,
								$this->nativesession->get('user_id_'),
								$this->nativesession->get('user_name_')
							);
							if ($_result) {
								$this->load->helper('url');
								$imgurl_ = base_url($uploadedfile);
								$this->output->append_output("<div id='image'>{$imgurl_}</div>");
							} else {
								$this->output->append_output("[Query failed] Error mengupload ".$_FILES['f_file_']['name'].". Silakan coba lagi.");
								return;
							}
						} else {
							$this->output->append_output("[Move error] Error mengupload ".$_FILES['f_file_']['name'].". Silakan coba lagi.");
							return;
						}
					} else { // jika tidak valid / terlalu besar
						$this->output->append_output("Error mengupload ".$_FILES['f_file_']['name'].". Ukuran dan jenis file harus sesuai.");
						return;
					}
				} // end is empty f_file_
			}
			selesai:
			$this->output->append_output('Invalid operation.');
		}
	}
	
	// Function selector, hampir sama dengan function ajax, tetapi pada fungsi ini tidak dilakukan
	// pengecekan privilege
	public function select($unused) {
		$actionWord = $this->input->post("act");
		if ($actionWord == "docs.select") {
			$data['allowedMaxSize']		= $this->_uploadMaxSize;
			$data['allowedExts']		= $this->_allowedDocsExts;
			$this->load->view("admin/ajax/select_document", $data);
		} else if ($actionWord == "docs.select.getlist") {
			$this->load->model("web_document");
			$data['listDocument'] = $this->web_document->get_documents(1);
			$this->load->view("admin/ajax/select_document_list", $data);
		} else if ($actionWord == "docs.select.getlink") {
			$docIds = $this->input->post("docs_id");
			if (is_array($docIds)) {
				$this->load->model("web_document");
				$docsData = $this->web_document->get_document($docIds);
				$imgUrl = base_url("/assets/media/document.png");
				if (count($docsData) > 0) {
					$indentRight = (count($docsData) > 1);
					if ($indentRight) echo "<br><div style=\"\margin-left: 40px;\">\n";
					foreach ($docsData as $docItem) {
						if (!$indentRight) echo "[";
						echo "<a href=\"".base_url("/document/".$docItem->f_id."/".$docItem->f_slug)."\">";
						echo "<img src=\"".$imgUrl."\" alt=\"-\" /> ".htmlspecialchars($docItem->f_name)."</a>";
						if ($indentRight) echo "<br>\n";
						else echo "]";
					}
					if ($indentRight) echo "</div><br>\n";
				}
			}
		} else if ($actionWord == "photo.select") {
			$data = array();
			$this->load->view("admin/ajax/select_photo", $data);
		} else if ($actionWord == "photo.select.getalbum") {
			$this->load->model ('web_galeri');
			
			$data['listAlbum']	= $this->web_galeri->get_album(-1);
			$data['listCategory']	= $this->web_galeri->get_array_album_categories();
			$this->load->view("admin/ajax/select_photo_albums", $data);
		} else if ($actionWord == "photo.select.getphoto") {
			$this->load->model ('web_galeri');
			$idAlbum = $this->input->post("id");
			$data['listPhoto']	= $this->web_galeri->get_album_photos($idAlbum);
			$this->load->view("admin/ajax/select_photo_list", $data);
		} else if ($actionWord == "photo.select.getlink") {
			$photoIds = $this->input->post("photos_id");
			if (is_array($photoIds)) {
				$this->load->model("web_galeri");
				$photosData = $this->web_galeri->get_photo($photoIds);
				if (count($photosData) > 0) {
					echo "<div style=\"text-align: center;\">\n";
					foreach ($photosData as $photoItem) {
						$imgUrl = base_url($photoItem->url_foto);
						echo "<img src=\"".$imgUrl."\" width=\"90%\" alt=\"".htmlspecialchars($photoItem->filename)."\" /><br>\n";
					}
					echo "</div>\n";
				}
			}
		} else {
			$this->output->append_output('Invalid operation.');
		}
	}
	public function ajax() {
		if (!$this->load->check_session($this->_cpmask, true)) {
			$this->load->showForbidden();
			return;
		}
		
		$this->load->model ('web_galeri');
		$actionWord = $this->input->post("act");
		if ($actionWord == "album.getform") {
			$albumId = $this->input->post("id");
			if ($albumId === false) die("Invalid ID");
			if ($albumId >= 0) {
				$albumData = $this->web_galeri->get_album_data($albumId);
				if ($albumData == null) die("Invalid album ID.");
				$data['site_txt_title'] = $albumData->nama_album;
				$data['site_cat_id'] = $albumData->id_category;
				$data['site_txt_desc'] = $albumData->album_desc;
				$data['site_published'] = ($albumData->status==1?1:0);
			}
			$data['site_item_id'] = $albumId;
			$data['site_form_act'] = "album.save";
			$data['listCategory'] = $this->web_galeri->get_array_album_categories();
			$this->load->view("admin/ajax/form_album", $data);
		} else if ($actionWord == "album.save") {
			$albumId = $this->input->post("id");
			if ($albumId === false) die("Invalid ID");
			
			$newAlbumName	= trim($this->input->post("site_txt_title"));
			$newAlbumCatId	= intval($this->input->post("site_cat_id"));
			$newAlbumDesc	= trim($this->input->post("site_txt_desc"));
			$newAlbumStatus = ($this->input->post("site_published")==1?1:0);
			
			//== Validasi
			if (empty($newAlbumName) || ($newAlbumCatId < 0))
				die("Argument expected.");
			
			$this->load->model('web_galeri_ex');
			if ($newAlbumCatId == 999) { // Buat kategori album baru...
				$newAlbumCatName = trim($this->input->post("site_newcat_name"));
				if (empty($newAlbumCatName)) die("Incomplete argument.");
				
				$newCatQueryResult = $this->web_galeri_ex->save_album_category($newAlbumCatName);
				if ($newCatQueryResult) {
					$newId = $this->db->insert_id();
					if ($newId > 0) $newAlbumCatId = $newId;
					else die("New ID is 0");
				} else die("Insert query failed.");
			}
			
			$queryResult	= $this->web_galeri_ex->save_album(array(
					$newAlbumName,
					$newAlbumCatId,
					$newAlbumDesc,
					$newAlbumStatus
				),
				$this->nativesession->get('user_id_'),
				$this->nativesession->get('user_name_'),
				$albumId
			);
			if ($queryResult) {
				$this->output->append_output("OK");
			} else
				$this->output->append_output("Query error!");
				
		} else if ($actionWord == "album.setstatus") {
			$albumId = $this->input->post("id");
			$newStatus = $this->input->post("status");
			if ($albumId === false) die("Invalid ID");
			if ($newStatus === false) die("Argument expected.");
			
			$this->load->model('web_galeri_ex');
			$queryResult = $this->web_galeri_ex->set_album_status($albumId, intval($newStatus));
			if ($queryResult) $this->output->append_output("OK");
			else $this->output->append_output("Query error.");
		} else if ($actionWord == "photo.getdetail") {
			$photoId = $this->input->post("id");
			$photoData = $this->web_galeri->get_photo($photoId);
			if ($photoData == null) {
				die("Photo not found!");
			}
			$data['photoData'] = $photoData;
			$this->load->view("admin/ajax/form_photo", $data);
		} else if ($actionWord == "photo.getform") {
			$data['site_item_id'] = $this->input->post("id");
			$albumData = $this->web_galeri->get_album_data($data['site_item_id']);
			if ($albumData == null) die("Album not found!");
			
			$data['albumName'] = $albumData->nama_album;
			$data['albumId'] = $albumData->id_album;
			
			$data['allowedMaxSize']		= $this->_uploadMaxSize;
			$data['allowedExts']		= $this->_allowedGalleryExts;
			$this->load->view("admin/ajax/form_upload_photo", $data);
		} else if ($actionWord == "photo.upload") {
			$albumId = $this->input->post("id");
			$albumData = $this->web_galeri->get_album_data($albumId);
			if ($albumData == null) die("Album not found!");
			
			$uploadResult = $this->_do_upload($albumId);
			if (!empty($uploadResult)) {
				foreach ($uploadResult as $uploadedItem) {
					if ($uploadedItem[0]) {
						$this->output->append_output("<div class=\"site_box_success\"><b>Upload OK</b>: ".$uploadedItem[1]."</div>");
					} else {
						$this->output->append_output("<div class=\"site_box_alert\"><b>Upload error!</b>: ".$uploadedItem[1]."</div>");
					}
				}
			} else {
				$this->output->append_output("<div class=\"site_box_warning\"><b>No file uploaded!</b></div>");
			}
		} else if ($actionWord == "docs.getform") {
			$data['site_item_id'] = $this->input->post("id");
			
			$data['allowedMaxSize']		= $this->_uploadMaxSize;
			$data['allowedExts']		= $this->_allowedDocsExts;
			
			$this->load->view("admin/ajax/form_upload_doc", $data);
		} else if ($actionWord == "docs.upload") {
			$albumId = $this->input->post("id");
			
			$uploadResult = $this->_do_upload_docs();
			if (!empty($uploadResult)) {
				foreach ($uploadResult as $uploadedItem) {
					if ($uploadedItem[0]) {
						$this->output->append_output("<div class=\"site_box_success\"><b>Upload OK</b>: ".$uploadedItem[1]."</div>");
					} else {
						$this->output->append_output("<div class=\"site_box_alert\"><b>Upload error!</b>: ".$uploadedItem[1]."</div>");
					}
				}
			} else {
				$this->output->append_output("<div class=\"site_box_warning\"><b>No file uploaded!</b></div>");
			}
		} else {
			$this->output->append_output('Invalid operation.');
		}
	}
	
	// Untuk membuat folder tempat upload
	private function _prepare_path($folderPath, $privFlags = 0777) {
		if (!file_exists(FCPATH.$folderPath)) {
			$result = mkdir(FCPATH.$folderPath, $privFlags, true);
			if (!$result) die("Fatal error: Cannot create directory for upload (".FCPATH.$folderPath.")!");
		}
	}
	
	private function _do_upload($albumId) {
		$this->_prepare_path($this->_mediaPath);
		$this->_prepare_path($this->_mediaPath."thumbs/");
		
		$_files_ = array(); // array of array [is_success?, message, address]
		
		// proses UPLOAD =============================================
		$tanggal = date("Y-m-d H:i:s");

		$file_type_id = -1;
		$validexts_image = $this->_allowedGalleryExts;
		
		$succs=0;
		if (!isset($_FILES['f_files_'])) return null;
		if (count($_FILES['f_files_']['name']) > 0) {
			$uploader_ = $_SERVER['REMOTE_ADDR'];
			$id_g = date('dmY');
			$this->load->library('image_lib');
			for ($c_ = 0; $c_ < count($_FILES['f_files_']['name']); $c_++) {
				if (!empty($_FILES['f_files_']['name'][$c_])) {
					$file_type_id = -1;
					$filesize = $_FILES['f_files_']['size'][$c_];
					$ekstensi = strtolower(end(explode(".", $_FILES['f_files_']['name'][$c_])));
					if 		(in_array($ekstensi, $validexts_image))	$file_type_id = 1;
					
					if (($file_type_id != -1) && ($filesize <= $this->_uploadMaxSize)) {
						//===== memastikan tidak ada nama file yang sama
						$uploadFileName = basename(strtolower($_FILES['f_files_']['name'][$c_]), ".".$ekstensi);
						$uploadFileName = url_title($uploadFileName, '-', TRUE);
						if (strlen($uploadFileName) > 32)
							$uploadFileName = substr($uploadFileName, -32);
						
						$folderName = date("Y-m");
						$uploadPath = $this->_mediaPath.$folderName.'/';
						// Buat folder jika belum ada...
						$this->_prepare_path($uploadPath);
						
						//$dateChunk = date("Ymd-His");
						$saltChunk = substr(md5(uniqid(rand(), true)), 0, 5);
						
						$uploadedfile = $uploadPath.sprintf("%s_%s.%s", $saltChunk, $uploadFileName, $ekstensi);
						
						// Sebenarnya tidak perlu sih...., tapi untuk memastikan sekali lagi....
						$file_c = 1;
						while (file_exists(FCPATH.$uploadedfile)) {
							$saltChunk = substr(md5(uniqid(rand(), true)), 0, 5);
							$uploadedfile = $uploadPath.sprintf("%s_%s.%s", $saltChunk, $uploadFileName, $ekstensi);
							$file_c++;
						}
						
						$thumbimg    = sprintf($this->_mediaPath."thumbs/%s_%s_%s.%s",$folderName, $saltChunk, $uploadFileName, $ekstensi);
						if (move_uploaded_file($_FILES['f_files_']['tmp_name'][$c_], FCPATH.$uploadedfile))
						{
							// Generate thumbnail
							$config['image_library'] = 'gd2';
							$config['source_image'] = FCPATH.$uploadedfile;
							$config['new_image'] = FCPATH.$thumbimg;
							$config['create_thumb'] = FALSE;
							$config['maintain_ratio'] = TRUE;
							$config['width'] = 200;
							$config['height'] = 200;

							$this->image_lib->clear();
							$this->image_lib->initialize($config);
							$this->image_lib->resize();
							
							list($imgWidth, $imgHeight) = getimagesize(FCPATH.$uploadedfile);
							$clientIPaddr	= $_SERVER['REMOTE_ADDR'];
							$imgMetadata = json_encode(array(
								'width'		=> $imgWidth,
								'height'	=> $imgHeight,
								'size'		=> $filesize,
								'uploader'	=> $clientIPaddr,
							));
							$this->load->model('web_galeri_ex');
							$_result = $this->web_galeri_ex->save_photo(
								array(
									$albumId,
									$_FILES['f_files_']['name'][$c_],
									$ekstensi,
									null,
									$uploadedfile,
									$thumbimg,
									$imgMetadata
								),
								$this->nativesession->get('user_id_'),
								$this->nativesession->get('user_name_')
							);
							
							$_result = true;
							if ($_result) {
								$succs++;
								$_files_[] = array(true,"File ".$_FILES['f_files_']['name'][$c_]." berhasil terunggah.",'');
							} else {
								$_files_[] = array(false,"[Query failed] Error mengupload ".$_FILES['f_files_']['name'][$c_].". Silakan coba lagi.",null);
							}
						} else {
							$_files_[] = array(false,"[move_uploaded_file error] Error mengupload ".$_FILES['f_files_']['name'][$c_].". ".
											"Pastikan ukuran file tidak melebihi nilai konfigurasi pada PHP.ini.",null);
						}
					} else { // jika tidak valid / terlalu besar
						$_files_[] = array(false,"Error mengupload ".$_FILES['f_files_']['name'][$c_].". Ukuran dan jenis file harus sesuai.",null);
					}
				} // end is empty f_files_[c_]
			} // end for
		} // end if count(files)
		selesai:
		return $_files_;
	}
	
	private function _do_upload_docs() {
		$this->_prepare_path($this->_mediaPath);
		$this->_prepare_path($this->_mediaPath."docs/");
		
		$_files_ = array(); // array of array [is_success?, message, address]
		
		// proses UPLOAD =============================================
		$tanggal = date("Y-m-d H:i:s");

		$file_type_id = -1;
		$validexts_docs = $this->_allowedDocsExts;
		
		$succs = 0;
		if (!isset($_FILES['f_files_'])) return null;
		if (count($_FILES['f_files_']['name']) > 0) {
			$uploader_ = $_SERVER['REMOTE_ADDR'];
			$id_g = date('dmY');

			for ($c_ = 0; $c_ < count($_FILES['f_files_']['name']); $c_++) {
				if (!empty($_FILES['f_files_']['name'][$c_])) {
					$file_type_id = -1;
					$filesize = $_FILES['f_files_']['size'][$c_];
					$ekstensi = strtolower(end(explode(".", $_FILES['f_files_']['name'][$c_])));
					
					foreach ($validexts_docs as $idx => $allowedTypeExts) {
						if (in_array($ekstensi, $allowedTypeExts)) {
							$file_type_id = $idx;
							break;
						}
					}
					
					if (($file_type_id != -1) && ($filesize <= $this->_uploadMaxSize)) {
						//===== memastikan tidak ada nama file yang sama
						$uploadFileName = basename(strtolower($_FILES['f_files_']['name'][$c_]), ".".$ekstensi);
						$uploadFileName = url_title($uploadFileName, '-', TRUE);
						if (strlen($uploadFileName) > 32)
							$uploadFileName = substr($uploadFileName, -32);
						
						$uploadPath = $this->_mediaPath."docs/";
						
						$dateChunk = date("Ymd");
						$saltChunk = substr(md5(uniqid(rand(), true)), 0, 5);
						$uploadedfile = $uploadPath.sprintf("%s_%s_%s.%s", $dateChunk, $saltChunk, $uploadFileName, $ekstensi);
						
						// Sebenarnya tidak perlu sih...., tapi untuk memastikan sekali lagi....
						$file_c = 1;
						while (file_exists(FCPATH.$uploadedfile)) {
							$saltChunk = substr(md5(uniqid(rand(), true)), 0, 5);
							$uploadedfile = $uploadPath.sprintf("%s_%s.%s", $saltChunk, $uploadFileName, $ekstensi);
							$file_c++;
						}
						
						if (move_uploaded_file($_FILES['f_files_']['tmp_name'][$c_], FCPATH.$uploadedfile))
						{
							$clientIPaddr	= $_SERVER['REMOTE_ADDR'];
							$docSlug = $uploadFileName.".".$ekstensi;
							$this->load->model('web_document');
							$_result = $this->web_document->save_document(
								array(
									$_FILES['f_files_']['name'][$c_],
									$uploadedfile,
									$file_type_id,
									$ekstensi,
									null,
									$filesize,
									$docSlug
								),
								$clientIPaddr,
								$this->nativesession->get('user_id_'),
								$this->nativesession->get('user_name_')
							);
							
							if ($_result) {
								$succs++;
								$_files_[] = array(true,"File ".$_FILES['f_files_']['name'][$c_]." berhasil terunggah.",'');
							} else {
								$_files_[] = array(false,"[Query failed] Error mengupload ".$_FILES['f_files_']['name'][$c_].". Silakan coba lagi.",null);
								$data['errors'][] = 'Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.';
							}
						} else {	
							$_files_[] = array(false,"[move_uploaded_file error] Error mengupload ".$_FILES['f_files_']['name'][$c_].". Silakan coba lagi.",null);
						}
					} else { // jika tidak valid / terlalu besar
						$_files_[] = array(false,"Error mengupload ".$_FILES['f_files_']['name'][$c_].". Ukuran dan jenis file harus sesuai.",null);
					}
				} // end is empty f_files_[c_]
			} // end for
		} // end if count(files)
		selesai_doc:
		return $_files_;
	}
}