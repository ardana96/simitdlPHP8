function getXmlHttpRequestObject() {
 if (window.XMLHttpRequest) {
  return new XMLHttpRequest();
 } else if(window.ActiveXObject) {
  return new ActiveXObject("Microsoft.XMLHTTP");
 } else {
  alert("Your Browser Sucks!");
 }
}
//Our XmlHttpRequest object to get the auto suggest
var searchReq = getXmlHttpRequestObject();
//Called from keyup on the search textbox.
//Starts the AJAX request.
function searchSuggest2() {
 if (searchReq.readyState == 4 || searchReq.readyState == 0) {
  var str = escape(document.getElementById('dbTxt2').value);
  searchReq.open("GET", '../searchkartu.php?search=' + str, true);
  searchReq.onreadystatechange = handleSearchSuggest;
  searchReq.send(null);
 }
}
//Called when the AJAX response is returned.
function handleSearchSuggest2() {
 if (searchReq.readyState == 4) {
         var ss = document.getElementById('layer2');
  var str1 = document.getElementById('dbTxt2');
  var curLeft=0;
  if (str1.offsetParent){
      while (str1.offsetParent){
   curLeft += str1.offsetLeft;
   str1 = str1.offsetParent;
      }
  }
  var str2 = document.getElementById('dbTxt2');
  var curTop=20;
  if (str2.offsetParent){
      while (str2.offsetParent){
   curTop += str2.offsetTop;
   str2 = str2.offsetParent;
      }
  }
  var str =searchReq.responseText.split("\n");
  if(str.length==1)
      document.getElementById('layer2').style.visibility = "hidden";
  else
      ss.setAttribute('style','position:absolute;top:'+curTop+';left:'+curLeft+';width:250;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105; background-color:white;');
  ss.innerHTML = '';
  for(i=0; i < str.length - 1; i++) {
   //Build our element string.  This is <span class="IL_AD" id="IL_AD5">cleaner</span> using the DOM, but
   //IE doesn't support dynamically added attributes.
   var suggest = '<div onmouseover="javascript:suggestOver(this);" ';
            suggest += 'onmouseout="javascript:suggestOut(this);" ';
            suggest += 'onclick="javascript:setSearch2(this.innerHTML);" ';
            suggest += 'class="small">' + str[i] + '</div>';
            ss.innerHTML += suggest;
  }
 }
}
//Mouse over function
function suggestOver(div_value) {
 div_value.className = 'suggest_link_over';
}
//Mouse out function
function suggestOut(div_value) {
 div_value.className = 'suggest_link';
}
//Click function
function setSearch(value) {
 document.getElementById('dbTxt2').value = value;
 document.getElementById('layer2').value = value;
 document.getElementById('layer2').innerHTML = '';
 document.getElementById('layer2').style.visibility = "hidden";
}