			<div class='divclear'></div>
		</div> <!-- akhir content -->
		<div id='admin_footer'>&copy; Informatika UNDIP 2014<br>
			<small>Halaman diproses dalam {elapsed_time} detik.</small>
		</div>	
	</div> <!-- akhir wrapper-->
	
	<!-- === OVERLAY ==== -->
	<div id='admin_form_overlay'>
		<div id='admin_ov_formbox'>
			<div id='admin_ov_formheader'>
				<i class="site_icon-pencil"></i> <span id="admin_formwindow_title">Form</span>
			</div>
			<div id='admin_ov_formloading'>Loading...<br>
				<img src='<?php echo base_url('/assets/images/loader.gif'); ?>' alt='Loading...' />
			</div>
			<div id='admin_ov_formcontent'>
			</div>
			<div id='admin_ov_cancel'>
				<a href="#" onclick="return hide_form_overlay();" class="dmw_a_span_red">
					<i class="site_icon-cancel"></i> Close</a>
			</div>
		</div>
	</div>
	<script>
	var ajaxPrefix = "<?php echo base_url("/admin"); ?>";
	var refreshOnClose = false;
	function show_form_overlay(controller, argAct, argId, formTitle) {
		if (is_processing) return;
		refreshOnClose = false;
		$("#admin_formwindow_title").html(formTitle);
		$.ajax({
			type: "POST",
			url: ajaxPrefix+"/"+controller+"/ajax",
			data: {
				act: argAct,
				id: argId
			},
			beforeSend: function( xhr ) {
				is_processing = true;
				$("#admin_ov_formloading").show();
				$("#admin_ov_formcontent").hide();
				$("#admin_ov_cancel").hide();
				$("#admin_form_overlay").fadeIn(100);
			},
			success: function(response){
				$("#admin_ov_formcontent").html(response);
				if (typeof(initPopUpForm) == "function") initPopUpForm();
				$("#admin_ov_formcontent").fadeIn('fast');
			},
			error: function(xhr){
				//alert("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
				$("#admin_ov_formcontent").html("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
			}
		}).always(function() {
			is_processing = false;
			$("#admin_ov_formloading").hide();
			$("#admin_ov_formcontent").show();
			$("#admin_ov_cancel").show();
		});
	}
	function hide_form_overlay() {
		if (refreshOnClose) {
			refreshPage("Refreshing page...");
		} else {
			$("#admin_form_overlay").fadeOut(250);
		}
		return false;
	}
	function hide_form_cancel_button() {$("#admin_ov_cancel").hide();}
	</script>
	</bodY >
</HTml >