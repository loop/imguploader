
var Uploader={
	seconds:0,
	minutes:0,
	hours:0,
	start_time:0,
	upload_id:null,
	total_upload_size:0,
	total_kbytes:0,
	toggle_upload_stats:0,
	file_label_highlight_on:'#FFFFE0',
	file_label_highlight_off:'#F9F9F9',
	CPB_loop:false,
	CPB_width:0,
	CPB_bytes:0,
	CPB_time_width:500,
	CPB_time_bytes:15,
	CPB_hold:true,
	CPB_byte_timer:null,
	CPB_status_timer:null,
	BPB_width_inc:0,
	BPB_width_new:0,
	BPB_width_old:0,
	BPB_timer:null,
	UP_timer:null,
	progress_data:null,
	path_to_link_script:"link_upload.php",
	path_to_set_progress_script:"set_progress.php",
	path_to_get_progress_script:"get_progress.php",
	path_to_upload_script:"/cgi-bin/upload.cgi",
	check_allow_extensions_on_client:1,
	check_disallow_extensions_on_client:null,
	allow_extensions:'(jpg|jpeg|gif|bmp|png)',
	disallow_extensions:null,
	check_file_name_format:null,
	check_file_name_regex:null,
	check_file_name_error_message:null,
	max_file_name_chars:null,
	min_file_name_chars:null,
	check_null_file_count:1,
	check_duplicate_file_count:1,
	max_upload_slots:null,
	cedric_progress_bar:0,
	cedric_hold_to_sync:0,
	bucket_progress_bar:1,
	progress_bar_width:400,
	block_ui_enabled:1,
	show_percent_complete:1,
	show_files_uploaded:null,
	show_current_position:null,
	show_current_file:null,
	show_elapsed_time:null,
	show_est_time_left:null,
	show_est_speed:null,

	getFileName:function(slot_value){
		var index_of_last_slash = slot_value.lastIndexOf("\\");

		if(index_of_last_slash < 1){ index_of_last_slash = slot_value.lastIndexOf("/"); }

		var file_name = slot_value.slice(index_of_last_slash + 1, slot_value.length);

		return file_name;
	},

	getFileExtension:function(slot_value){
		var file_extension = slot_value.substring(slot_value.lastIndexOf(".") + 1, slot_value.length).toLowerCase();

		return file_extension;
	},

	highlightFileLabel:function(file_label, color){ JQ("#" + file_label).css({background:color}); },

	clearFileLabels:function(){
		JQ("#upload_form").find(":file").each(function(){
			Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_off);
		});
	},

	// Check the file format before uploading
	checkFileNameFormat:function(){
		if(!Uploader.check_file_name_format){ return false; }

		var found_error = false;

		JQ("#upload_form").find(":file").each(function(){
			if(JQ(this).val() !== ""){
				var file_name = Uploader.getFileName(JQ(this).val());

				if(file_name.length > Uploader.max_file_name_chars){
					Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_on);
					Uploader.showAlert("Error, file name cannot be more than " + Uploader.max_file_name_chars + " characters.", 500, 85, Uploader.block_ui_enabled);
					found_error = true;
				}

				if(file_name.length < Uploader.min_file_name_chars){
					Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_on);
					Uploader.showAlert("Error, file name cannot be less than " + Uploader.min_file_name_chars + " characters.", 500, 85, Uploader.block_ui_enabled);
					found_error = true;
				}

				if(!Uploader.check_file_name_regex.test(file_name)){
					Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_on);
					Uploader.showAlert(Uploader.check_file_name_error_message, 500, 85, Uploader.block_ui_enabled);
					found_error = true;
				}
			}
		});

		return found_error;
	},

	// Check for legal file extentions
	checkAllowFileExtensions:function(){
		if(!Uploader.check_allow_extensions_on_client){ return false; }

		var found_error = false;

		JQ("#upload_form").find(":file").each(function(){
			if(JQ(this).val() !== ""){
				var file_extension = Uploader.getFileExtension(Uploader.getFileName(JQ(this).val()));

				if(!file_extension.match(Uploader.allow_extensions)){
					Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_on);
					Uploader.showAlert('Sorry, uploading a file with the extension "' + file_extension + '" is not allowed.', 500, 85, Uploader.block_ui_enabled);
					found_error = true;
				}
			}
		});

		return found_error;
	},

	// Check for illegal file extentions
	checkDisallowFileExtensions:function(){
		if(!Uploader.check_disallow_extensions_on_client){ return false; }

		var found_error = false;

		JQ("#upload_form").find(":file").each(function(){
			if(JQ(this).val() !== ""){
				var file_extension = Uploader.getFileExtension(Uploader.getFileName(JQ(this).val()));

				if(file_extension.match(Uploader.disallow_extensions)){
					Uploader.highlightFileLabel(JQ(this).attr("id") + "_label", Uploader.file_label_highlight_on);
					Uploader.showAlert('Sorry, uploading a file with the extension "' + file_extension + '" is not allowed.', 500, 85, Uploader.block_ui_enabled);
					found_error = true;
				}
			}
		});

		return found_error;
	},

	// Make sure the user selected at least one file
	checkNullFileCount:function(){
		if(!Uploader.check_null_file_count){ return false; }

		var found_file = false;

		JQ("#upload_form").find(':file').each(function(){
			if(JQ(this).val() !== ""){ found_file = true; }
		});

		if(!found_file){
			Uploader.showAlert("Please Choose A File To Upload.", 400, 80, Uploader.block_ui_enabled);
			return true;
		}
		else{ return false; }
	},

	// Make sure the user is not uploading duplicate files
	checkDuplicateFileCount:function(){
		if(!Uploader.check_duplicate_file_count){ return false; }

		var found_duplicate = false;
		var file_count = 0;
		var file_name_array = [];

		JQ("#upload_form").find(":file").each(function(){
			if(JQ(this).val() !== ""){
				var obj = {};
				obj.file_name = Uploader.getFileName(JQ(this).val());
				obj.label_name = JQ(this).attr("id") + "_label";
				file_name_array[file_count] = obj;
				file_count++;
			}
		});

		for(var i = 0; i < file_name_array.length; i++){
			var obj_1 = file_name_array[i];

			for(var j = 0; j < file_name_array.length; j++){
				var obj_2 = file_name_array[j];

				if(obj_1.file_name === obj_2.file_name && obj_1.label_name !== obj_2.label_name){
					found_duplicate = true;
					Uploader.highlightFileLabel(obj_1.label_name, Uploader.file_label_highlight_on);
					Uploader.highlightFileLabel(obj_2.label_name, Uploader.file_label_highlight_on);
				}
			}
		}

		if(found_duplicate){
			Uploader.showAlert("Duplicate upload files detected.", 400, 80, Uploader.block_ui_enabled);
			return true;
		}
		else{ return false; }
	},

	showAlert:function(alert_message, alert_width, alert_height, block_ui_enabled){
		if(!block_ui_enabled){ alert(alert_message); }
		else{
			alert_message = "<br>" + alert_message + "<br><br><input style='width:75px;' type='button' id='ok_btn' name='ok' value='OK' onClick='JQ.unblockUI();'>";

			JQ.blockUI({
				message:alert_message,
				css:{
					width:alert_width+'px',
					height:alert_height+'px',
					top:(JQ(window).height() / 3) - (alert_height / 2) + 'px',
					left:(JQ(window).width() / 2) - (alert_width / 2) + 'px',
					textAlign:'center',
					cursor:'default',
					backgroundColor:'#EDEDED',
					borderColor:'#D9D9D9',
					color:'black',
					font:'14px Arial',
					fontWeight:'bold',
					padding:'2px',
					opacity:'1',
					'-webkit-border-radius':'2px',
					'-moz-border-radius':'2px'
				},
				overlayCSS:{
					cursor:'default',
					applyPlatformOpacityRules:true
				}
			});
		}
	},

	showCGIOutput:function(CGI_message, reset_page){
		Uploader.showAlert(CGI_message, 400, 80, Uploader.block_ui_enabled);
		if(reset_page){ Uploader.resetFileUploadPage(); }
	},

	showDebugMessage:function(message){ JQ("#uploader_debug").append(message + "<br>"); },

	showAlertMessage:function(message){ JQ("#uploader_alert").html(message); },

	redirectAfterUpload:function(redirect_url, embedded_upload_results){
		redirect_url = decodeURIComponent(redirect_url);

		if(embedded_upload_results){
			JQ(document).ready(function(){ JQ('#upload_container').html('<p align="center"><img src="./assets/images/ajax-loader.gif" /></p>'); JQ('#upload_container').load(redirect_url);});
			Uploader.showEmbeddedUploadResults();
			JQ("#upload_form").hide();
			JQ("#choose").hide();
		}
		else{ self.location.href = redirect_url; }
	},

	showEmbeddedUploadResults:function(){
		Uploader.stopDataLoop();
		Uploader.resetProgressBar();

		JQ("#uploader_alert").html("");
		JQ("#upload_container").show();
		JQ("#reset_button").val("Reset");
		JQ(".upfile_ultimo").remove();
		JQ(".upfile").remove();
		JQ(".upfile_label").remove();
		JQ("#upload_button").show();
		JQ("#upload_slots_container").hide();

		Uploader.addUploadSlot();
	},

	stopDataLoop:function(){
		Uploader.CPB_loop = false;
		clearInterval(Uploader.UP_timer);
		clearInterval(Uploader.BPB_timer);

		if(Uploader.cedric_progress_bar){
			if(Uploader.show_current_position){ clearTimeout(Uploader.CPB_byte_timer); }
			clearTimeout(Uploader.CPB_status_timer);
		}
	},

	// Reset the progress bar
	resetProgressBar:function(){
		JQ("#progress_bar_container").hide();
		JQ("#upload_stats_container").hide();

		Uploader.seconds = 0;
		Uploader.minutes = 0;
		Uploader.hours = 0;
		Uploader.start_time = 0;
		Uploader.upload_id = '';
		Uploader.progress_data = '';
		Uploader.total_upload_size = 0;
		Uploader.total_kbytes = 0;
		Uploader.toggle_upload_stats = 0;
		Uploader.CPB_loop = false;
		Uploader.CPB_width = 0;
		Uploader.CPB_bytes = 0;
		Uploader.CPB_hold = true;
		Uploader.BPB_width_inc = 0;
		Uploader.BPB_width_new = 0;
		Uploader.BPB_width_old = 0;

		JQ("#progress_bar").css("width", "0px");

		if(Uploader.show_files_uploaded || Uploader.show_current_position || Uploader.show_elapsed_time || Uploader.show_est_time_left || Uploader.show_est_speed){
			JQ("#upload_stats_toggle").html("[+]");
			//JQ("#upload_stats_toggle").css({ backgroundImage : "url(./images/toggle.png)" });
		}

		if(Uploader.show_percent_complete){ JQ("#percent_complete").html("0%"); }
		if(Uploader.show_files_uploaded){ JQ("#files_uploaded").html("0"); }
		if(Uploader.show_files_uploaded){ JQ("#total_uploads").html("0"); }
		if(Uploader.show_current_position){ JQ("#current_position").html("0"); }
		if(Uploader.show_current_position){ JQ("#total_kbytes").html("0"); }
		if(Uploader.show_elapsed_time){ JQ("#elapsed_time").html("00:00:00"); }
		if(Uploader.show_est_time_left){ JQ("#est_time_left").html("00:00:00"); }
		if(Uploader.show_est_speed){ JQ("#est_speed").html("0"); }
	},

	resetUploadDiv:function(){
		JQ("#upload_container").hide();
		JQ("#upload_container").html("");
	},

	// Initialize the file upload page
	resetFileUploadPage:function(){
		Uploader.stopDataLoop();
		Uploader.resetProgressBar();
		Uploader.resetUploadDiv();

		JQ("#uploader_alert").html("");
		JQ("#reset_button").val("Reset");
		JQ(".upfile_ultimo").remove();
		JQ(".upfile").remove();
		JQ(".upfile_label").remove();
		JQ("#upload_button").show();
		JQ("#upload_slots_container").hide();
		JQ("#upload_form_values_container").show();
		JQ("#choose").show();

		Uploader.addUploadSlot();
	},

	// Link the upload
	linkUpload:function(){
		if(Uploader.check_file_name_format || Uploader.check_allow_extensions_on_client || Uploader.check_disallow_extensions_on_client || Uploader.check_duplicate_file_count){ Uploader.clearFileLabels(); }
		if(Uploader.checkFileNameFormat()){ return false; }
		if(Uploader.checkAllowFileExtensions()){ return false; }
		if(Uploader.checkDisallowFileExtensions()){ return false; }
		if(Uploader.checkNullFileCount()){ return false; }
		if(Uploader.checkDuplicateFileCount()){ return false; }

		JQ("#upload_button").hide();
		
		JQ("#choose").hide();

		if(Uploader.show_files_uploaded){ JQ("#total_uploads").html(JQ(".upfile").length - 1); }

		var form_data = JQ("#upload_form").serialize();
		var file_data = Uploader.serializeFileNames();
		var data = form_data + "&" + file_data;

		JQ.post(Uploader.path_to_link_script, data, function(){}, "script");

		return false;
	},

	// Add upload file names to serialized data
	// Based on jQuery.serializeAnything by Bramus! (Bram Van Damme)
	serializeFileNames:function(){
		var toReturn = [];

		JQ("#upload_form").find(":file").each(function(){
			if(JQ(this).val() !== ""){
				var file_name = Uploader.getFileName(JQ(this).val());
				toReturn.push("upload_file[]" + "=" + encodeURIComponent(file_name));
			}
		});

		return toReturn.join("&").replace(/%20/g, "+");
	},

	// Initialize progress bar
	initializeProgressBar:function(upload_id, debug_ajax){
		if(debug_ajax){ Uploader.showDebugMessage("Initializing Progress Bar: " + Uploader.path_to_set_progress_script + '?upload_id=' + upload_id); }

		var data = "upload_id=" + upload_id;

		JQ.get(Uploader.path_to_set_progress_script, data, function(){}, "script");
	},

	//Submit the upload form
	startUpload:function(upload_id, debug_upload, debug_ajax){
		Uploader.resetUploadDiv();

		var iframe_name = "upload_iframe_" + upload_id;

		if(debug_ajax){ Uploader.showDebugMessage("Submitting Upload: "+Uploader.path_to_upload_script+"?upload_id=" + upload_id); }

		JQ("#upload_container").html("<iframe name='"+iframe_name+"' frameborder='0' width='780' height='200' scrolling='auto'></iframe>");
		JQ("#upload_form").attr("target", iframe_name);
		JQ("#upload_form").attr("action", Uploader.path_to_upload_script + "?upload_id=" + upload_id);
		JQ("#upload_slots_container").fadeOut("fast");
		JQ("#upload_form_values_container").fadeOut("fast");
		JQ(".upfile_ultimo").fadeOut("fast");
		JQ("#upload_form").submit();
		JQ("#reset_button").val("Stop Upload");

		if(!debug_upload){ Uploader.initializeProgressBar(upload_id, debug_ajax); }
		else{ Uploader.showAlertMessage("Debug Uploader Detected, Please Wait..."); }
	},

	// Stop the upload
	stopUpload:function(){
		try{ document.execCommand("Stop"); }
		catch(e){}
		try{ window.stop(); }
		catch(e){}

		JQ("#upload_slots_container").fadeIn("fast");
		JQ("#upload_form_values_container").fadeIn("fast");
		JQ("#upload_button").show();
		JQ("#reset_button").val("Reset");
	},

	// Get the progress of the upload
	getProgressStatus:function(){
		if(Uploader.CPB_loop){
			JQ.get(Uploader.path_to_get_progress_script, Uploader.progress_data, function(){}, "script");
		}
	},

	// Make the progress bar smooth
	smoothCedricStatus:function(){
		if(Uploader.CPB_width < Uploader.progress_bar_width && !Uploader.CPB_hold){
			Uploader.CPB_width++;
			JQ("#progress_bar").css("width", Uploader.CPB_width + "px");
		}

		if(Uploader.CPB_loop){
			clearTimeout(Uploader.CPB_status_timer);
			Uploader.CPB_status_timer = setTimeout("Uploader.smoothCedricStatus()", Uploader.CPB_time_width);
		}
	},

	// Make the bytes uploaded smooth
	smoothCedricBytes:function(){
		if(Uploader.CPB_bytes < Uploader.total_kbytes && !Uploader.CPB_hold){
			Uploader.CPB_bytes++;
			JQ("#current_position").html(Uploader.CPB_bytes);
		}

		if(Uploader.CPB_loop){
			clearTimeout(Uploader.CPB_byte_timer);
			Uploader.CPB_byte_timer = setTimeout("Uploader.smoothCedricBytes()", Uploader.CPB_time_bytes);
		}
	},

	//Start the progress bar
	startProgressBar:function(upload_id, upload_size, start_time){
		Uploader.upload_id = upload_id;
		Uploader.total_upload_size = upload_size;
		Uploader.start_time = start_time;
		Uploader.progress_data = "upload_id=" + Uploader.upload_id + "&start_time=" + Uploader.start_time + "&total_upload_size=" + Uploader.total_upload_size;
		Uploader.total_kbytes = Math.round(Uploader.total_upload_size / 1024);
		Uploader.CPB_loop = true;

		JQ("#progress_bar_container").fadeIn("fast");
		Uploader.showAlertMessage("Upload In Progress");

		if(Uploader.show_current_position){ JQ("#total_kbytes").html(Uploader.total_kbytes + " "); }
		if(Uploader.show_elapsed_time){ Uploader.UP_timer = setInterval("Uploader.getElapsedTime()", 1000); }

		Uploader.getProgressStatus();

		if(Uploader.cedric_progress_bar){
			if(Uploader.show_current_position){ Uploader.smoothCedricBytes(); }
			Uploader.smoothCedricStatus();
		}
	},

	// Calculate and display upload information
	setProgressStatus:function(total_bytes_read, files_uploaded, current_file, bytes_read, lapsed_time){
		var byte_speed = 0;
		var time_remaining = 0;

		if(lapsed_time > 0){ byte_speed = total_bytes_read / lapsed_time; }
		if(byte_speed > 0){ time_remaining = Math.round((Uploader.total_upload_size - total_bytes_read) / byte_speed); }

		if(Uploader.cedric_progress_bar === 1){
			if(byte_speed !== 0){
				var temp_CPB_time_width = Math.round(Uploader.total_upload_size * 1000 / (byte_speed * Uploader.progress_bar_width));
				var temp_CPB_time_bytes = Math.round(1024000 / byte_speed);

				if(temp_CPB_time_width < 5001){ Uploader.CPB_time_width = temp_CPB_time_width; }
				if(temp_CPB_time_bytes < 5001){ Uploader.CPB_time_bytes = temp_CPB_time_bytes; }
			}
			else{
				Uploader.CPB_time_width = 500;
				Uploader.CPB_time_bytes = 15;
			}
		}

		// Calculate percent_complete finished
		var percent_complete = Math.floor(100 * parseInt(total_bytes_read, 10) / parseInt(Uploader.total_upload_size, 10));

		if(percent_complete === Infinity){ percent_complete = 0; }

		var progress_bar_status = Math.floor(Uploader.progress_bar_width * (parseInt(total_bytes_read, 10) / parseInt(Uploader.total_upload_size, 10)));

		// Calculate time remaining
		var remaining_sec = (time_remaining % 60);
		var remaining_min = (((time_remaining - remaining_sec) % 3600) / 60);
		var remaining_hours = ((((time_remaining - remaining_sec) - (remaining_min * 60)) % 86400) / 3600);

		if(remaining_sec < 10){ remaining_sec = "0" + remaining_sec; }
		if(remaining_min < 10){ remaining_min = "0" + remaining_min; }
		if(remaining_hours < 10){ remaining_hours = "0" + remaining_hours; }

		var est_time_left = remaining_hours + ":" + remaining_min + ":" + remaining_sec;
		var est_speed = Math.round(byte_speed / 1024);
		var current_position = Math.round(total_bytes_read / 1024);

		if(Uploader.cedric_progress_bar === 1){
			if(Uploader.cedric_hold_to_sync){
				if(progress_bar_status < Uploader.CPB_width){ Uploader.CPB_hold = true; }
				else{
					Uploader.CPB_hold = false;
					Uploader.CPB_width = progress_bar_status;
					Uploader.CPB_bytes = current_position;
				}
			}
			else{
				Uploader.CPB_hold = false;
				Uploader.CPB_width = progress_bar_status;
				Uploader.CPB_bytes = current_position;
			}

			JQ("#progress_bar").css("width", progress_bar_status + "px");
		}
		else if(Uploader.bucket_progress_bar === 1){
			Uploader.BPB_width_old = Uploader.BPB_width_new;
			Uploader.BPB_width_new = progress_bar_status;

			if((Uploader.BPB_width_inc < Uploader.BPB_width_old) && (Uploader.BPB_width_new > Uploader.BPB_width_old)){ Uploader.BPB_width_inc = Uploader.BPB_width_old; }

			clearInterval(Uploader.BPB_timer);
			Uploader.BPB_timer = setInterval("Uploader.incrementProgressBar()", 10);
		}
		else{ JQ("#progress_bar").css("width", progress_bar_status + "px"); }

		if(Uploader.show_current_position){ JQ("#current_position").html(current_position); }
		if(Uploader.show_current_file){ JQ("#current_file").html(current_file); }
		if(Uploader.show_percent_complete){ JQ("#percent_complete").html(percent_complete + "%"); }
		if(Uploader.show_files_uploaded){ if(files_uploaded > 0){ JQ("#files_uploaded").html(files_uploaded); } }
		if(Uploader.show_est_time_left){ JQ("#est_time_left").html(est_time_left); }
		if(Uploader.show_est_speed){ JQ("#est_speed").html(est_speed); }
	},

	incrementProgressBar:function(){
		if(Uploader.BPB_width_inc < Uploader.BPB_width_new){
			Uploader.BPB_width_inc++;
			JQ("#progress_bar").css("width", Uploader.BPB_width_inc + "px");
		}
	},

	// Calculate the time spent uploading
	getElapsedTime:function(){
		Uploader.seconds++;

		if(Uploader.seconds === 60){
			Uploader.seconds = 0;
			Uploader.minutes++;
		}

		if(Uploader.minutes === 60){
			Uploader.minutes = 0;
			Uploader.hours++;
		}

		var hr = "" + ((Uploader.hours < 10) ? "0" : "") + Uploader.hours;
		var min = "" + ((Uploader.minutes < 10) ? "0" : "") + Uploader.minutes;
		var sec = "" + ((Uploader.seconds < 10) ? "0" : "") + Uploader.seconds;

		JQ("#elapsed_time").html(hr + ":" + min + ":" + sec);
	},

	// Add one upload slot
	addUploadSlot:function(){
		if(JQ(".upfile_ultimo").val() !== ""){
			if(JQ(".upfile").length < Uploader.max_upload_slots + 1){
				if(JQ(".upfile").length > 0){
					JQ(".upfile_ultimo").hide();
					JQ("#upload_slots_container").show();
					JQ("#upload_slots_container").append('<div class="upfile_label" id="' + JQ(".upfile_ultimo").attr("id") +'_label"><span class="upfile_name">' + Uploader.getFileName(JQ(".upfile_ultimo").val()) + '</span><span class="upfile_remove" title="Remove File" onClick="Uploader.deleteUploadSlot(\'' + JQ(".upfile_ultimo").attr("id") + '\')"></span></div>');
					//JQ("#upload_slots_container").append('<div class="upfile_label" id="' + JQ(".upfile_ultimo").attr("id") +'_label"><span class="upfile_name">' + Uploader.getFileName(JQ(".upfile_ultimo").val()) + '</span><span class="upfile_remove" title="Remove File" onClick="Uploader.deleteUploadSlot(\'' + JQ(".upfile_ultimo").attr("id") + '\')"></span></div>');
				}

				var id = new Date().getTime();

				JQ(".upfile_ultimo").removeClass("upfile_ultimo");
				JQ("#file_picker_container").prepend('<input type="file" class="upfile upfile_ultimo" name="upfile_' + id + '" id="upfile_' + id + '" size="35" value="">');
				JQ("#upfile_" + id).bind("keypress", function(e){
					var code = (e.keyCode ? e.keyCode : e.which);
					if(code === 13){ return false; }
				});
				JQ("#upfile_" + id).bind("change", function(e){ Uploader.addUploadSlot(); });

				if(JQ(".upfile").length > Uploader.max_upload_slots){ JQ(".upfile_ultimo").fadeOut("fast"); }
			}
		}
	},

	deleteUploadSlot:function(id){
		JQ("#"+id).remove();
		JQ("#"+id+'_label').remove();

		if(JQ(".upfile").length <= Uploader.max_upload_slots){ JQ(".upfile_ultimo").fadeIn("fast"); }
		if(JQ(".upfile").length === 1){ JQ("#upload_slots_container").hide(); }
	},

	toggleUploadStats:function(){
		if(Uploader.toggle_upload_stats){
			if(Uploader.show_files_uploaded || Uploader.show_current_position || Uploader.show_elapsed_time || Uploader.show_est_time_left || Uploader.show_est_speed){
				JQ("#upload_stats_toggle").html("[+]");
				//JQ("#upload_stats_toggle").css({ backgroundImage : "url(./images/toggle.png)" });
			}

			JQ("#upload_stats_container").slideUp("fast");
			Uploader.toggle_upload_stats = 0;
		}
		else{
			if(Uploader.show_files_uploaded || Uploader.show_current_position || Uploader.show_elapsed_time || Uploader.show_est_time_left || Uploader.show_est_speed){
				JQ("#upload_stats_toggle").html("[-]");
				//JQ("#upload_stats_toggle").css({ backgroundImage : "url(./images/toggle_collapse.png)" });
			}

			JQ("#upload_stats_container").slideDown("fast");
			Uploader.toggle_upload_stats = 1;
		}
	}
};