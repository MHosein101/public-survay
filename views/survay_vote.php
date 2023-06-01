<h1>
    <i class="fa fa-question-circle"></i>
    <?=$SurvayData["question"]?>
</h1>

<?php if( $SurvayData["note"] != "" ): ?>
    <div class="alert">
        <i class="fa fa-info-circle"></i>
        <?=$SurvayData["note"]?>
    </div>
<?php endif; ?>

<hr/>

<div class="vote-options">
    <?php foreach($SurvayOptions as $option): ?>
        <button data-id="<?=$option["id"]?>" class="options">
            <i class="fa fa-circle"></i>
            <?=$option["content"]?>
        </button>
    <?php endforeach; ?>
</div>

<hr/>

<form action="/index.php?action=vote&survay=<?=$SurvayData["link_vote"]?>" method="POST">

    <div class="g-recaptcha" style="display: inline-block;" data-sitekey="<?=RECAPTCHA_KEY_SITE?>"></div>
    <br/>

    <input type="hidden" name="selectedOption" id="selected-option" value="" />

    <button id="btn-submit">
        <i class="fa fa-check-square"></i>
        ثبت انتخاب
    </button>

</form>
