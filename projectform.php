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
    <?php echo form_open($action); ?>
        <div class="data">
            <div class="row">
                <label name="lbltitle" id="lbltitle" for="title">Project Title
                    <span class="lblerror">
                       <br /><?=form_error('title') ?>
                    </span>
                </label>
                <input taborder="30" type="text" name="title" class="text" size="50"
                       value="<?=$this->form_validation->title; ?>"/>
            </div>
            <div class="row">
                <label name="lbldescription" id="lbldescription" for="description">Project Description
                    <span class="lblspan">
                        <br />
                        (A brief paragraph describing the project.)
                    </span>
                    <span class="lblerror">
                       <br /><?=form_error('description') ?>
                    </span>
                </label>
                <textarea taborder="40" name="description" class="text"
                          rows="5" cols="48"><?=$this->form_validation->description; ?></textarea>
            </div>
            <div class="row">
                <label name="lblurlwork" id="lblurlwork" for="urlwork">Link to Work
                    <span class="lblspan">
                        <br />
                        (OPTIONAL: A link to the actual live project)
                    </span>
                    <span class="lblerror">
                       <br /><?=form_error('urlwork') ?>
                    </span>
                </label>
                <input taborder="50" type="text" name="urlwork" class="text" size="50"
                       value="<?=$this->form_validation->urlwork; ?>"/>
            </div>
            <div class="rowbtn">
                    <input type="hidden" name="idproject"
                           value="<?=$this->form_validation->idproject; ?>"/>
                <input taborder="100" class="btnsubmit" type="submit" value="Save"/>
            </div>
        </div>
    </form>
</div>
