<script type="text/javascript" src="<?php echo base_url("/assets/js/admin_date.js"); ?>"></script>
<script>
var _ev_form_url = "<?php echo base_url("/admin/events/eventajax"); ?>";
</script>
<h2>Event Organizer</h2>
<div id='ev_calendar_box'>
	<div id='ev_calendar_nav'>
		<a href='javascript:month--;initCalendar(month);' class='button_admin' id='ev_cal_nav_prev'>&laquo; Back</a>
		<div id='ev_cal_nav_ctr'>
		<select id='ev_cal_month' onchange='onChangeEvent();'>
			
		</select>
		<select id='ev_cal_year' onchange='onChangeEvent();'>
		<?php
			$year_ = 2013;
			for ($year_ = 2013; $year_ < 2020; $year_++) {
				echo "<option>{$year_}</option>\n";
			}
		?>
		</select>
		</div>
		<a href='javascript:month++;initCalendar(month);' class='button_admin' id='ev_cal_nav_next'>Next &raquo;</a>
		<div class='divclear'></div>
	</div>
	<div id='ev_calendar'>Browser Anda harus mendukung Javascript...</div>
</div>
<hr>
<div id='ev_date'>Date</div>
<div style='padding: 10px; margin-top: 10px;' id='ev_eventlist'>
Informasi seputar tanggal tsb di sini...
</div>
<div id='btn_panel'><button onclick="createNewEvent();" class='button_admin btn_add'>Tambah</button></div>