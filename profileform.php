<div class="update">
    <div class="top">
        <div class="topleft">
            <h1><?=$title; ?></h1>
        </div>
        <div class="topright">
            <span class="phperror"><?=$message; ?></span>
            <span class="linkback"><?=$link_back; ?></span>
        </div>
    </div>
    <div class="clear"></div>
            <?=form_open($action); ?>
    <div class="data">
        <div class="row">
            <label name="lblnamefirst" id="lblnamefirst" for="namefirst">First Name
                <span class="lblerror">
                    <br /><?=form_error('namefirst') ?>
                </span>
            </label>
            <input taborder="10" type="text" name="namefirst" class="text" size="50"
                       value="<?=$this->form_validation->namefirst; ?>"/>
        </div>
        <div class="row">
            <label name="lblnamelast" id="lblnamelast" for="namelast">Last Name
                <span class="lblerror">
                    <br /><?=form_error('namelast') ?>
                </span>
            </label>
            <input taborder="20" type="text" name="namelast" class="text" size="50"
                   value="<?=$this->form_validation->namelast; ?>"/>
        </div>
        <div class="row">
            <label name="lblurllinkedin" id="lblurllinkedin" for="urllinkedin">Link to LinkedIn
                <span class="lblerror">
                    <br /><?=form_error('urllinkedin') ?>
                </span>
            </label>
            <input taborder="30" type="text" name="urllinkedin" class="text" size="50"
                   value="<?=$this->form_validation->urllinkedin; ?>"/>
        </div>
        <div class="row">
            <label name="lblcontactemail" id="lbltitle" for="contactemail">Contact E-Mail
                <span class="lblspan">
                    <br />
                    (Required only if you wish to include the Contact Me form)
                </span>
                <span class="lblerror">
                    <br /><?=form_error('contactemail') ?>
                </span>
            </label>
            <input taborder="40" type="text" name="contactemail" class="text" size="50"
                   value="<?=$this->form_validation->contactemail; ?>"/>
        </div>
        <div class="row">
            <label name="lblcontactmessage" id="lbldescription" for="contactmessage">Contact Message
                <span class="lblspan">
                    <br />
                    (OPTIONAL: The message which appears on your Contact Me form)
                </span>
                <span class="lblerror">
                    <br /><?=form_error('contactmessage') ?>
                </span>
            </label>
            <textarea taborder="50" name="contactmessage" class="text"
                      rows="5" cols="48"><?=$this->form_validation->contactmessage; ?></textarea>
        </div>
        <div class="rowbtn">
            <input taborder="100" type="submit" class="btnsubmit" value="Save"/>
        </div>
    </div>
</form>
</div>
