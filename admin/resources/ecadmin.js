
$( function() {

	$( "#searchbox" ).keyup(function() {
	  doSearch();
	});

} );




var updateRightSide = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();
	
	$('#searchbox').val('');
	
	if(selectedObject!=""){
	
		$('#newbutton').show();
		$('#searchboxwrapper').show();
		$("#searchlist").html("");
		$("#rightwrapper").html("");
		hideBottomButtons();
	
	}else{
		
		$('#newbutton').hide();
		$('#searchboxwrapper').hide();
		$("#searchlist").html("");
		$("#rightwrapper").html("");
		hideBottomButtons();
	
	}

}


var hideObjectDetails = function() {
	$('#objectdetails').hide("slow");
	$('#showDetailsButtonDiv').show();
	$('#hideDetailsButtonDiv').hide();
}

var showObjectDetails = function() {
	$('#showDetailsButtonDiv').hide();
	$('#hideDetailsButtonDiv').show();
	$('#objectdetails').css("display:block;");
}



var showBottomButtons = function() {
	$('#bottombuttons').show();
}

var hideBottomButtons = function() {
	$('#bottombuttons').hide();
}

var showDeleteButton = function() {
	$('#deletebutton').html('<button class="menubutton" onClick="doDeprecate();"><span>DEPRECATE</span></button>');
}

var showEditButton = function() {
	$('#editbutton').html('<button class="menubutton" onClick="doEdit();"><span>EDIT</span></button>');
}

var showCancelButton = function() {
	$('#cancelbutton').html('<button class="menubutton" onClick="doCancel();"><span>CANCEL</span></button>');
}

var showSaveButton = function() {
	$('#savebutton').html('<button class="menubutton" onClick="doSave();"><span>SAVE</span></button>');
}


var hideDeleteButton = function() {
	$('#deletebutton').html('<button class="menubuttonoff"><span>DEPRECATE</span></button>');
}

var hideEditButton = function() {
	$('#editbutton').html('<button class="menubuttonoff"><span>EDIT</span></button>');
}

var hideCancelButton = function() {
	$('#cancelbutton').html('<button class="menubuttonoff"><span>CANCEL</span></button>');
}

var hideSaveButton = function() {
	$('#savebutton').html('<button class="menubuttonoff"><span>SAVE</span></button>');
}



var doSearch = function() {

	var val = $('#searchbox').val();
	var url = "";
	
	if(val.length > 0){
	
		var selectedObject = $('#objselect').find(":selected").val();
	
		if(selectedObject=="equipment"){
	
			//$("#rightwrapper").html(val);
			url = "/REST/equipment?query="+val;
	
		}else if(selectedObject=="expedition"){
	
			url = "/REST/expedition?query="+val;
			
		}else if(selectedObject=="analytical_method"){
	
			url = "/REST/method?query="+val;

		}else if(selectedObject=="chemical_analysis"){
	
			url = "/REST/chemicalanalysis?query="+val;
	
		}else if(selectedObject=="reporting_variable"){
	
			url = "/REST/resulttemplate?query="+val;
	
		}else if(selectedObject==""){
		
		
	
		}
		
		if(url!=""){
			var thishtml = "";
			$.getJSON(url, function(data){
				if(data.resultcount>0){
					_.each(data.results, function(res){
						
						if(selectedObject=="equipment"){
							thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.equipment_num+'\');">'+res.equipment_name+'</div>';
						}else if (selectedObject=="expedition"){
							thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.expedition_num+'\');">'+res.expedition_name+'</div>';
						}else if (selectedObject=="analytical_method"){
							thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.method_num+'\');">'+res.method_name+'</div>';
						}else if (selectedObject=="chemical_analysis"){
							thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.chemical_analysis_num+'\');">'+res.chemical_analysis_num+'</div>';
						}else if (selectedObject=="reporting_variable"){
							thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.result_template_num+'\');">'+res.reporting_variable_name+'</div>';
						}

						/*
						if(selectedObject=="equipment"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.equipment_num+'\');">'+res.equipment_name+'</span></div>';
						}else if (selectedObject=="expedition"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.expedition_num+'\');">'+res.expedition_name+'</span></div>';
						}else if (selectedObject=="analytical_method"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.method_num+'\');">'+res.method_name+'</span></div>';
						}else if (selectedObject=="chemical_analysis"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.chemical_analysis_num+'\');">'+res.chemical_analysis_num+'</span></div>';
						}
						*/

					});
				}
				
				if(thishtml!=""){
					thishtml='<fieldset style="border: 1px solid #CDCDCD; padding: 4px; padding-bottom:0px; margin: 8px 0"><legend><strong>Results:</strong></legend>'+thishtml+'</fieldset>';
				}

				$("#searchlist").html(thishtml);
			});
		}
	
	}else{
	
		$("#searchlist").html("");
	
	}

}


var doNew = function() {

	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject!=""){
	
		$.get("/templates/"+selectedObject+"_dynamic.html", function(data) {
			$("#rightwrapper").html(data);

			if(selectedObject=="equipment"){

				buildSelect('equipment_type_num',vocabs.equipment_types);

			}else if(selectedObject=="expedition"){

				buildSelect('expedition_type_num',vocabs.expedition_types);

			}else if(selectedObject=="analytical_method"){

				buildSelect('method_type_num',vocabs.method_types);

			}else if(selectedObject=="chemical_analysis"){

				buildSelect('chemical_analysis_type_num',vocabs.chemical_analysis_types);

			}else if(selectedObject=="reporting_variable"){

				buildSelect('reporting_variable_uncertainty_type',vocabs.uncertainty_types);

			}

			showBottomButtons();
		});
	
	}
	
	hideEditButton();
	hideDeleteButton();
	showCancelButton();
	showSaveButton();

}

var showStatic = function(id) {

	//window.scrollTo(0, 0);
	$("html, body").animate({ scrollTop: 0 }, "fast");
	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject!=""){
	
		$.get("/templates/"+selectedObject+"_static.html", function(newpage) {
			$("#rightwrapper").html(newpage);


			//load data from server
			if(selectedObject=="equipment"){
			

			
				$.getJSON("/REST/equipment/"+id, function(data){
					$('#equipmentid').val(data.equipment_num);
					$('#equipment_name').html(data.equipment_name);
				
					$('#model_id').html(data.model_id);
					$('#equipment_serial_num').html(data.equipment_serial_num);
					$('#equipment_inventory_num').html(data.equipment_inventory_num);
					$('#equipment_owner_id').html(data.equipment_owner_id);
					$('#equipment_vendor_id').html(data.equipment_vendor_id);
					$('#equipment_phurchase_date').html(data.equipment_phurchase_date);
					$('#equipment_phurchase_order_num').html(data.equipment_phurchase_order_num);
					$('#equipment_photo_file_name').html(data.equipment_photo_file_name);
					$('#equipment_description').html(data.equipment_description);

					//translate equipment_type_num
					var show_equipment_type = "";
					_.each(vocabs.equipment_types, function(eqtype){
						if(eqtype.num==data.equipment_type_num){
							show_equipment_type=eqtype.name;
						}
					});
				
					$('#equipment_type_num').html(show_equipment_type);

				});
			
			}else if(selectedObject=="expedition"){

				$.getJSON("/REST/expedition/"+id, function(data){
					
					//console.log(JSON.stringify(data));
					$('#expeditionid').val(data.expedition_num);
					$("#expedition_name").html(data.expedition_name);

					//translate expedition_type_num
					var show_expedition_type_num = "";
					_.each(vocabs.expedition_types, function(extype){
						if(extype.num==data.expedition_type_num){
							show_expedition_type_num=extype.name;
						}
					});
					
					$('#expedition_type_num').html(show_expedition_type_num);
					
					//get organization name
					if(data.sponsor_organization){
						$.getJSON("/REST/organization/"+data.sponsor_organization, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#expedition_sponsor_organization').html(showlab);
						});
					}
					
					$("#expedition_description").html(data.description);
					$("#expedition_begin_date").html(data.begin_date_time);
					$("#expedition_end_date").html(data.end_date_time);
					
					
					$("#expedition_identifier").html(data.identifier);
					
					if(data.alternate_names.length > 0){
						$("#expedition_alternate_names").html(data.alternate_names.join(", "));
					}

					//get equipment
					if(data.equipment_nums.length>0){
						_.each(data.equipment_nums, function(eqnum){
							$.getJSON("/REST/equipment/"+eqnum, function(eqdata){
								$("#expedition_equipment").append("<div>"+eqdata.equipment_name+"</div>");
							});
						});
					}


				});

			}else if(selectedObject=="analytical_method"){

				$.getJSON("/REST/method/"+id, function(data){
					
					//console.log(JSON.stringify(data));
					$('#analytical_methodid').val(data.method_num);
					$("#method_name").html(data.method_name);
					$("#method_short_name").html(data.method_code);


					//translate method_type_num
					var show_method_type_num = "";
					_.each(vocabs.method_types, function(methtype){
						if(methtype.num==data.method_type_num){
							show_method_type_num=methtype.name;
						}
					});
					
					$('#method_type_num').html(show_method_type_num);
					
					//get organization name
					if(data.organization_num){
						$.getJSON("/REST/organization/"+data.organization_num, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#method_lab').html(showlab);
						});
					}
					
					$("#method_description").html(data.method_description);
					$("#method_link").html(data.method_link);
					





				});
				
			}else if(selectedObject=="chemical_analysis"){

				$.getJSON("/REST/chemicalanalysis/"+id, function(data){
				
					console.log(data);

					$('#chemical_analysisid').val(data.chemical_analysis_num);
					
					$('#chemical_analysis_action_name').html(data.chemical_analysis_name);

					var show_chemical_analysis_type_num = "";
					_.each(vocabs.chemical_analysis_types, function(ctype){
						if(ctype.num==data.chemical_analysis_type_num){
							show_chemical_analysis_type_num=ctype.name;
						}
					});
					$('#chemical_analysis_type_num').html(show_chemical_analysis_type_num);
					
					
					//translate these four

					//get method name
					if(data.method_num!=""){
						$.getJSON("/REST/method/"+data.method_num, function(data){
							$('#chemical_analysis_method').html(data.method_name);
						});
					}

					//get lab name
					if(data.lab_num){
						$.getJSON("/REST/organization/"+data.lab_num, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#chemical_analysis_lab').html(showlab);
						});
					}

					//$('#chemical_analysis_equipment').html(data.equipment_num);
					if(data.equipment_num!=""){
						$.getJSON("/REST/equipment/"+data.equipment_num, function(data){
							$('#chemical_analysis_equipment').html(data.equipment_name);
						});
					}

					//$('#chemical_analysis_analyst').html(data.personaffiliation_num);
					if(data.personaffiliation_num!=""){
						$.getJSON("/REST/personaffiliation/"+data.personaffiliation_num, function(data){
							$('#chemical_analysis_analyst').html(data.person_name+' - '+data.organization_name);
						});
					}
					


					
					$('#chemical_analysis_description').html(data.description);
					$('#chemical_analysis_begin_date').html(data.begin_date_time);
					$('#chemical_analysis_end_date').html(data.end_date_time);




				});


			}else if(selectedObject=="reporting_variable"){

				$.getJSON("/REST/resulttemplate/"+id, function(data){
				
					console.log(data);

					$('#reporting_variableid').val(data.result_template_num);
					$('#reporting_variable_name').html(data.reporting_variable_name);
					

					if(data.analysis_event){
						$.getJSON("/REST/action/"+data.analysis_event, function(data){
							$('#reporting_variable_action_num').html(data.action_name);
						});
					}

					if(data.variable_num){
						$.getJSON("/REST/variable/"+data.variable_num, function(data){
							$('#reporting_variable_variable_num').html(data.variable_name);
						});
					}

					if(data.unit_num){
						$.getJSON("/REST/unit/"+data.unit_num, function(data){
							$('#reporting_variable_unit_num').html(data.unit_name);
						});
					}
					
					//uncertainty_types
					var show_uncertainty = "";
					_.each(vocabs.uncertainty_types, function(ctype){
						if(ctype.num==data.uncertainty_type){
							show_uncertainty=ctype.name;
						}
					});
					$('#reporting_variable_uncertainty_type').html(show_uncertainty);

					$('#reporting_variable_uncertainty_value').html(data.uncertainty_value);
					$('#reporting_variable_description').html(data.description);

				});







			}


			showEditButton();
			showDeleteButton();
			hideCancelButton();
			hideSaveButton();
			showBottomButtons();
		});
		


	}else{

	}

}



var doEdit = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	var id = $('#'+selectedObject+'id').val();
	
	if(selectedObject!=""){
	
		$.get("/templates/"+selectedObject+"_dynamic.html", function(newpage) {
			$("#rightwrapper").html(newpage);

			//load data from server
			if(selectedObject=="equipment"){
			
				$.getJSON("/REST/equipment/"+id, function(data){
					$('#equipmentid').val(data.equipment_num);
					$('#equipment_name').val(data.equipment_name);
					$('#model_id').val(data.model_id);
					$('#equipment_serial_num').val(data.equipment_serial_num);
					$('#equipment_inventory_num').val(data.equipment_inventory_num);
					$('#equipment_owner_id').val(data.equipment_owner_id);
					$('#equipment_vendor_id').val(data.equipment_vendor_id);
					$('#equipment_phurchase_date').val(data.equipment_phurchase_date);
					$('#equipment_phurchase_order_num').val(data.equipment_phurchase_order_num);
					$('#equipment_photo_file_name').val(data.equipment_photo_file_name);
					$('#equipment_description').val(data.equipment_description);
					
					//build select
					buildSelect('equipment_type_num',vocabs.equipment_types);
					
					//turn on appropriate equipment type select value
					//$('#equipment_type_num option[value=data.equipment_type_num]').prop('selected', true)
					//$('#equipment_type_num option[value=data.equipment_type_num]').attr("selected", "selected");
					$("#equipment_type_num").children('[value='+data.equipment_type_num+']').attr('selected', true);
					
				});
			
			}else if(selectedObject=="expedition"){

				$.getJSON("/REST/expedition/"+id, function(data){
					
					//console.log(JSON.stringify(data));
					$('#expeditionid').val(data.expedition_num);
					$("#expedition_name").val(data.expedition_name);

					//build select
					buildSelect('expedition_type_num',vocabs.expedition_types);

					$("#expedition_type_num").children('[value='+data.expedition_type_num+']').attr('selected', true);
					
					
					//get organization name
					if(data.sponsor_organization){
						$.getJSON("/REST/organization/"+data.sponsor_organization, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#expedition_sponsor_organization').val(showlab);
						});
						$('#expedition_hidden_sponsor_organization').val(data.sponsor_organization);
					}
					
					$("#expedition_description").val(data.description);
					$("#expedition_begin_date").val(data.begin_date_time);
					$("#expedition_end_date").val(data.end_date_time);
					
					
					$("#expedition_identifier").val(data.identifier);
					
					if(data.alternate_names.length > 0){
						$("#expedition_alternate_names").val(data.alternate_names.join(", "));
					}

					//get equipment
					
					
					
					if(data.equipment_nums.length>0){
						var thiseqnum=1;
						_.each(data.equipment_nums, function(eqnum){
							console.log("thisequnum: "+thiseqnum);
							$.getJSON("/REST/equipment/"+eqnum, function(eqdata){
								$("#expedition_equipment"+thiseqnum).val(eqdata.equipment_name);
								$("#expedition_hidden_equipment"+thiseqnum).val(eqnum);
								$("#expedition_equipment"+thiseqnum).show();
								thiseqnum++;
							});
						});
					}
					

				});

			}else if(selectedObject=="analytical_method"){

				$.getJSON("/REST/method/"+id, function(data){
					

					//console.log(JSON.stringify(data));
					$('#analytical_methodid').val(data.method_num);
					$("#method_name").val(data.method_name);
					$("#method_short_name").val(data.method_code);

					//build select
					buildSelect('method_type_num',vocabs.method_types);

					$("#method_type_num").children('[value='+data.method_type_num+']').attr('selected', true);

					//get organization name
					if(data.organization_num){
						$.getJSON("/REST/organization/"+data.organization_num, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#method_lab').val(showlab);
						});
					}


					$("#method_description").val(data.method_description);
					$("#method_link").val(data.method_link);
										

				});




			}else if(selectedObject=="chemical_analysis"){

				$.getJSON("/REST/chemicalanalysis/"+id, function(data){

					
					$('#chemical_analysisid').val(data.chemical_analysis_num);
					
					$('#chemical_analysis_action_name').val(data.chemical_analysis_name);

					//build select
					buildSelect('chemical_analysis_type_num',vocabs.chemical_analysis_types);
					
					$("#chemical_analysis_type_num").children('[value='+data.chemical_analysis_type_num+']').attr('selected', true);
					
					//translate these four

					//get method name
					if(data.method_num!=""){
						$.getJSON("/REST/method/"+data.method_num, function(nextdata){
							$('#chemical_analysis_method').val(nextdata.method_name);
						});
						$('#chemical_analysis_method_hidden').val(data.method_num);
					}
					
					

					//get lab name
					if(data.lab_num){
						$.getJSON("/REST/organization/"+data.lab_num, function(orgdata){
							var showlab = orgdata.organization_name;
							if(orgdata.department){
								showlab+=" - "+orgdata.department;
							}
							$('#chemical_analysis_lab').val(showlab);
							$('#chemical_analysis_lab_hidden').val(data.lab_num);
						});
					}

					//$('#chemical_analysis_equipment').html(data.equipment_num);
					if(data.equipment_num!=""){
						$.getJSON("/REST/equipment/"+data.equipment_num, function(nextdata){
							$('#chemical_analysis_equipment').val(nextdata.equipment_name);
							$('#chemical_analysis_equipment_hidden').val(data.equipment_num);
						});
					}

					//$('#chemical_analysis_analyst').html(data.personaffiliation_num);
					if(data.personaffiliation_num!=""){
						$.getJSON("/REST/personaffiliation/"+data.personaffiliation_num, function(nextdata){
							$('#chemical_analysis_analyst').val(nextdata.person_name+' - '+nextdata.organization_name);
							$('#chemical_analysis_analyst_hidden').val(data.method_num);
						});
						
					}
					


					
					$('#chemical_analysis_description').val(data.description);
					$('#chemical_analysis_begin_date').val(data.begin_date_time);
					$('#chemical_analysis_end_date').val(data.end_date_time);
					


					//$('#chemical_analysis_lab_hidden').val("12345");

				});

			}else if(selectedObject=="reporting_variable"){

				$.getJSON("/REST/resulttemplate/"+id, function(data){
				
					console.log(data);

					$('#reporting_variableid').val(data.result_template_num);
					$('#reporting_variable_name').val(data.reporting_variable_name);
					

					if(data.analysis_event){
						$.getJSON("/REST/action/"+data.analysis_event, function(data){
							$('#reporting_variable_action_num').val(data.action_name);
							$('#reporting_variable_action_num_hidden').val(data.action_type_num);
						});
					}

					if(data.variable_num){
						$.getJSON("/REST/variable/"+data.variable_num, function(data){
							$('#reporting_variable_variable_num').val(data.variable_name);
							$('#reporting_variable_variable_num_hidden').val(data.variable_num);
						});
					}

					if(data.unit_num){
						$.getJSON("/REST/unit/"+data.unit_num, function(data){
							$('#reporting_variable_unit_num').val(data.unit_name);
							$('#reporting_variable_unit_num_hidden').val(data.unit_num);
						});
					}
					
					//build select
					buildSelect('reporting_variable_uncertainty_type',vocabs.uncertainty_types);
					
					$("#reporting_variable_uncertainty_type").children('[value='+data.uncertainty_type+']').attr('selected', true);

					$('#reporting_variable_uncertainty_value').val(data.uncertainty_value);
					$('#reporting_variable_description').val(data.description);

				});



			}

			hideEditButton();
			hideDeleteButton();
			showCancelButton();
			showSaveButton();
			showBottomButtons();
		});
		


	}else{

	}

}





var doSave = function() {
	
	var errors = checkForm();
	
	if(errors==""){
	
		var selectedObject = $('#objselect').find(":selected").val();
		var html = "";
	
		if(selectedObject!=""){
	
			if(selectedObject=="equipment"){

				var data = {};

				data.equipment_name = $('#equipment_name').val();
				data.equipment_type_num = $('#equipment_type_num').val();
				data.model_id = $('#model_id').val();
				data.equipment_serial_num = $('#equipment_serial_num').val();
				data.equipment_owner_id = $('#equipment_owner_id').val();
				data.equipment_vendor_id = $('#equipment_vendor_id').val();
				data.equipment_phurchase_date = $('#equipment_phurchase_date').val();
				data.equipment_photo_file_name = $('#equipment_photo_file_name').val();
				data.equipment_description = $('#equipment_description').val();

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#equipmentid').val();
			
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/equipment/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Equipment Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Equipment.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/equipment";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.equipment_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Equipment Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Equipment.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
			
			}else if(selectedObject=="expedition"){

				var data = {};

				data.expedition_name = $('#expedition_name').val();
				data.expedition_type_num = $('#expedition_type_num').val();


				data.expedition_name = $('#expedition_name').val();
				data.expedition_type_num = $('#expedition_type_num').val();
				data.expedition_sponsor_organization = $('#expedition_hidden_sponsor_organization').val();
				data.expedition_description = $('#expedition_description').val();
				data.expedition_begin_date = $('#expedition_begin_date').val();
				data.expedition_end_date = $('#expedition_end_date').val();
				data.expedition_identifier = $('#expedition_identifier').val();
				
				//expedition_alternate_names alternate_names
				var altnames = [];
				data.alternate_names=[];
				if($('#expedition_alternate_names').val()!=""){
					var thesenames = $('#expedition_alternate_names').val().split(",");
					_.each(thesenames, function(thisname){
						thisname = thisname.trim();
						data.alternate_names.push(thisname);
					});
				}

				//equipment_nums
				data.equipment_nums = [];
				var eqnums = ["1","2","3","4","5","6","7","8","9"];
				_.each(eqnums, function(num){
					if($('#expedition_hidden_equipment'+num).val()!=""){
						data.equipment_nums.push($('#expedition_hidden_equipment'+num).val());
					}
				});
				
				console.log(data);

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#expeditionid').val();
			
				
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/expedition/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Expedition Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Expedition.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/expedition";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.expedition_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Expedition Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Expedition.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
				
			}else if(selectedObject=="analytical_method"){

				var data = {};

				data.method_type_num = $('#method_type_num').val();
				data.method_code = $('#method_short_name').val();
				data.method_name = $('#method_name').val();
				data.method_description = $('#method_description').val();
				data.method_link = $('#method_link').val();
				data.organization_num = $('#method_lab_hidden').val();

				
				console.log(data);

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#analytical_methodid').val();

				
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/method/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Method Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Method.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/method";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.method_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Method Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Method.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
				


			}else if(selectedObject=="chemical_analysis"){

				var data = {};

				data.chemical_analysis_name = $('#chemical_analysis_action_name').val();
				data.chemical_analysis_type_num = $('#chemical_analysis_type_num').val();
				data.method_num = $('#chemical_analysis_method_hidden').val();
				data.lab_num = $('#chemical_analysis_lab_hidden').val();
				data.equipment_num = $('#chemical_analysis_equipment_hidden').val();
				data.personaffiliation_num = $('#chemical_analysis_analyst_hidden').val();
				data.description = $('#chemical_analysis_description').val();
				data.begin_date_time = $('#chemical_analysis_begin_date').val();
				data.end_date_time = $('#chemical_analysis_end_date').val();

				//console.log(data);

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#chemical_analysisid').val();

				
				
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/chemicalanalysis/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Chemical Analysis Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Chemical Analysis.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/chemicalanalysis";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.chemical_analysis_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Chemical Analysis Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Chemical Analysis.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
				
			}else if(selectedObject=="reporting_variable"){

				var data = {};

				data.result_template_num = $('#reporting_variableid').val();
				data.reporting_variable_name = $('#reporting_variable_name').val();
				
				data.analysis_event = $('#reporting_variable_action_num_hidden').val();
				data.variable_num = $('#reporting_variable_variable_num_hidden').val();
				data.unit_num = $('#reporting_variable_unit_num_hidden').val();
				
				data.uncertainty_type = $('#reporting_variable_uncertainty_type').val();
				data.uncertainty_value = $('#reporting_variable_uncertainty_value').val();
				data.description = $('#reporting_variable_description').val();

				//console.log(data);

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#reporting_variableid').val();

				
				
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/resulttemplate/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Reporting Variable Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Reporting Variable.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/resulttemplate";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.result_template_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Reporting Variable Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Reporting Variable.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
				

				

















































			}

		}else{

		}
		
	}else{
	
		errors = "Error!\n" + errors;
		alert(errors);

	}

}



var doDeprecate = function() {

	var result = confirm("Are you sure you want to deprecate this item?");
	if (result) {	

		var selectedObject = $('#objselect').find(":selected").val();

		if(selectedObject!=""){
	
			if(selectedObject=="equipment"){

				var id = $('#equipmentid').val();
			
				if(id!=""){
			
					console.log(id);
				
					//deprecate (DELETE)
					var url = "/REST/equipment/"+id;

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						success: function (msg) {
							doSearch();
							$("#successmessage").html('Equipment deprecated Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error deprecating Equipment.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}
			
			}else if(selectedObject=="expedition"){

				var id = $('#expeditionid').val();
			
				if(id!=""){
			
					console.log(id);
				
					//deprecate (DELETE)
					var url = "/REST/expedition/"+id;

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						success: function (msg) {
							doSearch();
							$("#successmessage").html('Expedition deprecated Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error deprecating Expedition.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}
				
			}else if(selectedObject=="analytical_method"){

				var id = $('#analytical_methodid').val();

				if(id!=""){
			
					console.log(id);
				
					//deprecate (DELETE)
					var url = "/REST/method/"+id;

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						success: function (msg) {
							doSearch();
							$("#successmessage").html('Method deprecated Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error deprecating Method.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}
				


			}else if(selectedObject=="chemical_analysis"){

				var id = $('#chemical_analysisid').val();

				if(id!=""){
			
					console.log(id);
				
					//deprecate (DELETE)
					var url = "/REST/chemicalanalysis/"+id;

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						success: function (msg) {
							doSearch();
							$("#successmessage").html('Chemical Analysis deprecated successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error deprecating Chemical Analysis.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}
				
			}else if(selectedObject=="reporting_variable"){

				var id = $('#reporting_variableid').val();

				if(id!=""){
			
					console.log(id);
				
					//deprecate (DELETE)
					var url = "/REST/resulttemplate/"+id;

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						success: function (msg) {
							doSearch();
							$("#successmessage").html('Reporting Variable deprecated successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error deprecating Reporting Variable.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}

			}

		}else{

		}

		$("#rightwrapper").html("");
		hideBottomButtons();

	}

}











var checkForm = function() {

	var errors = "";
	var errordelim = "";
	
	var selectedObject = $('#objselect').find(":selected").val();
	
	if(selectedObject == "equipment"){
	
		//check for integers and existence of required fields.
		if($('#equipment_name').val()==""){
			errors += errordelim+"Equipment name cannot be blank.";
			errordelim = "\n";
		}
		
		if($('#equipment_type_num').val()==""){
			errors += errordelim+"Equipment type cannot be blank.";
			errordelim = "\n";
		}
		
		if($('#model_id').val()!=""){
			if(!isInt($('#model_id').val())){
				errors += errordelim+"Model ID can only be an integer.";
				errordelim = "\n";
			}
		}

		if($('#equipment_serial_num').val()!=""){
			if(!isInt($('#equipment_serial_num').val())){
				errors += errordelim+"Serial number can only be an integer.";
				errordelim = "\n";
			}
		}


	}else if(selectedObject == "expedition"){
	
		if($('#expedition_name').val()==""){
			errors += errordelim+"Expedition name cannot be blank.";
			errordelim = "\n";
		}

		if($('#expedition_type_num').val()==""){
			errors += errordelim+"Expedition type cannot be blank.";
			errordelim = "\n";
		}

		if($('#expedition_hidden_sponsor_organization').val()==""){
			errors += errordelim+"Sponsor organization cannot be blank.";
			errordelim = "\n";
		}


	}else if(selectedObject == "analytical_method"){
	
		if($('#method_name').val()==""){
			errors += errordelim+"Method name cannot be blank.";
			errordelim = "\n";
		}

		if($('#method_type_num').val()==""){
			errors += errordelim+"Method type cannot be blank.";
			errordelim = "\n";
		}

		if($('#method_short_name').val()==""){
			errors += errordelim+"Method short name cannot be blank.";
			errordelim = "\n";
		}


	}else if(selectedObject == "chemical_analysis"){

		if($('#chemical_analysis_action_name').val()==""){
			errors += errordelim+"Analysis run name cannot be blank.";
			errordelim = "\n";
		}

		if($('#chemical_analysis_type_num').val()==""){
			errors += errordelim+"Analysis type cannot be blank.";
			errordelim = "\n";
		}
		
		if($('#chemical_analysis_method_hidden').val()==""){
			errors += errordelim+"Invalid method. Method must be provided.";
			errordelim = "\n";
		}

		if($('#chemical_analysis_lab_hidden').val()==""){
			errors += errordelim+"Invalid lab name. Lab name must be provided.";
			errordelim = "\n";
		}

	}else if(selectedObject == "reporting_variable"){


reporting_variable_name
reporting_variable_action_num_hidden
reporting_variable_variable_num_hidden
reporting_variable_unit_num_hidden



		if($('#reporting_variable_name').val()==""){
			errors += errordelim+"Invalid variable name. Variable name must be provided.";
			errordelim = "\n";
		}

		if($('#reporting_variable_action_num_hidden').val()==""){
			errors += errordelim+"Invalid Analysis Event. Analysis must be provided.";
			errordelim = "\n";
		}

		if($('#reporting_variable_variable_num_hidden').val()==""){
			errors += errordelim+"Invalid variable. Variable must be provided.";
			errordelim = "\n";
		}

		if($('#reporting_variable_unit_num_hidden').val()==""){
			errors += errordelim+"Invalid Unit. Unit must be provided.";
			errordelim = "\n";
		}



	
	}
	
	return errors;
	
}


var testbutton = function() {
	//$("#errormessage").fadeIn();
	//$("#errormessage").fadeOut(2000);
}


var doCancel = function() {

	var result = confirm("Are you sure?");
	if (result) {
		
		var selectedObject = $('#objselect').find(":selected").val();
		
		var thisid="";
		
		if(selectedObject == "equipment"){
		
			thisid = $('#equipmentid').val();
		
		}else if(selectedObject == "expedition"){
		
			thisid = $('#expeditionid').val();
		
		}
		
		if(thisid!=""){
		
			showStatic(thisid);
		
		}else{
		
			$("#rightwrapper").html("");
			hideBottomButtons();

		}

	}

}


var addEquipment = function() {
	var eqnums = ["1","2","3","4","5","6","7","8","9"];
	var go="yes";
	_.each(eqnums, function(eqnum){
		if(go=="yes"){
			if ($('#expedition_equipment'+eqnum).is(':visible')){
				//console.log(eqnum+" is visible.");
			}else{
				$('#expedition_equipment'+eqnum).show();
				go="no";	
			}
		}
	});
}



/*
********************************************************************

			Functions below for new object modals

********************************************************************
*/

var cancelModal = function(){
	var result = confirm("Are you sure?");
	if (result) {
		$.fancybox.close(true);
	}
}

var showNewOrg = function(){

	$('#new_organization_name').val("");
	$('#new_organization_department').val("");
	$("#new_organization_type").val("");
	$('#new_organization_link').val("");
	$('#new_organization_city').val("");
	$('#new_organization_state').val("");
	$('#new_organization_country').val("");
	$('#new_organization_address').val("");
	$('#new_organization_description').val("");

	$.fancybox.open({src :'#add_organization_hidden',type:'inline'});

}

var checkNewOrg = function(){
	var errors="";
	var errordelim="";

	if($('#new_organization_name').val()==""){
		errors+=errordelim+"Organization Name cannot be blank";
		errordelim="\n";
	}
	
	if($('#new_organization_type').val()==""){
		errors+=errordelim+"Organization Type must be provided.";
		errordelim="\n";
	}
	
	return errors;
	
}

var saveNewOrg = function(){
	var errors = checkNewOrg();
	if(errors==""){

		/*
		organization_name
		department
		organization_type_num
		organization_link
		city
		state_num
		country_num
		address_part1
		organization_description

		new_organization_name
		new_organization_department
		new_organization_type
		new_organization_link
		new_organization_city
		new_organization_state
		new_organization_country
		new_organization_address
		new_organization_description
		*/

		var data = {};
		data.organization_name = $('#new_organization_name').val();
		data.department = $('#new_organization_department').val();
		data.organization_type_num = $('#new_organization_type').val();
		data.organization_link = $('#new_organization_link').val();
		data.city = $('#new_organization_city').val();
		data.state_num = $('#new_organization_state').val();
		data.country_num = $('#new_organization_country').val();
		data.address_part1 = $('#new_organization_address').val();
		data.organization_description = $('#new_organization_description').val();

		var saveJSON = JSON.stringify(data);
		
		//console.log(saveJSON);

		var url = "/REST/organization";
		
		$.ajax({
			type: "POST",
			url: url,
			contentType: "application/json",
			data: saveJSON,
			success: function (msg) {
				
				var id = msg.organization_num;
				console.log(msg);
				
				//populate values
				
				var labname = msg.organization_name;
				if(msg.department!=""){
					labname += ' - '+msg.department;
				}
				
				var selectedObject = $('#objselect').find(":selected").val();
				if(selectedObject=="analytical_method"){
					$('#method_lab').val(labname);
					$('#method_lab_hidden').val(msg.organization_num);
				}else if(selectedObject=="chemical_analysis"){
					$('#chemical_analysis_lab').val(labname);
					$('#chemical_analysis_lab_hidden').val(msg.organization_num);
				}else if(selectedObject=="expedition"){
					$('#expedition_sponsor_organization').val(labname);
					$('#expedition_hidden_sponsor_organization').val(msg.organization_num);
				}
				
				$.fancybox.close(true);
				$("#successmessage").html('Organization Saved Successfully.');
				$("#successmessage").fadeIn();
				$("#successmessage").fadeOut(2000);
			},
			error: function (err){
				$("#errormessage").html('There was an error saving Organization.');
				$("#errormessage").fadeIn();
				$("#errormessage").fadeOut(2000);
			}
		});

	}else{
		errors="Error!\n"+errors;
		alert(errors);
	}
}















/*
new_equipment_name
new_equipment_type_num
new_equipment_description
new_equipment_model_id
new_equipment_serial_num
new_equipment_vendor_id
new_equipment_purchase_date
new_equipment_photo_file_name
new_equipment_owner_id
*/


var showNewEquip = function(){

	$('#new_equipment_name').val("");
	$("#new_equipment_type_num").val("");
	$('#new_equipment_description').val("");
	$('#new_equipment_model_id').val("");
	$('#new_equipment_serial_num').val("");
	$('#new_equipment_vendor_id').val("");
	$('#new_equipment_purchase_date').val("");
	$('#new_equipment_photo_file_name').val("");
	$('#new_equipment_owner_id').val("");

	$.fancybox.open({src :'#add_equipment_hidden',type:'inline'});

}

var checkNewEquip = function(){
	var errors="";
	var errordelim="";

	//check for integers and existence of required fields.
	if($('#new_equipment_name').val()==""){
		errors += errordelim+"Equipment name cannot be blank.";
		errordelim = "\n";
	}
	
	if($('#new_equipment_type_num').val()==""){
		errors += errordelim+"Equipment type cannot be blank.";
		errordelim = "\n";
	}
	
	if($('#new_equipment_model_id').val()!=""){
		if(!isInt($('#new_equipment_model_id').val())){
			errors += errordelim+"Model ID can only be an integer.";
			errordelim = "\n";
		}
	}

	if($('#new_equipment_serial_num').val()!=""){
		if(!isInt($('#new_equipment_serial_num').val())){
			errors += errordelim+"Serial number can only be an integer.";
			errordelim = "\n";
		}
	}
	
	return errors;
	
}

var saveNewEquip = function(){
	var errors = checkNewEquip();
	if(errors==""){

		/*
		equipment_num

		new_equipment_name
		new_equipment_type_num
		new_equipment_description
		new_equipment_model_id
		new_equipment_serial_num
		new_equipment_vendor_id
		new_equipment_purchase_date
		new_equipment_photo_file_name
		new_equipment_owner_id

		equipment_name
		equipment_type_num
		equipment_description
		model_id
		equipment_serial_num
		equipment_vendor_id
		equipment_phurchase_date
		equipment_photo_file_name
		equipment_owner_id
		*/

		var data = {};
		data.equipment_name = $('#new_equipment_name').val();
		data.equipment_type_num = $('#new_equipment_type_num').val();
		data.equipment_description = $('#new_equipment_description').val();
		data.model_id = $('#new_equipment_model_id').val();
		data.equipment_serial_num = $('#new_equipment_serial_num').val();
		data.equipment_vendor_id = $('#new_equipment_vendor_id').val();
		data.equipment_phurchase_date = $('#new_equipment_purchase_date').val();
		data.equipment_photo_file_name = $('#new_equipment_photo_file_name').val();
		data.equipment_owner_id = $('#new_equipment_owner_id').val();

		var saveJSON = JSON.stringify(data);
		
		//console.log(saveJSON);

		
		
		var url = "/REST/equipment";
		
		$.ajax({
			type: "POST",
			url: url,
			contentType: "application/json",
			data: saveJSON,
			success: function (msg) {
				
				var id = msg.equipment_num;
				console.log(msg);
				
				//populate values
				var selectedObject = $('#objselect').find(":selected").val();
				if(selectedObject=="chemical_analysis"){
					$('#chemical_analysis_equipment').val(msg.equipment_name);
					$('#chemical_analysis_equipment_hidden').val(msg.equipment_num);
				}else if(selectedObject=="expedition"){
					//figure out first blank equipment
					var eqnums = ["1","2","3","4","5","6","7","8","9"];
					var go_on="yes";
					_.each(eqnums, function(num){
						if(go_on=="yes"){
							if($('#expedition_hidden_equipment'+num).val()==""){
								$('#expedition_hidden_equipment'+num).val(msg.equipment_num);
								$('#expedition_equipment'+num).val(msg.equipment_name);
								$('#expedition_equipment'+num).show();
								go_on="no";
							}
						}
					});





				}
				
				$.fancybox.close(true);
				$("#successmessage").html('Equipment Saved Successfully.');
				$("#successmessage").fadeIn();
				$("#successmessage").fadeOut(2000);
			},
			error: function (err){
				$("#errormessage").html('There was an error saving Equipment.');
				$("#errormessage").fadeIn();
				$("#errormessage").fadeOut(2000);
			}
		});
		
		

	}else{
		errors="Error!\n"+errors;
		alert(errors);
	}
}

































var showNewMeth = function(){

	$('#new_method_name').val("");
	$('#new_method_type_num').val("");
	$('#new_method_short_name').val("");
	$('#new_method_lab').val("");
	$('#new_method_description').val("");
	$('#new_method_link').val("");

	$.fancybox.open({src :'#add_analytical_method_hidden',type:'inline'});

}

var checkNewMeth = function(){
	var errors="";
	var errordelim="";

	//check for integers and existence of required fields.
	if($('#new_method_name').val()==""){
		errors += errordelim+"Method name cannot be blank.";
		errordelim = "\n";
	}

	if($('#new_method_type_num').val()==""){
		errors += errordelim+"Method type cannot be blank.";
		errordelim = "\n";
	}

	if($('#new_method_short_name').val()==""){
		errors += errordelim+"Method short name cannot be blank.";
		errordelim = "\n";
	}
	
	return errors;
	
}

var saveNewMeth = function(){
	var errors = checkNewMeth();
	if(errors==""){

		/*
		method_num

		method_type_num
		method_code
		method_name
		method_description
		method_link
		organization_num

		new_method_type_num
		new_method_short_name
		new_method_name
		new_method_description
		new_method_link
		new_method_lab
		*/

		var data = {};
		data.method_type_num = $('#new_method_type_num').val();
		data.method_code = $('#new_method_short_name').val();
		data.method_name = $('#new_method_name').val();
		data.method_description = $('#new_method_description').val();
		data.method_link = $('#new_method_link').val();
		data.organization_num = $('#new_method_lab_hidden').val();

		var saveJSON = JSON.stringify(data);
		
		console.log(saveJSON);

		var url = "/REST/method";
		
		//chemical_analysis_method
		//chemical_analysis_method_hidden
		
		
		$.ajax({
			type: "POST",
			url: url,
			contentType: "application/json",
			data: saveJSON,
			success: function (msg) {
				
				var id = msg.method_num;
				console.log(msg);
				
				//populate values
				var selectedObject = $('#objselect').find(":selected").val();
				if(selectedObject=="chemical_analysis"){
					$('#chemical_analysis_method').val(msg.method_name);
					$('#chemical_analysis_method_hidden').val(msg.method_num);
				}else if(selectedObject=="ddd"){
					//$('#chemical_analysis_lab').val(labname);
					//$('#chemical_analysis_lab_hidden').val(msg.organization_num);
				}
				
				$.fancybox.close(true);
				$("#successmessage").html('Method Saved Successfully.');
				$("#successmessage").fadeIn();
				$("#successmessage").fadeOut(2000);
			},
			error: function (err){
				$("#errormessage").html('There was an error saving Method.');
				$("#errormessage").fadeIn();
				$("#errormessage").fadeOut(2000);
			}
		});
		
		

	}else{
		errors="Error!\n"+errors;
		alert(errors);
	}
}




























































































var buildSelect = function(elementid,myvar){

	$('#'+elementid)
    .find('option')
    .remove()
    .end()
    .append('<option value="">Select...</option>')
    .val('');

	_.each(myvar, function(part){
		$('#'+elementid).append($('<option>', {
			value: part.num,
			text: part.name
		}));
	});
}

var sssfetchVocab = function(url){ //fetches vocabularies from earthchem vocabulary services
	var returnarray=[];
	$.getJSON(url, function(data){
		var results = data.results;
		_.each(results, function(result){
			returnarray.push({num:result.id,name:result.prefLabel.en});
		});
	});
	
	return returnarray;
}





function fetchVocab(url,name) {
	// Return a new promise.

	return new Promise(function(resolve, reject) {
		
		var returnarray=[];
		$.getJSON(url, function(data){
			var results = data.results;
			_.each(results, function(result){
				returnarray.push({num:result.id,name:result.prefLabel.en});
			});
			//console.log("name: "+name);
			//console.log("returnarray: "+returnarray);
			vocabs[name]=returnarray;
			//vocabs['name']="blah";
			//vocabs=["foobar"];
			resolve();
		});
	});
}







console.log(vocabs);

var vocabs = {};
fetchVocab("/vocabulary/chemicalAnalysisType","chemical_analysis_types").then(function(){
	fetchVocab("/vocabulary/equipmentType","equipment_types").then(function(){
		fetchVocab("/vocabulary/expeditionType","expedition_types").then(function(){
			fetchVocab("/vocabulary/methodType","method_types").then(function(){
				fetchVocab("/vocabulary/organizationType","organization_types").then(function(){
					fetchVocab("/vocabulary/uncertaintyType","uncertainty_types").then(function(){
						fetchVocab("/vocabulary/country","countries").then(function(){
							fetchVocab("/vocabulary/state","states").then(function(){
								//console.log(vocabs.states);
								buildSelect('new_organization_state',vocabs.states);
								buildSelect('new_organization_country',vocabs.countries);
								buildSelect('new_organization_type',vocabs.organization_types);
								buildSelect('new_equipment_type_num',vocabs.equipment_types);
								buildSelect('new_method_type_num',vocabs.method_types);
								pageLoad();
							});
						});
					});
				});
			});
		});
	});
});




//fetchVocab("/vocabulary/chemicalAnalysisType","chemical_analysis_types");
//fetchVocab("/vocabulary/equipmentType","equipment_types");
//fetchVocab("/vocabulary/expeditionType","expedition_types");
//fetchVocab("/vocabulary/methodType","method_types");
//fetchVocab("/vocabulary/organizationType","organization_types");
//fetchVocab("/vocabulary/uncertaintyType","uncertainty_types");
//fetchVocab("/vocabulary/country","countries");
//fetchVocab("/vocabulary/state","states");


/*

chemical_analysis_types
equipment_types
expedition_types
method_types
organization_types
uncertainty_types
countries
states

/vocabulary/chemicalAnalysisType
/vocabulary/equipmentType
/vocabulary/expeditionType
/vocabulary/methodType
/vocabulary/organizationType
/vocabulary/uncertaintyType
/vocabulary/country
/vocabulary/state


//fetch all vocabularies
var chemical_analysis_types = fetchVocab("/vocabulary/chemicalAnalysisType");
var equipment_types = fetchVocab("/vocabulary/equipmentType");
var expedition_types = fetchVocab("/vocabulary/expeditionType");
var method_types = fetchVocab("/vocabulary/methodType");
var organization_types = fetchVocab("/vocabulary/organizationType");
var uncertainty_types = fetchVocab("/vocabulary/uncertaintyType");
var countries = fetchVocab("/vocabulary/country");
var states = fetchVocab("/vocabulary/state");
*/

/*
//buildSelect('new_organization_state',states);
//buildSelect('new_organization_country',countries);
buildSelect('new_organization_type',organization_types);
buildSelect('new_equipment_type_num',equipment_types);
buildSelect('new_method_type_num',method_types);

*/



function isInt(value) {
  var x;
  return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
}



function pageLoad(){ //check for GET variable "page" and pre-load content
    var landingpage = findGetParameter("page");
    if(landingpage){
    	
    	landingpage=landingpage.toLowerCase()
    	
    	if(landingpage=="analyticalmethod"){
    		$("#objselect").children('[value=\'analytical_method\']').attr('selected', true);
    		updateRightSide();
    	}else if(landingpage=="chemicalanalysis"){
    		$("#objselect").children('[value=\'chemical_analysis\']').attr('selected', true);
    		updateRightSide();
    	}else if(landingpage=="equipment"){
    		$("#objselect").children('[value=\'equipment\']').attr('selected', true);
    		updateRightSide();
    	}else if(landingpage=="expedition"){
    		$("#objselect").children('[value=\'expedition\']').attr('selected', true);
    		updateRightSide();
    	}else if(landingpage=="analyticalmethod_new"){
    		$("#objselect").children('[value=\'analytical_method\']').attr('selected', true);
    		updateRightSide();
    		doNew();
    	}else if(landingpage=="chemicalanalysis_new"){
    		$("#objselect").children('[value=\'chemical_analysis\']').attr('selected', true);
    		updateRightSide();
    		doNew();
    	}else if(landingpage=="equipment_new"){
    		$("#objselect").children('[value=\'equipment\']').attr('selected', true);
    		updateRightSide();
    		doNew();
    	}else if(landingpage=="expedition_new"){
    		$("#objselect").children('[value=\'expedition\']').attr('selected', true);
    		updateRightSide();
    		doNew();
		}
    }
    $('#loadingmessage').hide();
}

/*
deprecated due to vocabulary loading
if(window.addEventListener){
	window.addEventListener('load',pageLoad,false); //W3C
}
else{
	window.attachEvent('onload',pageLoad); //IE
}
*/

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}






































/*

var fetchVocab = function(url){ //fetches vocabularies from earthchem vocabulary services
	var returnarray=[];
	$.getJSON(url, function(data){
		
		var results = data.results;
		_.each(results, function(result){
			returnarray.push({num:result.id,name:result.prefLabel.en});
		});
	
	});
	
	return returnarray;
}

//fetch all vocabularies
var chemical_analysis_types = fetchVocab("/vocabulary/chemicalAnalysisType");
var equipment_types = fetchVocab("/vocabulary/equipmentType");
var expedition_types = fetchVocab("/vocabulary/expeditionType");
var method_types = fetchVocab("/vocabulary/methodType");
var organization_types = fetchVocab("/vocabulary/organizationType");
var uncertainty_types = fetchVocab("/vocabulary/uncertaintyType");
var countries = fetchVocab("/vocabulary/country");
var states = fetchVocab("/vocabulary/state");

*/



