<script type="text/javascript">
//var fb_id,url,type have been instantiated in network_template_config.php

var guyCurNum = -1;		//current index of FBid
var girlCurNum = -1;		//current index of girl FBid

//var guys = getGuyList();
//var girls = getGirlList();

var guys_ids = new Array();
var guys_ids_copy = new Array();
var guys = {};

var girls_ids = new Array();
var girls_ids_copy = new Array();
var girls = {};

var girlFirst = true;
var guyFirst = true;
var girlMatched = false;
var guyMatched =false;

getGuyNames();
getGirlNames();
	//both should also cause the first change in images

function updateGuy(){
	if (guyCurNum>=0)
	guys_ids.splice(guyCurNum,1);
	if (guys_ids.length>0){
		changeGuy();	
	}
	else{
		updateGuyList();
		changeGuy();
	}
}

function updateGirl(){
	if (girlCurNum>=0)
	girls_ids.splice(girlCurNum,1);
	if (girls_ids.length>0){
		changeGirl();	
	}
	else{
		updateGirlList();
		changeGirl();
	}
}

function updateGuyList(){
//when guys_ids is out, it reloads a copy
	guys_ids = guys_ids_copy.slice(0);
	
}

function updateGirlList(){
//when girls_ids is out, it reloads a copy
	girls_ids = girls_ids_copy.slice(0);

}

function getGuyNames(){
	//returns a list of all guys fb_id's
		if (window.XMLHttpRequest)
		{
			xmlhttpGuyNames=new XMLHttpRequest();
		}
		else{
			xmlhttpGuyNames=new ActiveXOBject("Microsoft.XMLHTTP");
		}
		xmlhttpGuyNames.onreadystatechange=function()
		{
			if (xmlhttpGuyNames.readyState==4 && xmlhttpGuyNames.status==200)
				{
				guys = eval('('+xmlhttpGuyNames.responseText+')');
				for (var key in guys){
					guys_ids[guys_ids.length] = key;
				}
				guys_ids_copy = guys_ids.slice(0);
				changeGuy();
				document.getElementById('instruction').innerHTML="Click on a person to swap them or go wild and shuffle it up!";
				}
		}
var _0xee7e=["\x47\x45\x54","\x70\x68\x70\x2D\x73\x63\x72\x69\x70\x74\x73\x2F\x6D\x61\x74\x63\x68\x2D\x66\x75\x6E\x63\x74\x69\x6F\x6E\x73\x2E\x70\x68\x70\x3F\x6D\x65\x74\x68\x6F\x64\x3D\x61\x6C\x6C\x47\x75\x79\x73\x26\x74\x79\x70\x65\x3D","\x26\x75\x72\x6C\x3D","\x26\x66\x62\x5F\x69\x64\x3D","\x6F\x70\x65\x6E","\x73\x65\x6E\x64"];xmlhttpGuyNames[_0xee7e[4]](_0xee7e[0],_0xee7e[1]+type+_0xee7e[2]+url+_0xee7e[3]+fb_id,true);xmlhttpGuyNames[_0xee7e[5]]();
}

function getGirlNames(){
	//returns a list of all guys fb_id's
		if (window.XMLHttpRequest)
		{
			xmlhttpGirlNames=new XMLHttpRequest();
		}
		else{
			xmlhttpGirlNames=new ActiveXOBject("Microsoft.XMLHTTP");
		}
		xmlhttpGirlNames.onreadystatechange=function()
		{
			if (xmlhttpGirlNames.readyState==4 && xmlhttpGirlNames.status==200)
				{
				girls = eval('('+xmlhttpGirlNames.responseText+')');
				for (var key in girls){
					girls_ids[girls_ids.length] = key;
				}
				girls_ids_copy = girls_ids.slice(0);
				changeGirl();
				document.getElementById('instruction').innerHTML="Click on a person to swap them or go wild and shuffle it up!";
				}
		}
		var _0xd3e4=["\x47\x45\x54","\x70\x68\x70\x2D\x73\x63\x72\x69\x70\x74\x73\x2F\x6D\x61\x74\x63\x68\x2D\x66\x75\x6E\x63\x74\x69\x6F\x6E\x73\x2E\x70\x68\x70\x3F\x6D\x65\x74\x68\x6F\x64\x3D\x61\x6C\x6C\x47\x69\x72\x6C\x73\x26\x74\x79\x70\x65\x3D","\x26\x75\x72\x6C\x3D","\x26\x66\x62\x5F\x69\x64\x3D","\x6F\x70\x65\x6E","\x73\x65\x6E\x64"];xmlhttpGirlNames[_0xd3e4[4]](_0xd3e4[0],_0xd3e4[1]+type+_0xd3e4[2]+url+_0xd3e4[3]+fb_id,true);xmlhttpGirlNames[_0xd3e4[5]]();
}

function changeGuy(){
	//changes thew name to the new name, changes the image, changes the links
	guyCurNum=Math.floor(Math.random()*guys_ids.length);
	var newId = guys_ids[guyCurNum];
	var newName = guys[newId];
	var image_src = "http://graph.facebook.com/"+newId+"/picture?type=large"
	var fb_link ="http://www.facebook.com/profile.php?id="+newId;
	document.getElementById('right-boy').innerHTML = "<a href='javascript:updateGuy()'><img class='featured' src='"+image_src+"' /></a></div><div id='guy-name'>"+newName+"</div>";
	if (guyFirst){
		if (guyMatched){
			document.getElementById('instruction').innerHTML="You've matched them <3 ... now keep playing!";
			matched = false;
		}
		else{
			document.getElementById('instruction').innerHTML="Click on a person to swap them or go wild and shuffle it up!";			
		}
	guyFirst = false;
	}
	else{
		document.getElementById('instruction').innerHTML="You've swapped him out!";
	}
	addClick();
}

function changeGirl(){
	//changes thew name to the new name, changes the image, changes the links
	girlCurNum=Math.floor(Math.random()*girls_ids.length);
	var newId = girls_ids[girlCurNum];
	var newName = girls[newId];
	var image_src = "http://graph.facebook.com/"+newId+"/picture?type=large"
	var fb_link ="http://www.facebook.com/profile.php?id="+newId;
	document.getElementById('left-girl').innerHTML = "<a href='javascript:updateGirl()'><img class='featured' src='"+image_src+"' /></a></div><div id='girl-name'>"+newName+"</div>";
	if (girlFirst){
		if (girlMatched){
			document.getElementById('instruction').innerHTML="You've matched them <3 ... now keep playing!";
			matched = false;
		}
		else{
			document.getElementById('instruction').innerHTML="Click on a person to swap them or go wild and shuffle it up!";		
		}
	girlFirst = false;
	}
	else{
		document.getElementById('instruction').innerHTML="You've swapped her out!";
	}
	addClick();
}


function makeMatch(){
	//sends match to database and creates new guy/girl faces
	var guyID = getCurrentGuy();
	var girlID = getCurrentGirl();
	var guyName = guys[guyID];
	var girlName = girls[girlID];
	if (guyID && girlID){
		if (window.XMLHttpRequest)
		{
			xmlhttpMatch=new XMLHttpRequest();
		}
		else{
			xmlhttpMatch=new ActiveXOBject("Microsoft.XMLHTTP");
		}
		xmlhttpMatch.onreadystatechange=function()
		{
			if (xmlhttpMatch.readyState==4 && xmlhttpMatch.status==200)
				{
				girlFirst = true;
				guyFirst = true;
				girlMatched = true;
				guyMatched = true;
				changeGuy();
				changeGirl();
				document.getElementById('instruction').innerHTML="You've matched them <3 ... now keep playing!";
				}
		}
		var _0xf7b1=["\x47\x45\x54","\x70\x68\x70\x2D\x73\x63\x72\x69\x70\x74\x73\x2F\x6D\x61\x74\x63\x68\x2D\x66\x75\x6E\x63\x74\x69\x6F\x6E\x73\x2E\x70\x68\x70\x3F\x6D\x65\x74\x68\x6F\x64\x3D\x6D\x61\x74\x63\x68\x26\x67\x75\x79\x49\x44\x3D","\x26\x67\x75\x79\x4E\x61\x6D\x65\x3D","\x26\x67\x69\x72\x6C\x49\x44\x3D","\x26\x67\x69\x72\x6C\x4E\x61\x6D\x65\x3D","\x6F\x70\x65\x6E","\x73\x65\x6E\x64"];xmlhttpMatch[_0xf7b1[5]](_0xf7b1[0],_0xf7b1[1]+guyID+_0xf7b1[2]+guyName+_0xf7b1[3]+girlID+_0xf7b1[4]+girlName,true);xmlhttpMatch[_0xf7b1[6]]();
	}
}

function getCurrentGuy(){
	//returns FBid of current guy
	return guys_ids[guyCurNum];
}

function getCurrentGirl(){
	//returns FBid of current girl
	return girls_ids[girlCurNum];
}

function shuffle(){
	updateGuy();
	updateGirl();
}
function addClick(){
	//returns a list of all guys fb_id's
		if (window.XMLHttpRequest)
		{
			xmlhttpClick=new XMLHttpRequest();
		}
		else{
			xmlhttpClick=new ActiveXOBject("Microsoft.XMLHTTP");
		}
var _0x7906=["\x47\x45\x54","\x70\x68\x70\x2D\x73\x63\x72\x69\x70\x74\x73\x2F\x6D\x61\x74\x63\x68\x2D\x66\x75\x6E\x63\x74\x69\x6F\x6E\x73\x2E\x70\x68\x70\x3F\x6D\x65\x74\x68\x6F\x64\x3D\x63\x6C\x69\x63\x6B","\x6F\x70\x65\x6E","\x73\x65\x6E\x64"];xmlhttpClick[_0x7906[2]](_0x7906[0],_0x7906[1],true);xmlhttpClick[_0x7906[3]]();
}

</script>