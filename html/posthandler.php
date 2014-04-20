<?php
require_once("db.php");

$db = new Hdb();

if ($_POST['cmd'] == "addnew")
{
    // TODO http escape etc, sanitize input
    $db->addIdea($_POST['summary'], $_POST['details'], 1);

    header("Location: /index.php");

}

if ($_POST['cmd'] == "comment")
{
    $db->commentOnIdea($_POST['id'], $_POST['comment']);
    header("Location: /view.php?id=".$_POST['id']);
}

?>
