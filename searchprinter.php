<!doctype html>
<html>
<head>
<title>AJAX Autocomplete With PHP - phphunger.com</title>
</head>
<body>
<?php
mysql_connect("localhost", "root", "dlris30g") or die(mysql_error());
mysql_select_db("sitdl") or die(mysql_error());
if (isset($_GET['search']) && $_GET['search'] != '') {
 //Add slashes to any quotes to avoid SQL problems.
 $search = $_GET['search'];
 $suggest_query = mysql_query("SELECT * FROM printer WHERE keterangan like('%" .$search . "%')  ");
 while($suggest = mysql_fetch_array($suggest_query)) {
  echo $suggest['keterangan'] . "\n";
 }
}
?>
</body>
</html>