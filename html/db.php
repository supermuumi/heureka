<?php

class Hdb {

    protected $dbh;

    function __construct()
    {
        $this->dbh = mysqli_connect('localhost', 'root', 'root', 'heureka') or die("mysqli_connect fail");
    }

    function listIdeas($order="created", $newestFirst=TRUE, $limit=-1) {
        $q = "SELECT * FROM idea WHERE status <> 'archived' ORDER BY ";

        // order by
        if ($order == "updated")
            $q .= "last_updated";
        else
            $q .= "created";

        if ($newestFirst == TRUE) 
            $q .= " DESC";

        // limit
        if ($limit > 0)
            $q .= " LIMIT ".$limit;

        $res = mysqli_query($this->dbh, $q);

        print '<div style="display:table; width:100%;">';
        if (mysqli_num_rows($res) > 0)
        {
            print '<div class="row">';
            print '<div class="cellheader">Idea</div>';
            print '<div class="cellheader">Owner</div>';
            print '<div class="cellheader">Created</div>';
            print "</div>";
        }
        while ($row = mysqli_fetch_assoc($res))
        {
            print '<div class="row">';
            print '<div class="cell"><a href="view.php?id='.$row["id"].'">'.$row["summary"].'</a></div>';
            print '<div class="cell">'.$row["owner"].'</div>';
            print '<div class="cell">'.$row["created"].'</div>';
            print "</div>";
        }
        print "</div>";
    }

    function addIdea($summary, $details, $ownerId)
    {
        $q = sprintf(
            'INSERT INTO idea (summary,details,owner,status,created,last_updated) VALUES ("%s", "%s", %d, "open", NOW(), NOW())',
            $summary,
            $details,
            $ownerId
            );
    
        error_log("addIdea:\n".$q);

        $res = mysqli_query($this->dbh, $q);
    }

    function updateIdea($id, $summary, $details, $status) {

        $q = sprintf(
            'UPDATE idea SET summary="%s", details="%s", status="%s", last_updated=NOW() WHERE id=%d', 
            $summary,
            $details,
            $status,
            $id
            );
    
        $res = mysqli_query($this->dbh, $q);
    }

    function attachFileToIdea($id, $text) {
    }

    function commentOnIdea($id, $text) {
        $q = sprintf(
            'INSERT INTO comment (idea_id, user_id, comment, timestamp) VALUES (%d,%d,"%s", NOW())',
            $id, 
            $this->getCurrentUserId(), 
            $text);

        error_log("commentonidea: q=".$q);

        $res = mysqli_query($this->dbh, $q);        
    }

    function voteIdea($id, $userId, $vote)
    {
        $res = mysqli_query($this->dbh, "UPDATE vote SET vote=".$vote." WHERE idea_id=".$id." AND user_id=".$userId);
        if (mysqli_num_rows($res) == 0)
            $res = mysqli_query($this->dbh, "INSERT INTO vote (idea_id, user_id, vote) VALUES (".$id.", ".$userId.", ".$vote.")");
    }


    function deleteIdea($id) 
    {
        $res = mysqli_query($this->dbh, "DELETE FROM idea WHERE id=".$id);
    }

    function getIdea($id)
    {
        // TODO optimize query
        $res = mysqli_query($this->dbh, "SELECT summary,details,owner,created,last_updated FROM idea WHERE id=".$id);
        if (mysqli_num_rows($res) > 0)
            return mysqli_fetch_assoc($res);
        else
            return NULL;
    }

    function getComments($id)
    {
        $q = "SELECT * FROM comment WHERE idea_id=".$id." ORDER BY timestamp";
        error_log("getComments: q=".$q);
        $res = mysqli_query($this->dbh, $q);
        $ret = array();
        while ($row = mysqli_fetch_assoc($res))
        {
            $ret[] = $row;
        }
        return $ret;
    }

    function getCurrentUserId()
    {
        // TODO
        return 1;
    }

}

?>