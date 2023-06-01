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

<span class="stats">
    <i class="fa fa-user"></i>
    سازنده : <?=$CreatorName?>
</span>

<span class="stats">
    <i class="fa fa-eye"></i> <?=$SurvayData["views"]?> بازدید
</span>

<span class="stats">
    <i class="fa fa-check-square-o"></i> <?=$SubmitsSum?> رای دهنده
</span>

<hr/>

<div class="stats-options">

    <?php foreach($SurvayOptions as $option): ?>
        <div>
            <span style="width: <?=round($OptionsPercent[ $option["id"] ])?>%;"></span>
            <?=round($OptionsPercent[ $option["id"] ])?>% /
            <?=$option["submits"]?> نفر /
            <?=$option["content"]?>
        </div>
    <?php endforeach; ?>

</div>
<hr/>

<a href="/"> صفحه اصلی </a>