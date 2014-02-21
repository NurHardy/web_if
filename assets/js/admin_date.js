/*************************************************
| admin_date.js
|
| Javascript untuk halaman event dalam admin
| by Muhammad Nur Hardyanto
| Edited:
| > Senin, 13 Januari 2014, 23:22
**************************************************/
	var current = new Date();
	var day = current.getDate();  
	var year = current.getFullYear();
	var month   = current.getMonth()+1;
	var ev_list = [];
	var monthNames = ["Bulan","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November", "Desember"];  
	
	function refreshCalendar() {
		var totalFeb = "28";
		var is_the_month = ((month == current.getMonth()+1)&&(year==current.getFullYear()));
		
		var tempDate = new Date(month +' 1 ,'+year);  
		var tempweekday  = 0;  
		var tempweekday2 = tempDate.getDay();
		var curday = current.getDate();
		if (month == 2){ // Februari
			if ( (year%100!=0) && (year%4==0) || (year%400==0)){  
				totalFeb = 29;  // kabisat
			}else{  
				totalFeb = 28;  
			}  
		}  
		var totalDays = [0,"31", ""+totalFeb+"","31","30","31","30","31","31","30","31","30","31"];  
      
		var padding = "";  
		while (tempweekday < tempweekday2)  {
			padding += "<td class='premonth'></td>";  
			tempweekday++;
		}  
		dayAmount = totalDays[month];  
		i = "1";
		var j = 0;
		var is_ev;
		while (i <= dayAmount){
			if (tempweekday2 > 6){
				tempweekday2 = 0;
				padding += "</tr><tr>";
			}
			
			is_ev = false;
			
			if (j < ev_list.length) {
				if (i == ev_list[j].ev_date) {
					is_ev = true;
					j++;
					while ((j < ev_list.length) && (i == ev_list[j].ev_date)) j++;
				}
			}
			
			if (is_the_month && (i == curday)) padding +="<td class='currentday'>";
			else if (is_ev) padding += "<td style='border: solid 2px #0f0'>";
			else padding +="<td>";
			
			padding += "<a href=\"javascript:void(0);\" onclick=\"blockCell("+(i)+", this);\">"+i+"</a></td>";
			  
			tempweekday2++;
			tempweekday++;
			i++;
		}
		while (tempweekday < 42){
			if (tempweekday2 > 6){
				tempweekday2 = 0;
				padding += "</tr><tr>";
			}
			padding +="<td class='postm'></td>";  
			tempweekday2++;
			tempweekday++;
		}

		var calendarTable = "<table> <tr class='currentmonth'><th colspan='7'>"+monthNames[month]+" "+ year +"</th></tr>";  
		calendarTable +="<tr class='row_day'>  <td>Mgg</td>  <td>Sen</td> <td>Sel</td> <td>Rab</td> <td>Kam</td> <td>Jum</td> <td>Sab</td> </tr>";  
		calendarTable += "<tr>";  
		calendarTable += padding;  
		calendarTable += "</tr></table>";  
		$("#ev_calendar").html(calendarTable);
	}
	function initCalendar() {
		if (month <= 0)  { if (year > 2013) {month = 12; year--;} else {month=1;  return;} };
		if (month >= 13) { if (year < 2020) {month = 1;  year++;} else {month=12; return;} };
		day = 0;
		
		$("#ev_eventlist").html("Loading...");
		$("#ev_date").html(monthNames[month]+" "+year);
		$("#btn_panel").hide();
		
		
		$.post(_ev_form_url, {m: month, y: year},function( data ) {
			try {
				ev_list = JSON.parse(data);
				refreshCalendar();
				$("#ev_cal_month")[0].selectedIndex = (month-1);
				$("#ev_cal_year")[0].selectedIndex  = (year-2013);
				if (ev_list.length != 0) {
					$("#ev_eventlist").html("Terdapat "+ev_list.length+" event.");
				} else $("#ev_eventlist").html("Tidak ada event.");
			} catch (e) {
				$("#ev_eventlist").html("Error parsing data. Please refresh...");
			}
		});
		
		
	}
	
	function blockCell(d_d, e) {
		var list_buffer;
		var list_count = 0;
		var show_add_btn = (year > current.getFullYear());
		day = d_d;
		
		$("#ev_date").html(d_d+' '+monthNames[month]+" "+year);
		if (ev_list.length > 0) {
			list_buffer = "<ol>";
			var i;
			for (i=0;i<ev_list.length;i++) {
				if (ev_list[i].ev_date == d_d) {
					list_buffer += "<li>"+ev_list[i].ev_desc+"</li>";
					list_count++;
				}
			}
			list_buffer += "</ol>"
		}
		if (list_count == 0) list_buffer = "Tidak ada event";
		
		$( "#ev_eventlist" ).html( list_buffer );
		if (year == current.getFullYear()) {
			show_add_btn = (month > (current.getMonth()+1));
			if (month == (current.getMonth()+1)) {
				show_add_btn = (day >= current.getDate());
			}
		}
			
		
		if (show_add_btn) $("#btn_panel").show();
		else $("#btn_panel").hide();
		$(".selectedDay").removeClass();
		$(e).addClass('selectedDay');
	}
	
	function onChangeEvent() {
		month = $("#ev_cal_month")[0].selectedIndex+1;
		year  = $("#ev_cal_year")[0].selectedIndex+2013;
		initCalendar();
	}
	function createNewEvent() {
		var s_arg = ('?d='+day+'&m='+month+'&y='+year);
		window.location.href='/admin/events/newevent'+s_arg;
	}
	
	$(document).ready(function() {
		var current = new Date();
		var x = document.getElementById("ev_cal_month");
		var option;
		
		month = current.getMonth()+1;
		
		for (i=1; i<=12; i++) {
			option = document.createElement("option");
			option.text = monthNames[i];
			x.add(option);
		}
		initCalendar();
	});
	
	