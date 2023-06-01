<?php

function GET_Main($dbconn) 
{
    View("page_main", []);
}

function GET_Result($dbconn) 
{
    if( isset($_GET["type"]) )
    {
        View("result_{$_GET["type"]}");
    }
    else 
    {
        Redirect();
    }
}

function GET_Create($dbconn) 
{
    View("form_create", [], "form");
}

function GET_Update($dbconn) 
{
    $survay = ValidateSurvay($dbconn);

    $options = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_OPTIONS ." WHERE id_survay = ?", [ (int)$survay["id"] ]);

    View("form_update", 
    [
        "SurvayData" => $survay ,
        "SurvayOptions" => $options
    ]
    , "form");
}

function GET_Vote($dbconn) 
{
    $survay = ValidateSurvay($dbconn, FALSE);
    $sid = PostParam($_REQUEST["survay"], FALSE);

    $stateVote = SE_CheckVote($survay["link_vote"], SESSION_SCOPE_VOTES);
    $stateView = SE_Update($survay["link_vote"], SESSION_SCOPE_VIEWS);

    if( $stateVote )
    {
        Redirect("action=result&type=already_voted&survay=$sid");
    }
    
    if( $stateView )
    {
        DB_Execute($dbconn, "UPDATE ". DB_TABLE_SURVAYS ." SET views = views + 1 WHERE id = ?", [ (int)$survay["id"] ]);
    }
    
    $options = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_OPTIONS ." WHERE id_survay = ?", [ (int)$survay["id"] ]);

    View("survay_vote", 
    [
        "SurvayData" => $survay ,
        "SurvayOptions" => $options
    ]
    , "vote");
}

function GET_Stats($dbconn) 
{
    $survay = ValidateSurvay($dbconn, FALSE);
    $author = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_USERS ." WHERE survay_link_manage = ?", [ $survay["link_manage"] ])[0]["nickname"];
    $options = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_OPTIONS ." WHERE id_survay = ?", [ (int)$survay["id"] ]);

    $submitsSum = 0;
    $optionsPercent = [];

    foreach($options as $opt) 
    {
        $submitsSum += (int)$opt["submits"];
    }
    
    foreach($options as $opt) 
    {
        $optionsPercent[ $opt["id"] ] = (int)$opt["submits"] == 0 ? 0 : ( 100 / $submitsSum ) * (int)$opt["submits"];
    }

    View("survay_stats", 
    [
        "SurvayData" => $survay ,
        "SurvayOptions" => $options ,
        "CreatorName" => $author ,
        "SubmitsSum" => $submitsSum ,
        "OptionsPercent" => $optionsPercent
    ]);
}

function POST_Vote($dbconn) 
{
    CheckReCaptch();
    
    $survay = ValidateSurvay($dbconn, FALSE);

    DB_Execute($dbconn, "UPDATE ". DB_TABLE_OPTIONS ." SET submits = submits + 1 WHERE id = ?", [ PostParam("selectedOption") ]);
    
    SE_Update($survay["link_vote"], SESSION_SCOPE_VOTES);

    Redirect("action=stats&survay={$_REQUEST["survay"]}");
}

function POST_Create($dbconn) 
{
    CheckReCaptch();
    
    $email = PostParam("s_email");
    $creator = PostParam("s_creator");
    $question = PostParam("s_question");
    $note = PostParam("s_note");
    $linkVote = RandomString(8);
    $linkManage = RandomString(12);

    DB_Execute($dbconn, "INSERT INTO ". DB_TABLE_USERS ." VALUES (NULL, ?, ?, ?)", [ $creator, $email, $linkManage ]);

    DB_Execute($dbconn, "INSERT INTO ". DB_TABLE_SURVAYS ." VALUES (NULL, ?, ?, ?, ?, ?)", [ $question , $note , $linkVote , $linkManage , 0 ]);

    $newSurvayId = (int)DB_Query( $dbconn, "SELECT * FROM ". DB_TABLE_SURVAYS ." WHERE link_manage = ?", [ $linkManage ] )[0]["id"];

    foreach($_POST["s_options"] as $option) 
    {
        $content = PostParam($option, FALSE);
        DB_Execute($dbconn, "INSERT INTO ". DB_TABLE_OPTIONS ." VALUES (NULL, ?, ?, 0)", [ $newSurvayId, $content ]);    
    }

    SendMailCreation($email, $creator, $question, $linkVote, $linkManage);

    Redirect("action=result&type=done_create");
}

function POST_Update($dbconn) 
{
    CheckReCaptch();

    $survay = ValidateSurvay($dbconn);
    $question = PostParam("s_question");
    $note = PostParam("s_note");

    DB_Execute($dbconn, "UPDATE ". DB_TABLE_SURVAYS ." SET question = ? , note = ? WHERE link_manage = ?", [ $question, $note,  $survay["link_manage"] ]);
    
    $optionsContent = $_POST["s_options"];
    $optionsId = $_POST["s_options_id"];

    for($k = 0; $k < count($optionsId); $k++) 
    {
        $content = PostParam($optionsContent[$k], FALSE);

        if( $optionsId[$k] == "+" )
        {
            DB_Execute($dbconn, "INSERT INTO ". DB_TABLE_OPTIONS ." VALUES (NULL, ?, ?, 0)", [ $survay["id"], $content ]);
        }
        else if( (int)$optionsId[$k] < 0 )
        {
            DB_Execute($dbconn, "DELETE FROM ". DB_TABLE_OPTIONS ." WHERE id = ?", [ -(int)$optionsId[$k] ]);
        }
        else
        {
            DB_Execute($dbconn, "UPDATE ". DB_TABLE_OPTIONS ." SET content = ? WHERE id = ?", [ $content, (int)$optionsId[$k] ]);
        }
    }

    Redirect("action=result&type=done_update");
}

function POST_Delete($dbconn) 
{
    CheckReCaptch();

    $survay = ValidateSurvay($dbconn);
    $user = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_USERS ." WHERE survay_link_manage = ?", [ $survay["link_manage"] ])[0];

    DB_Execute($dbconn, "DELETE FROM ". DB_TABLE_USERS ." WHERE survay_link_manage = ?", [ $survay["link_manage"] ]);
    DB_Execute($dbconn, "DELETE FROM ". DB_TABLE_SURVAYS ." WHERE link_manage = ?", [ $survay["link_manage"] ]);
    DB_Execute($dbconn, "DELETE FROM ". DB_TABLE_OPTIONS ." WHERE id_survay = ?", [ (int)$survay["id"] ]);
    
    SendMailDeletion($user["email"], $user["nickname"], $survay["question"]);

    Redirect("action=result&type=done_delete");
}

?>