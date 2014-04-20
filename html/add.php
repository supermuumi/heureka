<?php
require_once("db.php");


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <link href='http://fonts.googleapis.com/css?family=Signika:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/heureka.css"/>
  <title>Heureka - add new</title>
</head>
<body>
<h1>So what's awesome?</h1>
<p>Intro text here</p>
<div style="width:100%">
  <div style="float:left;width:48%;">
    <h1>Go crazy!</h1>
    <form action="posthandler.php" method="POST">
      <input type="hidden" name="cmd" value="addnew"/>
      <div style="display: table; width:100%;">
        <div class="row">
          <div class="cell">Summary:</div>
          <div class="cell"><input type="text" name="summary"/></div>
        </div>
        <div class="row">
          <div class="cell">Details:</div>
          <div class="cell"><textarea name="details"></textarea></div>
        </div>
        <div class="row">
          <input type="submit" value="Add idea"/>
        </div>
      </div>
    </form>
  </div>
  <div style="float:left;width:4%;"></div>
  <div style="float:right;width:48%;">
    <h1>Latest activity</h1>
  </div>
</div>

</body>
</html>
