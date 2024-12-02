// JavaScript Document
function hide(param){
	if(param==0){
	document.getElementById("form_tambah").style.display="none";
	document.getElementById("form_update").style.display="none";}
	else if(param==1){
	document.getElementById("form_tambah").style.display="block";
	document.getElementById("form_update").style.display="none";}
	else if(param==2){
	document.getElementById("form_tambah").style.display="none";
	document.getElementById("form_update").style.display="block";}
}