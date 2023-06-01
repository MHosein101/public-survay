<h1>ویرایش نظرسنجی</h1>
<hr/>

<form id="form-survay-update" action="?action=update&survay=<?=$_REQUEST["survay"]?>" method="POST">

    <div class="f-group-column">
        <div class="f-item">
            <label for="s-question">
                <i class="fa fa-question"></i>
                سوال نظرسنجی
            </label>
            <input type="text" name="s_question" id="s-question" value="<?=$SurvayData["question"]?>" required />
        </div>
        <div class="f-item">
            <label for="s-note">
                <i class="fa fa-sticky-note"></i>
                توضیحات - اختیاری
            </label>
            <textarea name="s_note" id="s-note" rows="2"><?=$SurvayData["note"]?></textarea>
        </div>
    </div>

    <div class="f-group" id="survay-options">
        <div class="f-item">
            <label>
                <i class="fa fa-bars"></i>
                گزینه ها - حداقل 2 عدد
            </label>
            <input type="text" name="s_options[]" class="survay-option" value="<?=$SurvayOptions[0]["content"]?>" required />
            <input type="hidden" name="s_options_id[]" value="<?=$SurvayOptions[0]["id"]?>" />
        </div>
        <div class="f-item">
            <input type="text" name="s_options[]" class="survay-option" value="<?=$SurvayOptions[1]["content"]?>" required />
            <input type="hidden" name="s_options_id[]" value="<?=$SurvayOptions[1]["id"]?>" />
        </div>
        <?php if( count($SurvayOptions) > 2 ): for($i = 2; $i < count($SurvayOptions); $i++): ?>
            <div class="f-item split">
                <input type="text" name="s_options[]" class="survay-option" value="<?=$SurvayOptions[$i]["content"]?>" required />
                <button class="option-remove"> <i class="fa fa-remove"></i> </button>
                <input type="hidden" name="s_options_id[]" value="<?=$SurvayOptions[$i]["id"]?>" />
            </div>
        <?php endfor; endif; ?>
    </div>
    

    <button id="btn-add-option" data-mode-update="1"> 
        <i class="fa fa-plus"></i>
        گزینه جدید
    </button> 

    <br/> <br/>
    <div class="g-recaptcha" style="display: inline-block;" data-sitekey="<?=RECAPTCHA_KEY_SITE?>"></div>
    <br/>

    <button id="btn-submit-update">
        <i class="fa fa-save"></i>
        ذخیره تغییرات
    </button>

</form>

<hr/>

<form id="form-survay-delete" action="?action=delete&survay=<?=$_REQUEST["survay"]?>" method="POST">
    
    <div class="alert">
            از این قسمت میتوانید نظرسنجی خود را حذف نمایید.
    </div>

    <br/><br/>
    <div class="g-recaptcha" style="display: inline-block;" data-sitekey="<?=RECAPTCHA_KEY_SITE?>"></div>
    <br/>

    <button id="btn-submit-delete">
        <i class="fa fa-trash"></i>
        حذف نظرسنجی
    </button>

</form>