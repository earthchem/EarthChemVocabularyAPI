//EarthChem Vocabulary Admin Interface

$( function() {
	$( "#searchbox" ).keyup(function() {
	  doSearch();
	});

} );

var updateRightSide = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();
	
	$('#searchbox').val('');
	
	showAll();
	
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

var showAll = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();

	if(selectedObject!=""){

		url = vocabRestEndpoint+selectedObject;

	}
	
	if(url!=""){
		var thishtml = "";
		$.getJSON(url, function(data){
			if(data.resultcount>0){
				_.each(data.results, function(res){
					
					thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.uri+'\');">'+res.prefLabel.en+'</div>';

				});
			}
			
			if(thishtml!=""){
				thishtml='<fieldset style="border: 1px solid #CDCDCD; padding: 4px; padding-bottom:0px; margin: 8px 0"><legend><strong>Complete List:</strong></legend>'+thishtml+'</fieldset>';
			}

			$("#searchlist").html(thishtml);
		});
	}

}

var doSearch = function() {

	var val = $('#searchbox').val();
	var url = "";
	
	if(val.length > 0){
	
		var selectedObject = $('#objselect').find(":selected").val();
	
		if(selectedObject!=""){
	
			url = vocabRestEndpoint+selectedObject+"?label="+val;

		}
		
		if(url!=""){
			var thishtml = "";
			$.getJSON(url, function(data){
				if(data.resultcount>0){
					_.each(data.results, function(res){
						
						thishtml=thishtml+'<div class="searchItem" onclick="showStatic(\''+res.uri+'\');">'+res.prefLabel.en+'</div>';

					});
				}
				
				if(thishtml!=""){
					thishtml='<fieldset style="border: 1px solid #CDCDCD; padding: 4px; padding-bottom:0px; margin: 8px 0"><legend><strong>Results:</strong></legend>'+thishtml+'</fieldset>';
				}

				$("#searchlist").html(thishtml);
			});
		}
	
	}else{
	
		showAll();
	
	}

}

var doNew = function() {

	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject!=""){
	
		$.get("templates/vocab_dynamic.html", function(data) {
			$("#rightwrapper").html(data);
			$("#templatetitle").html(getVocabLabel(selectedObject));

			//hide alt label if necessary
			if(killAltLabels.indexOf(selectedObject)!=-1){
				$("#alternate_vocab_label_row").hide();
			}

			if(killDescriptions.indexOf(selectedObject)!=-1){
				$("#description_row").hide();
			}

			showBottomButtons();
		});
	
	}
	
	hideEditButton();
	hideDeleteButton();
	showCancelButton();
	showSaveButton();

}

var showStatic = function(uri) {

	//window.scrollTo(0, 0);
	$("html, body").animate({ scrollTop: 0 }, "fast");
	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject!=""){
	
		$.get("templates/vocab_static.html", function(newpage) {
			$("#rightwrapper").html(newpage);
			$("#templatetitle").html(getVocabLabel(selectedObject));

			//hide alt label if necessary
			if(killAltLabels.indexOf(selectedObject)!=-1){
				$("#alternate_vocab_label_row").hide();
			}

			if(killDescriptions.indexOf(selectedObject)!=-1){
				$("#description_row").hide();
			}

			$.getJSON(uri, function(data){
				
				console.log(data);
				console.log(data.altLabel.en);
				
				$('#vocaburi').val(data.uri);
				$('#preferred_vocab_label').html(data.prefLabel.en);
				$('#alternate_vocab_label').html(data.altLabel.en);
				$('#alternate_vocab_description').html(data.definition.en);

			});

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
	
	var uri = $('#vocaburi').val();

	if(selectedObject!=""){
	
		$.get("templates/vocab_dynamic.html", function(newpage) {
			$("#rightwrapper").html(newpage);
			$("#templatetitle").html(getVocabLabel(selectedObject));

			//hide alt label if necessary
			if(killAltLabels.indexOf(selectedObject)!=-1){
				$("#alternate_vocab_label_row").hide();
			}

			if(killDescriptions.indexOf(selectedObject)!=-1){
				$("#description_row").hide();
			}

			$.getJSON(uri, function(data){
				
				console.log(data);
				console.log(data.altLabel.en);
				
				$('#vocaburi').val(data.uri);
				$('#preferred_vocab_label').val(data.prefLabel.en);
				$('#alternate_vocab_label').val(data.altLabel.en);
				$('#alternate_vocab_description').val(data.definition.en);

			});

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

			vocablabel = getVocabLabel(selectedObject);
			
			var data = {};
			data.prefLabel={};
			data.prefLabel.en=$('#preferred_vocab_label').val();
			
			//hide alt label if necessary
			if(killAltLabels.indexOf(selectedObject)==-1){
				data.altLabel={};
				data.altLabel.en=$('#alternate_vocab_label').val();
			}

			if(killDescriptions.indexOf(selectedObject)==-1){
				data.definition={};
				data.definition.en=$('#alternate_vocab_description').val();
				
			}

			var saveJSON = JSON.stringify(data);
			
			console.log(saveJSON);

			var uri = $('#vocaburi').val();
		
			if(uri!=""){

				//update (PUT)
				var url = uri;
				
				console.log("url: "+url);

				
				$.ajax({
					type: "PUT",
					url: url,
					contentType: "application/json",
					data: saveJSON,
					success: function (msg) {
						showStatic(uri);
						refreshList();
						$("#successmessage").html(vocablabel+' Saved Successfully.');
						$("#successmessage").fadeIn();
						$("#successmessage").fadeOut(2000);
					},
					error: function (err){
						$("#errormessage").html('There was an error saving '+vocablabel+'.');
						$("#errormessage").fadeIn();
						$("#errormessage").fadeOut(2000);
					}
				});
				
				
			}else{
				
				//save new (POST)

				var url = vocabRestEndpoint+selectedObject;
				
				console.log("url: "+url);
				
				
				$.ajax({
					type: "POST",
					url: url,
					contentType: "application/json",
					data: saveJSON,
					success: function (msg) {
						
						console.log(msg);
						
						var uri = msg.uri;
						console.log("uri: "+uri);
						showStatic(uri);
						$("#successmessage").html(vocablabel+' Saved Successfully.');
						$("#successmessage").fadeIn();
						$("#successmessage").fadeOut(2000);
					},
					error: function (err){
						$("#errormessage").html('There was an error saving '+vocablabel+'.');
						$("#errormessage").fadeIn();
						$("#errormessage").fadeOut(2000);
					}
				});
				
			
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
	
			vocablabel = getVocabLabel(selectedObject);
			
			var uri = $('#vocaburi').val();
		
			if(uri!=""){
		
				console.log(uri);

				$.ajax({
					type: "DELETE",
					url: uri,
					contentType: "application/json",
					success: function (msg) {
						
						refreshList();
						
						$("#successmessage").html(vocablabel+' deprecated Successfully.');
						$("#successmessage").fadeIn();
						$("#successmessage").fadeOut(2000);
					},
					error: function (err){
						$("#errormessage").html('There was an error deprecating '+vocablabel+'.');
						$("#errormessage").fadeIn();
						$("#errormessage").fadeOut(2000);
					}
				});
				
			}
			
		}else{

		}

		$("#rightwrapper").html("");
		hideBottomButtons();

	}

}

var refreshList = function(){
	var val = $('#searchbox').val();
	if(val!=""){
		doSearch();
	}else{
		showAll();
	}
}

var checkForm = function() {

	var errors = "";
	var errordelim = "";
	
	var selectedObject = $('#objselect').find(":selected").val();

	if($('#preferred_vocab_label').val()==""){
		errors += errordelim+"Invalid Preferred Label. Preferred Label must be provided.";
		errordelim = "\n";
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

var vocabNames = [];
vocabNames.push({name:"chemicalanalysistype",label:"Chemical Analysis Type"});
vocabNames.push({name:"country",label:"Country"});
vocabNames.push({name:"equipmenttype",label:"Equipment Type"});
vocabNames.push({name:"expeditiontype",label:"Expedition Type"});
vocabNames.push({name:"graintype",label:"Grain Type"});
vocabNames.push({name:"material",label:"Material"});
vocabNames.push({name:"methodtype",label:"Method Type"});
vocabNames.push({name:"mineral",label:"Mineral"});
vocabNames.push({name:"organizationtype",label:"Organization Type"});
vocabNames.push({name:"rockclass",label:"Rock Class"});
vocabNames.push({name:"rocktype",label:"Rock Type"});
vocabNames.push({name:"state",label:"State"});
vocabNames.push({name:"uncertaintytype",label:"Uncertainty Type"});

var getVocabLabel = function(vocabName){
	var returnLabel = "Not Found";
	_.each(vocabNames, function(vname){
		if(vname.name==vocabName){
			returnLabel = vname.label;
		}
	});
	
	return returnLabel;
}

//create list of vocabs to leave off alt label
killAltLabels = ["chemicalanalysistype","equipmenttype","expeditiontype","methodtype","organizationtype","state","uncertaintytype"];

//create list of vocabs to leave off description
killDescriptions = ["country","state"];



