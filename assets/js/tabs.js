/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	$(".menu_tab > li").click(function(e){
		$(".menu_tab > li").removeClass("active");
		$(".content").css("display", "none");
		switch(e.target.id){
			case "tab_1":
				$(".menu_tab_mini").prop('selectedIndex', 0);
				$("#tab_1").addClass("active");
				$("div.tab_1").fadeIn();
			break;
			case "tab_2":
				$(".menu_tab_mini").prop('selectedIndex', 1);
				$("#tab_2").addClass("active");
				$("div.tab_2").fadeIn();
			break;
			case "tab_3":
				$(".menu_tab_mini").prop('selectedIndex', 2);
				$("#tab_3").addClass("active");
				$("div.tab_3").fadeIn();
			break;
			case "tab_4":
				$(".menu_tab_mini").prop('selectedIndex', 3);
				$("#tab_4").addClass("active");
				$("div.tab_4").fadeIn();
			break;
			case "tab_5":
				$(".menu_tab_mini").prop('selectedIndex', 4);
				$("#tab_5").addClass("active");
				$("div.tab_5").fadeIn();
			break;
		}
		//alert(e.target.id);
		return false;
	});
});

$(document).ready(function(){
	$(".menu_tab_mini").change(function(e){
		$(".menu_tab > li").removeClass("active");
		$(".content").css("display", "none");
		var menuid = $('option:selected',$(this)).index();
		switch(menuid){
			case 0:
				$("#tab_1").addClass("active");
				$("div.tab_1").fadeIn();
			break;
			case 1:
				$("#tab_2").addClass("active");
				$("div.tab_2").fadeIn();
			break;
			case 2:
				$("#tab_3").addClass("active");
				$("div.tab_3").fadeIn();
			break;
			case 3:
				$("#tab_4").addClass("active");
				$("div.tab_4").fadeIn();
			break;
			case 4:
				$("#tab_5").addClass("active");
				$("div.tab_5").fadeIn();
			break;
		}
		//alert(e.target.id);
		return false;
	});
});