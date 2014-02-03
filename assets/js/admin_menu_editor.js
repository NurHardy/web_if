var selectCtr;
var selIndex;
var editIndex;
var tmpMnu;
var mnuList = [];
var isEditing = false;
var isEdited  = false;

$(document).ready(function() {
	selectCtr = document.getElementById("listMenu");
	
	mnuList = mnuListSaved;
	updateList();
});

function clearList() {
	
	//var length_ = selectCtr.options.length;
	//if (length_ == 0) return;
	selectCtr.options.length = 0;
}
function updateList() {
	clearList();
	if (mnuList.length>0) {
		var c, d; var label;
		var option;
		for (c=0; c<mnuList.length; c++) {
			label = "";
			for (d=1; d<mnuList[c].level; d++) {
				label += "==";
			}
			label += " " + mnuList[c].label;
			option = document.createElement("option");
			option.text = label;
			selectCtr.add(option);
		}
	}
}

function updateControlButtons() {
	if (isEditing) return;
	selIndex = selectCtr.selectedIndex;
	if (selIndex == 0) {
		$('#btnMoveUp').attr("disabled", true);
		$('#btnMoveRight').attr("disabled", true);
	} else {
		$('#btnMoveUp').removeAttr("disabled");
		if (mnuList[selIndex].level >= 3) $('#btnMoveRight').attr("disabled", true);
		else {
			if ((mnuList[selIndex].level-mnuList[selIndex-1].level)>=1) $('#btnMoveRight').attr("disabled", true);
			else $('#btnMoveRight').removeAttr("disabled");
		}
	}
	if (selIndex == (mnuList.length-1)) $('#btnMoveDown').attr("disabled", true); else $('#btnMoveDown').removeAttr("disabled");
	if (mnuList[selIndex].level == 1) $('#btnMoveLeft').attr("disabled", true); else $('#btnMoveLeft').removeAttr("disabled");
}

function moveItemUp() {
	selIndex = selectCtr.selectedIndex;
	if (selIndex > 0) {
		var $op = $('#listMenu option:selected');
		if ($op.length){
			$op.first().prev().before($op);
			
			tmpMnu = mnuList[selIndex-1];
			mnuList[selIndex-1] = mnuList[selIndex];
			mnuList[selIndex] = tmpMnu;
			
		}
		updateControlButtons()
	};
}
function moveItemDown() {
	selIndex = selectCtr.selectedIndex;
	if (selIndex < (mnuList.length-1)) {
		var $op = $('#listMenu option:selected');
		if ($op.length){
			$op.last().next().after($op);
			
			tmpMnu = mnuList[selIndex+1];
			mnuList[selIndex+1] = mnuList[selIndex];
			mnuList[selIndex] = tmpMnu;
			
		}
		updateControlButtons();
	};
}

function moveItemLeft() {
	selIndex = selectCtr.selectedIndex;
	if (mnuList[selIndex].level > 1) {
		var d;
		mnuList[selIndex].level--;
		label = "";
		for (d=1; d<mnuList[selIndex].level; d++) {
			label += "==";
		}
		label += " " + mnuList[selIndex].label;
		selectCtr.options[selIndex].text = label;
		updateControlButtons()
	};
}
function moveItemRight() {
	selIndex = selectCtr.selectedIndex;
	if (mnuList[selIndex].level < 3) {
		if ((mnuList[selIndex].level-mnuList[selIndex-1].level)>=1) return;
		var d;
		mnuList[selIndex].level++;
		label = "";
		for (d=1; d<mnuList[selIndex].level; d++) {
			label += "==";
		}
		label += " " + mnuList[selIndex].label;
		selectCtr.options[selIndex].text = label;
		updateControlButtons()
	};
}

function removeSelectedItem() {
	selIndex = selectCtr.selectedIndex;
	if (selIndex >= 0) {
		var r=confirm("Hapus menu "+mnuList[selIndex].label+'?');
		if (r==true) {
			mnuList.splice(selIndex,1);
			selectCtr.remove(selIndex);
		}
	}
}
function addNewItem() {
	var option;
	option = document.createElement("option");
	option.text = "New menu";
	selectCtr.add(option);
	mnuList.push({label:'New menu',level: 1, url: ''});
}
function editMenuItem() {
	if (isEditing) return;
	selIndex = selectCtr.selectedIndex;
	if (selIndex >= 0) {
		var $op = $('#listMenu option:selected');
		$op.addClass('itemActive');
		isEditing = true;
		editIndex = selIndex;
		$("#txtMenuLabel").val(mnuList[selIndex].label);
		$("#txtMenuURL").val(mnuList[selIndex].url);
		$("#menuControl").hide();
		$("#menuEditForm").show();
	}
}
function endEditing() {
	var $op = $('#listMenu .itemActive');
	$op.removeClass('itemActive');
	isEditing = false;
	$("#menuControl").show();
	$("#menuEditForm").hide();
}
function saveEditingState() {
	mnuList[editIndex].label = $("#txtMenuLabel").val();
	mnuList[editIndex].url	= $("#txtMenuURL").val();
	updateList();
	endEditing();
}
function saveMenu() {
	$.post( "/admin/savemenu", {JSON_menu: JSON.stringify(mnuList)},function( data ) {
		$("#editorMessage").html(data);
	});
}