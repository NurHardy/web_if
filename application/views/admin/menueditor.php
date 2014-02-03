<?php
	$json_ret = "";
	if (!file_exists(FCPATH."/assets/menu.json")) {
		$json_ret = "[]";
		
	} else {
		$json_ret = file_get_contents(FCPATH."/assets/menu.json");
		if ($json_ret == "") $json_ret = "[]";
		//echo ($json_ret);
	}
?>
<script type="text/javascript" src="/assets/js/admin_menu_editor.js"></script>
<script>
var mnuListSaved = <?php echo $json_ret; ?>;
</script>

<h2>Menu Editor</h2>
<div id='menuEditorWorkspace'>
	<div style='width: 300px; float: left;'>
		<select size="15" style='width: 250px' id='listMenu' style='padding: 10px;' onchange='updateControlButtons();' ondblclick='editMenuItem()'>
			
		</select>
		<div id='menuControl'>
			<button onclick='editMenuItem();' id='btnEdit'>Edit Item</button><br>
			<button onclick='moveItemUp();' id='btnMoveUp'>Move Up</button><br>
			<button onclick='moveItemLeft();' id='btnMoveLeft'>&lt;</button><button onclick='moveItemRight();' id='btnMoveRight'>&gt;</button><br>
			<button onclick='moveItemDown();' id='btnMoveDown'>Move Down</button><br>
			<button onclick='removeSelectedItem();'>Remove Item</button>
			<button onclick='addNewItem();'>Add Menu Item</button>
			<button onclick='saveMenu()'>Save Menu</button>
		</div>
	</div>
	<div id='menuEditForm'>
		<label for='txtMenuLabel'>Menu Label:</label><br>
		<input type='text' id='txtMenuLabel' value=''/><br>
		<label for='txtMenuURL'>Alamat URL:</label><br>
		<input type='text' id='txtMenuURL' value=''/><br>
		<input type='button' value='Cancel' onclick='endEditing();'/><input type='button' value='Save' onclick='saveEditingState();'/>
	</div>
	<div class='divclear'></div>
	<div id='editorMessage'></div>
</div>