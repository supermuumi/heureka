<?php
require_once("db.php");

$db = new Hdb();

if ($_POST['addnew'] == 1)
{
    // TODO http escape etc, sanitize input
    $db->addIdea($_POST['summary'], $_POST['details'], 1);
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <link href='http://fonts.googleapis.com/css?family=Signika:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/heureka.css"/>
  <title>Heureka</title>
</head>
<body>
<h1>Welcome to Heureka</h1>
<p>Intro text here</p>
<p><a href="add.php">Add your own idea!</a></p>
<div style="width:100%">
    <div style="float:left;width:48%;">
    <h1>Newest ideas</h1>
    <?php $db->listIdeas("created", TRUE, 10); ?>
    </div>
    <div style="float:left;width:4%;"></div>
    <div style="float:right;width:48%;">
    <h1>Latest activity</h1>
    <?php $db->listIdeas("updated", TRUE, 10); ?>
    </div>
</div>

</body>
</html>
