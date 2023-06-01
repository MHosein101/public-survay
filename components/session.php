<?php

function SE_Set($value) 
{
    $_SESSION[SESSION_KEY] = $value;
    session_commit();
}

function SE_Get() 
{
    return $_SESSION[SESSION_KEY];
}

function SE_Init() 
{
    if( ! isset($_SESSION[SESSION_KEY]) ) 
    {
        SE_Set(
        [
            SESSION_SCOPE_VIEWS => [] ,
            SESSION_SCOPE_VOTES => []
        ]);
    }
}

function SE_Update($survayVoteId, $scope) 
{
    $data = SE_Get();

    if( ! isset( $data[$scope][$survayVoteId] ) ) 
    {
        $data[$scope][$survayVoteId] = TRUE;
        SE_Set($data);
        return TRUE;
    }

    return FALSE;
}

function SE_CheckVote($survayVoteId) 
{
    return isset( SE_Get()[SESSION_SCOPE_VOTES][$survayVoteId] );
}

?>