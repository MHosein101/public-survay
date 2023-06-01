<?php

function Routes() 
{
    return [
        "GET" => 
        [
            "debug" => "X_DEBUG" ,
            "result" => "GET_Result" ,
            "create" => "GET_Create" ,
            "update" => "GET_Update" ,
            "vote" => "GET_Vote" ,
            "stats" => "GET_Stats"
        ] ,
        "POST" => 
        [
            "vote" => "POST_Vote" ,
            "create" => "POST_Create" ,
            "update" => "POST_Update" ,
            "delete" => "POST_Delete"
        ]
    ];
}

function Routing() 
{
    $__Routes = Routes();
    $RouteModifier = "action";
    $AllowedRequestMethod = isset($__Routes[ $_SERVER["REQUEST_METHOD"] ]);

    if( $AllowedRequestMethod ) 
    {
        if( isset($_REQUEST[$RouteModifier]) ) 
        {
            $AllowedRoute =  isset($__Routes[ $_SERVER["REQUEST_METHOD"] ][ $_REQUEST[$RouteModifier] ]);

            if($AllowedRoute) 
            {
                $controller =  $__Routes[ $_SERVER["REQUEST_METHOD"] ][ $_REQUEST[$RouteModifier] ];
                return $controller;
            }
            else
            {
                Redirect();
            }
        }
    }

    return "GET_Main"; // default
}


?>