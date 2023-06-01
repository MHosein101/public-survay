<?php

ini_set('session.gc_maxlifetime', 1209600);
session_set_cookie_params(1209600); // 14 days
session_start();

define("DEBUG", TRUE);

define("DIR_ROOT", __DIR__ . DIRECTORY_SEPARATOR);
define("DIR_COMPONENTS", DIR_ROOT  . "components" . DIRECTORY_SEPARATOR);
define("DIR_VIEWS", DIR_ROOT . "views" . DIRECTORY_SEPARATOR);

define("SESSION_KEY", "USER_ACTION_TRACKING");
define("SESSION_SCOPE_VIEWS", "VIEWS");
define("SESSION_SCOPE_VOTES", "VOTES");

define("AUTOLOAD_COMPONENTS", 
[
    "functions" , 
    "session" , 
    "routing" , 
    "db" , 
    "controllers"
]);

define("DB_TABLE_USERS", "users");
define("DB_TABLE_SURVAYS", "survays");
define("DB_TABLE_OPTIONS", "options");

if(DEBUG) 
{
    // localhost
    define("RECAPTCHA_KEY_SITE", "6LcStUceAAAAAFKa6P77hPV2S0EdnNWGZmLsaWhg");
    define("RECAPTCHA_KEY_SECRET", "6LcStUceAAAAAOb_oRWHUxa42GKIIRnt10PgWHTt");
}
else 
{
    // server
    define("RECAPTCHA_KEY_SITE", "6Lfv3EceAAAAAHSjHIChPO1p7EQtzl6o7fzcsWD8");
    define("RECAPTCHA_KEY_SECRET", "6Lfv3EceAAAAAGVwNwVymgzZ_XhjveXqIh4oPO0o");
}

function SurvayApp() 
{
    foreach([ "functions" , "session" , "routing" , "db" , "controllers" ] as $component)
    {
        require DIR_COMPONENTS . "$component.php";
    }

    $dbConnection = NULL;
    $controller = Routing();

    if(DEBUG)
    {
        $dbConnection = DB_Connect(
        [
            "type" => "SQLITE" ,
            "database" => DIR_COMPONENTS . "survay.db"
        ]);
    }
    else 
    {
        $dbConnection = DB_Connect(
        [
            "type" => "MYSQL" ,
            "username" => "online_survey" ,
            "password" => "root" ,
            "database" => ""
        ]);
    }

    SE_Init();

    $controller($dbConnection);
}

SurvayApp();

?>