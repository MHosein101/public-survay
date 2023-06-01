<!DOCTYPE html>
<html lang="fa">
<head>
    <title> نظرسنجی ساز آنلاین </title>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="نظرسنجی , نظرسنجی ساز آنلاین , رای گیری , آمارگیری , اطلاعات" />
    <meta name="description" content="به سادگی و رایگان نظرسنجی خود را بسازید , به اشتراک بگذارید , آمار آن را مشاهده کنید , و یا در صورت نیاز آن را ویرایش و یا حذف کنید." />
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="icon" href="styles/icon.png" />

    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> <!-- https://www.w3schools.com/icons/fontawesome_icons_intro.asp -->
    <link rel="stylesheet" href="styles/main.css" />
    
    <?php if($__Extra != FALSE): ?> 
        <link rel="stylesheet" href="styles/<?=$__Extra?>.css" /> 
        <script src="scripts/<?=$__Extra?>.js"></script>
    <?php endif; ?>
</head>
<body>
    <div class="container"> <?php require $__Content; ?> </div>
</body>
</html>