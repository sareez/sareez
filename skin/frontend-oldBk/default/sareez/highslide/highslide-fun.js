function textCounter(field,cntfield,maxlimit) { //alert("Hello");
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
	cntfield.value = maxlimit - field.value.length;
}	

function getSelectedSleeveStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_sleeve_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_sleeve_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}
function getSelectedFrontNeckStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_front_neck_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_front_neck_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}
function getSelectedBackNeckStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_back_neck_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_back_neck_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}
function getSelectedLehngaStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_lehnga_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_lehnga_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}
function getSelectedKameezStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_kameez_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_kameez_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}
function getSelectedSalwarStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_salwar_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_salwar_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}

function getSelectedChuridarStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_churidar_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_churidar_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}



function getSelectedTrouserStyle() {
	var ret = -1;
	var pR = document.getElementsByName('rdo_trouser_style');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_trouser_style')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}

function getSelectedMeasurementId(){
	var ret = -1;
	var pR = document.getElementsByName('rdo_measurement_id');
	for(var i=0; i<pR.length; i++) {
	if(document.getElementsByName('rdo_measurement_id')[i].checked == true) {
	ret = i;
	break;
	}
	}
	return ret;
}

function set_sleeve_style() {
    var i = getSelectedSleeveStyle();
	document.getElementById('sleeve_style').value=document.getElementsByName('rdo_sleeve_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
function set_front_neck_style() {
    var i = getSelectedFrontNeckStyle();
	document.getElementById('front_neck_style').value=document.getElementsByName('rdo_front_neck_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
function set_back_neck_style() {
    var i = getSelectedBackNeckStyle();
	document.getElementById('back_neck_style').value=document.getElementsByName('rdo_back_neck_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
function set_lehnga_style() {
    var i = getSelectedLehngaStyle();
	document.getElementById('lehnga_style').value=document.getElementsByName('rdo_lehnga_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
function set_kameez_style() {
    var i = getSelectedKameezStyle();
	document.getElementById('kameez_style').value=document.getElementsByName('rdo_kameez_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
function set_salwar_style() {
    var i = getSelectedSalwarStyle();
	document.getElementById('salwar_style').value=document.getElementsByName('rdo_salwar_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}

function set_churidar_style() {
    var i = getSelectedChuridarStyle();
	document.getElementById('churidar_style').value=document.getElementsByName('rdo_churidar_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}

function set_trouser_style() {
    var i = getSelectedTrouserStyle();
	document.getElementById('trouser_style').value=document.getElementsByName('rdo_trouser_style')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}

function set_measurement_id(str) {
    var i = getSelectedMeasurementId();
	document.location.href=str+document.getElementsByName('rdo_measurement_id')[i].value;
    //alert("You chose " + document.getElementsByName('songs')[i].value + ".");
}
