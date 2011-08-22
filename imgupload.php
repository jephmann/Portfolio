<div class="update">
    <div class="top">
        <div class="topleft">
            <h1><?=$title ?></h1>
        </div>
        <div class="topright">
            <span class="linkback"><?=$link_back; ?></span>
        </div>
    </div>
    <div class="clear"></div>
    <?php echo form_open_multipart($action); ?>
        <div class="data">
            <div class="row">
                <label name="lblimgdefault" id="lblimage">
                    Current Image
                    <br />Maximum: <?=$width ?>x<?=$height ?>
                    <span class="phperror"><?=$message; ?></span>
                </label>
                <photo>
                <img src="<?=$imgdefault ?>" alt="<?=$altdefault ?>" title="<?=$altdefault ?>" width="400px"/>
                </photo>
            </div>
            <div class="row">
                <label name="lblimage" id="lblimage" for="image">Select an Image
                    <span class="lblerror">
                       <br /><?=form_error('image') ?>
                    </span>
                </label>
                <input taborder="10" type="file" name="image" class="text" size="65"/>
            </div>
            <div class="row">
                <label name="lblkeep" id="lblkeep" for="keep">Check if keeping current image:</label>
                <input taborder="15" type="checkbox" name="keep" value="Keep" />
            </div>
            <div class="row">
                <label name="lblalt" id="lbldescr" for="alt">Description
                    <span class="lblspan">
                        <br />This text appears when a user mouses over the image. (Optional)
                    </span>
                    <span class="lblerror">
                       <br /><?=form_error('alt') ?>
                    </span>
                </label>
                <textarea taborder="20" name="alt" class="text"
                          rows="5" cols="48"><?=$this->form_validation->alt; ?></textarea>
            </div>
            <div class="rowbtn">
                <input type="hidden" name="idproject"
                       value="<?=$this->form_validation->idproject; ?>"/>
                <input taborder="30" class="btnsubmit" type="submit" value="Save"/>
            </div>
        </div>
    </form>
</div>
