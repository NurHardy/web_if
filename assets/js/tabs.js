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
				$("#tab_1").addClass("active");
				$("div.tab_1").fadeIn();
			break;
			case "tab_2":
				$("#tab_2").addClass("active");
				$("div.tab_2").fadeIn();
			break;
			case "tab_3":
				$("#tab_3").addClass("active");
				$("div.tab_3").fadeIn();
			break;
			case "tab_4":
				$("#tab_4").addClass("active");
				$("div.tab_4").fadeIn();
			break;
			case "tab_5":
				$("#tab_5").addClass("active");
				$("div.tab_5").fadeIn();
			break;
		}
		//alert(e.target.id);
		return false;
	});
});

$(document).ready(function(){
	$(".menu_tab_mini > option").click(function(e){
		$(".menu_tab_mini > option").removeClass("active");
		$(".content").css("display", "none");
		switch(e.target.id){
			case "tab_mini_1":
				$("#tab_1").addClass("active");
				$("div.tab_1").fadeIn();
			break;
			case "tab_mini_2":
				$("#tab_2").addClass("active");
				$("div.tab_2").fadeIn();
			break;
			case "tab_mini_3":
				$("#tab_3").addClass("active");
				$("div.tab_3").fadeIn();
			break;
			case "tab_mini_4":
				$("#tab_4").addClass("active");
				$("div.tab_4").fadeIn();
			break;
			case "tab_mini_5":
				$("#tab_5").addClass("active");
				$("div.tab_5").fadeIn();
			break;
		}
		//alert(e.target.id);
		return false;
	});
});