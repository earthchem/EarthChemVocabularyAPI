

var base_options = {

	listLocation: "results",

	ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		}
	},
	
	list: {
		maxNumberOfElements: 10
	},


	minCharNumber: 2,
	//theme: "plate-dark",
	requestDelay: 300
};


/*********************************************

Expedition Sponsor Organization

*********************************************/
var expedition_sponsor_organization_options = base_options;
expedition_sponsor_organization_options.url="/REST/organization";
expedition_sponsor_organization_options.getValue = function(element) {return element.organization_name;}
expedition_sponsor_organization_options.getValue = function(element) {
	var showname = "";
	showname = element.organization_name;
	if(element.department){
		showname+=' - '+element.department;
	}
	return showname;
}
expedition_sponsor_organization_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#expedition_sponsor_organization").getSelectedItemData();
	$("#expedition_hidden_sponsor_organization").val(selectedItemValue.organization_num);
};
expedition_sponsor_organization_options.preparePostData = function(data) {
	data.query = $("#expedition_sponsor_organization").val();
return data;
};

$("#expedition_sponsor_organization").easyAutocomplete(expedition_sponsor_organization_options);

$( "#expedition_sponsor_organization" ).keyup(function() {
	//clear hidden
	if($('#expedition_sponsor_organization').val()==""){
		$("#expedition_hidden_sponsor_organization").val("");
	}
});


/*********************************************

Expedition Equipment

*********************************************/
var eqnums = ["1","2","3","4","5","6","7","8","9"];
_.each(eqnums, function(eqnum){
	var expedition_equipment_options = base_options;
	expedition_equipment_options.url="/REST/equipment";
	expedition_equipment_options.getValue = function(element) {return element.equipment_name;}
	expedition_equipment_options.list.onChooseEvent = function() {
		var selectedItemValue = $("#expedition_equipment"+eqnum).getSelectedItemData();
		$("#expedition_hidden_equipment"+eqnum).val(selectedItemValue.equipment_num);
	};
		
	expedition_equipment_options.preparePostData = function(data) {
		data.query = $("#expedition_equipment"+eqnum).val();
		return data;
	};

	$("#expedition_equipment"+eqnum).easyAutocomplete(expedition_equipment_options);

	$("#expedition_equipment"+eqnum).keyup(function() {
		//clear hidden
		if($("#expedition_equipment"+eqnum).val()==""){
			$("#expedition_hidden_equipment"+eqnum).val("");
		}
	});
});


/*********************************************

Method Lab (Organization)

*********************************************/
var method_lab_options = base_options;
method_lab_options.url="/REST/organization";
method_lab_options.getValue = function(element) {
	var showname = "";
	showname = element.organization_name;
	if(element.department){
		showname+=' - '+element.department;
	}
	return showname;
}
method_lab_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#method_lab").getSelectedItemData();
	$("#method_lab_hidden").val(selectedItemValue.organization_num);
};
		
method_lab_options.preparePostData = function(data) {
	data.query = $("#method_lab").val();
return data;
};

$("#method_lab").easyAutocomplete(method_lab_options);

$( "#method_lab" ).keyup(function() {
	//clear hidden
	if($('#method_lab').val()==""){
		$("#method_lab_hidden").val("");
	}
});






/*
chemical_analysis_method
chemical_analysis_lab
chemical_analysis_equipment
chemical_analysis_analyst
*/

var thisitem="";

/*********************************************

Chemical Analysis Method

*********************************************/
thisitem="chemical_analysis_method";
var chemical_analysis_method_options = base_options;
chemical_analysis_method_options.url="/REST/method";
chemical_analysis_method_options.getValue = function(element) {return element.method_name;}
chemical_analysis_method_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_method").getSelectedItemData();
	$("#chemical_analysis_method_hidden").val(selectedItemValue.method_num);
};
		
chemical_analysis_method_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_method").val();
	return data;
};

$("#chemical_analysis_method").easyAutocomplete(chemical_analysis_method_options);

$( "#chemical_analysis_method" ).keyup(function() {
	//clear hidden
	if($('#chemical_analysis_method').val()==""){
		$("#chemical_analysis_method_hidden").val("");
	}
});


/*********************************************

Chemical Analysis Lab

*********************************************/
thisitem="chemical_analysis_lab";
var chemical_analysis_lab_options = base_options;
chemical_analysis_lab_options.url="/REST/organization";
chemical_analysis_lab_options.getValue = function(element) {
	var showname = "";
	showname = element.organization_name;
	if(element.department){
		showname+=' - '+element.department;
	}
	return showname;
}

chemical_analysis_lab_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_lab").getSelectedItemData();
	$("#chemical_analysis_lab_hidden").val(selectedItemValue.organization_num);
};
		
chemical_analysis_lab_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_lab").val();
	return data;
};

$("#chemical_analysis_lab").easyAutocomplete(chemical_analysis_lab_options);

$( "#chemical_analysis_lab" ).keyup(function() {
	//clear hidden
	if($('#chemical_analysis_lab').val()==""){
		$("#chemical_analysis_lab_hidden").val("");
	}
});


/*********************************************

Chemical Analysis Equipment

*********************************************/
thisitem="chemical_analysis_equipment";
var chemical_analysis_equipment_options = base_options;
chemical_analysis_equipment_options.url="/REST/equipment";
chemical_analysis_equipment_options.getValue = function(element) {return element.equipment_name;}
chemical_analysis_equipment_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_equipment").getSelectedItemData();
	$("#chemical_analysis_equipment_hidden").val(selectedItemValue.equipment_num);
};
		
chemical_analysis_equipment_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_equipment").val();
	return data;
};

$("#chemical_analysis_equipment").easyAutocomplete(chemical_analysis_equipment_options);

$( "#chemical_analysis_equipment" ).keyup(function() {
	//clear hidden
	if($('#chemical_analysis_equipment').val()==""){
		$("#chemical_analysis_equipment_hidden").val("");
	}
});


/*********************************************

Chemical Analysis Analyst

*********************************************/
thisitem="chemical_analysis_analyst";
var chemical_analysis_analyst_options = base_options;
chemical_analysis_analyst_options.url="/REST/personaffiliation";
chemical_analysis_analyst_options.getValue = function(element) {return element.person_name+' - '+element.organization_name;}
chemical_analysis_analyst_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_analyst").getSelectedItemData();
	$("#chemical_analysis_analyst_hidden").val(selectedItemValue.affiliation_num);
};
		
chemical_analysis_analyst_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_analyst").val();
	return data;
};

$("#chemical_analysis_analyst").easyAutocomplete(chemical_analysis_analyst_options);

$( "#chemical_analysis_analyst" ).keyup(function() {
	//clear hidden
	if($('#chemical_analysis_analyst').val()==""){
		$("#chemical_analysis_analyst_hidden").val("");
	}
});



/*********************************************

Reporting Variable Action

*********************************************/
thisitem="reporting_variable_action_num";
var reporting_variable_action_num_options = base_options;
reporting_variable_action_num_options.url="/REST/action";
reporting_variable_action_num_options.getValue = function(element) {return element.action_name;}
reporting_variable_action_num_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#reporting_variable_action_num").getSelectedItemData();
	$("#reporting_variable_action_num_hidden").val(selectedItemValue.action_num);
};
		
reporting_variable_action_num_options.preparePostData = function(data) {
	data.query = $("#reporting_variable_action_num").val();
	return data;
};

$("#reporting_variable_action_num").easyAutocomplete(reporting_variable_action_num_options);

$( "#reporting_variable_action_num" ).keyup(function() {
	//clear hidden
	if($('#reporting_variable_action_num').val()==""){
		$("#reporting_variable_action_num_hidden").val("");
	}
});


/*********************************************

Reporting Variable Variable

*********************************************/
thisitem="reporting_variable_variable_num";
var reporting_variable_variable_num_options = base_options;
reporting_variable_variable_num_options.url="/REST/variable";
reporting_variable_variable_num_options.getValue = function(element) {return element.variable_name;}
reporting_variable_variable_num_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#reporting_variable_variable_num").getSelectedItemData();
	$("#reporting_variable_variable_num_hidden").val(selectedItemValue.variable_num);
};
		
reporting_variable_variable_num_options.preparePostData = function(data) {
	data.query = $("#reporting_variable_variable_num").val();
	return data;
};

$("#reporting_variable_variable_num").easyAutocomplete(reporting_variable_variable_num_options);

$( "#reporting_variable_variable_num" ).keyup(function() {
	//clear hidden
	if($('#reporting_variable_variable_num').val()==""){
		$("#reporting_variable_variable_num_hidden").val("");
	}
});


/*********************************************

Reporting Variable Unit

*********************************************/
thisitem="reporting_variable_unit_num";

var reporting_variable_unit_num_options = {

	listLocation: "results",

	ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		}
	},
	
	list: {},


	minCharNumber: 1,
	//theme: "plate-dark",
	requestDelay: 300
};

reporting_variable_unit_num_options.url="/REST/unit";
reporting_variable_unit_num_options.getValue = function(element) {return element.unit_name;}
reporting_variable_unit_num_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#reporting_variable_unit_num").getSelectedItemData();
	$("#reporting_variable_unit_num_hidden").val(selectedItemValue.unit_num);
};
		
reporting_variable_unit_num_options.preparePostData = function(data) {
	data.query = $("#reporting_variable_unit_num").val();
	return data;
};

$("#reporting_variable_unit_num").easyAutocomplete(reporting_variable_unit_num_options);

$( "#reporting_variable_unit_num" ).keyup(function() {
	//clear hidden
	if($('#reporting_variable_unit_num').val()==""){
		$("#reporting_variable_unit_num_hidden").val("");
	}
});


/*********************************************

Reporting Variable Variable

*********************************************/
thisitem="new_method_lab";
var new_method_lab_options = base_options;
new_method_lab_options.url="/REST/organization";
new_method_lab_options.getValue = function(element) {return element.organization_name;}
new_method_lab_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#new_method_lab").getSelectedItemData();
	$("#new_method_lab_hidden").val(selectedItemValue.organization_num);
};
		
new_method_lab_options.preparePostData = function(data) {
	data.query = $("#new_method_lab").val();
	return data;
};

$("#new_method_lab").easyAutocomplete(new_method_lab_options);

$( "#new_method_lab" ).keyup(function() {
	//clear hidden
	if($('#new_method_lab').val()==""){
		$("#new_method_lab_hidden").val("");
	}
});




























/*
thisitem="chemical_analysis_equipment";
var chemical_analysis_equipment_options = base_options;
chemical_analysis_equipment_options.url="/REST/equipment";
chemical_analysis_equipment_options.getValue = function(element) {return element.equipment_name;}
chemical_analysis_equipment_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#"+thisitem).getSelectedItemData();
	$("#"+thisitem+"_hidden").val(selectedItemValue.equipment_num);
};
		
newoptions.preparePostData = function(data) {
	data.query = $("#"+thisitem).val();
	return data;
};

$("#"+thisitem).easyAutocomplete(chemical_analysis_equipment_options);

$( "#"+thisitem ).keyup(function() {
	//clear hidden
	$("#"+thisitem+"_hidden").val("");
});
*/



































/*







var eqnums = ["1","2","3","4","5","6","7","8","9"];
_.each(eqnums, function(eqnum){
	var expedition_equipment_options = base_options;
	expedition_equipment_options.list.onChooseEvent = function() {
		var selectedItemValue = $("#expedition_equipment"+eqnum).getSelectedItemData();
		$("#expedition_hidden_equipment"+eqnum).val(selectedItemValue.organization_num);
	};
		
	expedition_equipment_options.preparePostData = function(data) {
		data.query = $("#expedition_equipment"+eqnum).val();
		return data;
	};

	$("#expedition_equipment"+eqnum).easyAutocomplete(expedition_equipment_options);

	$("#expedition_equipment"+eqnum).keyup(function() {
		//clear hidden
		$("#expedition_hidden_equipment"+eqnum).val("");
	});
});









var expedition_equipment_options = base_options;
expedition_equipment_options.list.onChooseEvent = function() {
var selectedItemValue = $("#expedition_equipment1").getSelectedItemData();
$("#expedition_hidden_equipment1").val(selectedItemValue.organization_num);
};
		
expedition_equipment_options.preparePostData = function(data) {
data.query = $("#expedition_equipment1").val();
return data;
};

$("#expedition_equipment1").easyAutocomplete(expedition_equipment_options);

$( "#expedition_equipment1" ).keyup(function() {
	//clear hidden
	$("#expedition_hidden_equipment1").val("");
});








var expedition_sponsor_organization_options = {

	url: function(phrase) {
		return "/REST/organization";
	},

	listLocation: "results",

	getValue: function(element) {
		return element.organization_name;
	},

	ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		}
	},

	list: {
		maxNumberOfElements: 10,
		onChooseEvent: function() {
			var selectedItemValue = $("#expedition_sponsor_organization").getSelectedItemData();
			$("#expedition_hidden_sponsor_organization").val(selectedItemValue.organization_num);
		},
		onHideListEvent: function() {
		}
	},

	preparePostData: function(data) {
		data.query = $("#expedition_sponsor_organization").val();
		return data;
	},

	minCharNumber: 2,
	//theme: "plate-dark",
	requestDelay: 300
};

$("#expedition_sponsor_organization").easyAutocomplete(expedition_sponsor_organization_options);

$( "#expedition_sponsor_organization" ).keyup(function() {
	//clear hidden
	$("#expedition_hidden_sponsor_organization").val("");
});

*/

























