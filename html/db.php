<?php

/*
 *
 */
function db_connect()
{
    global $dbh;
    $dbh = mysql_connect('localhost', 'root', 'root');
}

/*
 *
 */
function db_listIdeas($newestFirst=TRUE, $limit=-1) {
    global $dbh;

    $q = "SELECT * FROM idea WHERE status <> 'archived' ORDER BY created";
    if ($newestFirst == TRUE) 
        $q .= " DESC";

    if ($limit > 0)
        $q .= " LIMIT ".$limit;

    $res = mysql_query($q);

    print "<table>";
    while ($row = mysql_fetch_assoc($res))
    {
        print "<tr>";
        print '<td><a href="viewidea.php?id='.$row["id"].'">'.$row["summary"].'</a></td>';
        print '<td>'.$row["owner"].'</td>';
        print '<td>'.$row["created"].'</td>';
        print '<td>'.$row["last_updated"].'</td>';
        print "</tr>";
    }
    print "</table>";

    mysql_free_result($res);
}

/*
 *
 */
function db_addIdea($summary, $details, $owner)
{
    $q = sprintf(
        'INSERT INTO idea (summary,details,owner,status,created,last_updated) VALUES ("%s", "%s", %d, "open", NOW(), NOW())',
        $summary,
        $details,
        $ownerId
        );
    
    $res = mysql_query($q);
}

/*
 *
 */
function db_updateIdea($id, $summary, $details, $status) {

    $q = sprintf(
        'UPDATE idea SET summary="%s", details="%s", status="%s", last_updated=NOW() WHERE id=%d', 
        $summary,
        $details,
        $status,
        $id
        );
    
    $res = mysql_query($q);
}

function db_attachFileToIdea($id, $text) {
}


function db_voteIdea($id, $userId, $vote)
{
    $res = mysql_query("UPDATE vote SET vote=".$vote." WHERE idea_id=".$id." AND user_id=".$userId);
    if (mysql_num_rows($res) == 0)
        $res = mysql_query("INSERT INTO vote (idea_id, user_id, vote) VALUES (".$id.", ".$userId.", ".$vote.")");
}


function db_deleteIdea($id) 
{
    global $dbh;

    $res = mysql_query("DELETE FROM idea WHERE id=".$id);
}

?>