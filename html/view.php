<?php
require_once("db.php");

$db = new Hdb();
$idea = NULL;
$ideaId = -1;

if (isset($_GET['id']))
{
    $ideaId = $_GET['id'];
    $idea = $db->getIdea($ideaId);
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
    <h1><?php echo $idea["summary"]; ?></h1>
    <p><?php echo $idea["owner"]; ?> // <?php echo $idea["created"]; ?></p>
    <p><?php echo $idea["details"]; ?></p>

    <!-- add comment -->
    <div style="width:50%;">
    <form action="posthandler.php" method="POST">
    <input type="hidden" name="cmd" value="comment"/>
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
    <textarea name="comment"></textarea><br/>
    <input type="submit" value="Comment"/>
    </form>
    </div>

    <!-- other comments -->
    <div style="width:50%">
    <?php 
    $comments = $db->getComments($ideaId);
foreach ($comments as $com)
{?>

    <p><b><?php echo $com["user_id"]; ?> (<?php echo $com["timestamp"]; ?>)</b></p>
    <p><?php echo $com["comment"]; ?></p>
    <hr/>

<?php
}
?>
    </div>

</body>
</html>
