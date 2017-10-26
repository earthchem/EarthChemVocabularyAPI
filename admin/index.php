<?
include("logincheck.php");

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['username'];

function dumpVar($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EarthChem Vocabulary Admin Interface</title>

	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" href="resources/style.css">
	<link rel="stylesheet" href="resources/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" href="resources/jquery-ui/jquery-ui.theme.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="resources/jquery-ui/jquery-ui.js"></script>
	<script src="resources/underscore/underscore.js"></script>
	<script src="includes/config.inc.js"></script>
	<script src="resources/ecvocabadmin.js"></script>

</head>
<body>
	
	<div id="wrapper">
		<div class="clearfloat" id="header">
		EarthChem Vocabulary Admin
		</div>
		<div class="loginbar">
			Logged in as <?=$firstname?> <?=$lastname?> - <?=$email?> <a href="/logout">(Logout)</a>
		</div>
	
		<div style="clear:both;"></div>

		<table width="100%">
		
			<tr>
			
				<td valign="top" width="150px;">

					<div id="leftBarContent">
						
						<!--<button onclick="showAll();">Test</button>-->
						
						<div class="selectlabel">Vocabulary:</div>

						<select id="objselect" class="ecselect" onchange="updateRightSide();">
							<option value="">Select...</option>
							<option value="chemicalanalysistype">Chemical Analysis Type</option>
							<option value="country">Country</option>
							<option value="equipmenttype">Equipment Type</option>
							<option value="expeditiontype">Expedition Type</option>
							<option value="graintype">Grain Type</option>
							<option value="material">Material</option>
							<option value="methodtype">Method Type</option>
							<option value="mineral">Mineral</option>
							<option value="organizationtype">Organization Type</option>
							<option value="rockclass">Rock Class</option>
							<option value="rocktype">Rock Type</option>
							<option value="state">State</option>
							<option value="uncertaintytype">Uncertainty Type</option>

						</select>
						
						<div id="newbutton" style="padding-top:20px;display:none;"><button class="menubutton" onClick="doNew();"><span>NEW</span></button></div>
						
						<div id="searchboxwrapper" style="display:block;display:none;">
							<div class="selectlabel" style="padding-top:10px;">Search:</div>
							<div><input type="text" id="searchbox" class="ectextbox" id="searchstring" size="10"/></div>
						</div>

						<div id="searchlist" style="padding-top:20px;">

						</div>

						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</div>

				</td>
				
				<td valign="top">
				
					<div id="successmessage">
						Saved Successfully!
					</div>
					
					<div id="errormessage">
						There was an error saving!
					</div>
					
					<div id="rightwrapper">
					





































































		













































































					
					</div>

						<div id="bottombuttons" style="text-align:center;padding-left:50px;display:none;">
							<div id="editbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doEdit();"><span>EDIT</span></button></div>
							<div id="deletebutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doDeprecate();"><span>DEPRECATE</span></button></div>
							<div id="cancelbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doCancel();"><span>CANCEL</span></button></div>
							<div id="savebutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doSave();"><span>SAVE</span></button></div>
						</div>

				</td>
			
			</tr>
		
		</table>

		</div>
		
	</div>

	<!--
	<script src="resources/autocomplete_setups.js"></script>
	-->
	


</body>
</html>