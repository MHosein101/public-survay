<?php

function View($__File, $__Data = [], $__Extra = FALSE) 
{
    extract($__Data);
    $__Content = DIR_VIEWS . "$__File.php";

    if( ! file_exists($__Content) )
    {
        Redirect();
    }

    require DIR_COMPONENTS . "template.php";
}

function Redirect($url = "", $code = 302) 
{
    $url = trim($url,'/');

    if($url == '') 
    {
        header("Location: http://" . $_SERVER['HTTP_HOST'], true, $code);
    }
    else 
    {
        $url = "http://" . $_SERVER['HTTP_HOST'] . '/index.php?' . $url;
        header("Location: $url", true, $code);
    }

    die();
}

function vd(...$args) 
{
    echo "<code><pre>";
    var_dump($args);
    echo "</pre></code>";
    die();
}

function RandomString($length = 10) 
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";

    for ($i = 0; $i < $length; $i++) 
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function ValidateSurvay($dbconn, $byManageLink = TRUE) 
{
    if( !isset($_REQUEST["survay"]) )
    {
        Redirect();
    }

    $sid = PostParam($_REQUEST["survay"], FALSE);
    $field = $byManageLink ? "link_manage" : "link_vote";
    $survay = DB_Query($dbconn, "SELECT * FROM ". DB_TABLE_SURVAYS ." WHERE $field = ?", [ $sid ]);

    if( count($survay) == 0 )
    {
        Redirect("action=result&type=error");
    }
    
    return $survay[0];
}

function PostParam($term, $byRef = TRUE) 
{
    $value = $term;

    if( $byRef ) 
    {
        if( isset($_POST[$term]) )
        {
            $value = $_POST[$term];
        }
        else
        {
            vd("POST parameter [ $term ] is NOT found");
        }
    }
    
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlentities($value);
    $value = filter_var($value, FILTER_SANITIZE_STRING);

    return $value;
}

function CheckReCaptch() 
{
    $url = "https://www.google.com/recaptcha/api/siteverify";

    $data = http_build_query(
    [
        "secret" => RECAPTCHA_KEY_SECRET ,
        "response" => $_POST['g-recaptcha-response']
    ]);

    $context = stream_context_create(
    [
        "http" => 
        [
            "header" => "Content-type: application/x-www-form-urlencoded\r\n" ,
            "method" => "POST" ,
            "content" => $data ,
        ]
    ]);

    $result = file_get_contents($url, FALSE, $context);
    $result = json_decode($result, TRUE);

    if( ! $result["success"] )
    {
        Redirect("action=result&type=invalid_recaptcha");
    }
}

function SendMailCreation($email, $nickname, $question, $voteId, $manageId) 
{
    $subject = "ساخت نظرسنجی : $question";

    $linkBase = "http://" . $_SERVER['HTTP_HOST'] . '/index.php';

    $linkVote = $linkBase . "?action=vote&survay=$voteId";
    $linkStats = $linkBase . "?action=stats&survay=$voteId";
    $linkUpdate = $linkBase . "?action=update&survay=$manageId";

    $message = "<html> <head> <title>$subject</title> </head> <body>
<style type='text/css'> html, body { direction: rtl; max-width: 540px; margin: 20px auto; padding: 0 20px;  text-align: right; font-family: 'Courier New', Courier; font-weight: 900; color: #222222; } 
a { font-family: monospace; text-decoration: underline; color: #00753f; } h1 { font-size: 30px; } h2 { font-size: 26px; } p { font-size: 20px; margin: 0; }</style>

<h1> $nickname گرامی </h1>
<h2> نظرسنجی ( <u> $question </u> ) با موفقیت ایجاد شد. </h2>
<br/>
<p>
    برای رای دادن افراد دیگر لینک زیر را برای آنها به اشتراک بگذارید.
    <br/> <br/>
    <a href='$linkVote' target='_blank'>$linkVote</a>
</p>
<br/> <br/>
<p>
    از لینک زیر میتوانید آمار رای افراد را مشاهده کنید.
    <br/> <br/>
    <a href='$linkStats' target='_blank'>$linkStats</a>
</p>
<br/> <br/>
<p>
    برای ویرایش نظرسنجی و یا حذف آن از لینک زیر استفاده کنید. <br/>
    نکته : این لینک را در دسترس افراد دیگر قرار ندهید.
    <br/> <br/>
    <a href='$linkUpdate' target='_blank'>$linkUpdate</a>
</p>
<br/> <br/>
<p>
    از اینکه از این ابزار استفاده میکنید از شما متشکریم. <br/> <br/>
    <a href='$linkBase' target='_blank' style='font-family: 'Courier New', Courier;'>نظرسنجی ساز آنلاین</a>
</p>
</body> </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    
    if(DEBUG) 
    {
        $f = fopen("mail-create.html", "w");
        fwrite($f, $message);
        fclose($f);
    }
    else 
    {
        mail($email, $subject, $message, $headers);
    }
}

function SendMailDeletion($email, $nickname, $question) 
{
    $subject = "حذف نظرسنجی : $question";

    $linkBase = "http://" . $_SERVER['HTTP_HOST'] . '/index.php';

    $message = "<html> <head> <title>$subject</title> </head> <body>
<style  type='text/css'> html, body { direction: rtl; max-width: 540px; margin: 20px auto; padding: 0 20px;  text-align: right; font-family: 'Courier New', Courier; font-weight: 900; color: #222222; } 
a { font-family: monospace; text-decoration: underline; color: #00753f; } h1 { font-size: 30px; } h2 { font-size: 26px; } p { font-size: 20px; margin: 0; }</style>

<h1> $nickname گرامی </h1>
<h2> نظرسنجی ( <u> $question </u> ) با موفقیت حذف شد. </h2>
<br/>
<p>
    اطلاعات نظرسنجی به همراه نام و ایمیل شما حذف شده اند. <br/>
    و همچنین تمام لینک های موبوط به این نظرسنجی نامعتبر شدند.
</p>
<br/> <br/>
<p>
    از اینکه از این ابزار استفاده میکنید از شما متشکریم. <br/> <br/>
    <a href='$linkBase' target='_blank' style='font-family: 'Courier New', Courier;'>نظرسنجی ساز آنلاین</a>
</p>
</body> </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    if(DEBUG) 
    {
        $f = fopen("mail-delete.html", "w");
        fwrite($f, $message);
        fclose($f);
    }
    else 
    {
        mail($email, $subject, $message, $headers);
    }
}

?>