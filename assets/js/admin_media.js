$(document).ready(function()
{

	var options = { 
		beforeSend: function() 
		{
			$("#media_form").hide();
			$("#media_result").hide();
			$("#media_uploadprogress").show();
			//clear everything
			$("#media_progressbar").width('0%');
			$("#media_progressnumb").html("0%");
		},
		uploadProgress: function(event, position, total, percentComplete) 
		{
			$("#media_progressbar").width(percentComplete+'%');
			$("#media_progressnumb").html(percentComplete+'%');
		},
		success: function() 
		{
			$("#media_progressbar").width('100%');
			$("#media_progressnumb").html('100%');

		},
		complete: function(response) 
		{
			$("#media_result").show();
			$("#media_result").html(response.responseText);
		},
		error: function()
		{
			$("#media_form").show();
			$("#media_uploadprogress").hide();
			$("#media_result").show();
			$("#media_result").html("<font color='red'> ERROR: unable to upload files</font>");
		}
	}; 

     $("#media_form").ajaxForm(options);
});
