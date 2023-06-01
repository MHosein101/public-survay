<h1>نظرسنجی جدید</h1>
<hr/>

<form id="form-survay-create" action="?action=create" method="POST">

    <div class="f-group">
        <div class="f-item">
            <label for="s-creator">
                <i class="fa fa-user"></i>
                نام سازنده
            </label>
            <input type="text" name="s_creator" id="s-creator" required />
        </div>
        <div class="f-item">
            <label for="s-email">
                <i class="fa fa-at"></i>
                ایمیل سازنده
            </label>
            <input type="email" name="s_email" id="s-email" required />
        </div>
    </div>

    <hr/>

    <div class="f-group-column">
        <div class="f-item">
            <label for="s-question">
                <i class="fa fa-question"></i>
                سوال نظرسنجی
            </label>
            <input type="text" name="s_question" id="s-question" required />
        </div>
        <div class="f-item">
            <label for="s-note">
                <i class="fa fa-sticky-note"></i>
                توضیحات - اختیاری
            </label>
            <textarea name="s_note" id="s-note" rows="2"></textarea>
        </div>
    </div>

    <div class="f-group" id="survay-options">
        <div class="f-item">
            <label>
                <i class="fa fa-bars"></i>
                گزینه ها - حداقل 2 عدد
            </label>
            <input type="text" name="s_options[]" class="survay-option" required />
        </div>
        <div class="f-item">
            <input type="text" name="s_options[]" class="survay-option" required />
        </div>
    </div>

    <button id="btn-add-option"> 
        <i class="fa fa-plus"></i>
        گزینه جدید
    </button> 

    <br/> <br/>
    <div class="g-recaptcha" style="display: inline-block;" data-sitekey="<?=RECAPTCHA_KEY_SITE?>"></div>
    <br/>

    <button id="btn-submit-create">
        <i class="fa fa-save"></i>
        تکمیل و ایجاد نظرسنجی
    </button>

</form>