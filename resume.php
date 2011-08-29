<div class="update">
    <div class="top">
        <div class="topleft">
            <h1><?=$title; ?></h1>
        </div>
        <div class="topright">
            <p class="linkback"><?=$link_back; ?></p>
        </div>
    </div>
    <div class="clear"></div>    
    <?php echo form_open_multipart($action); ?>
        <div class="data">
            <div class="row">
                <label name="lblfileresume" id="lblfileresume" for="fileresume"><?php echo $message; ?></label>
                <input taborder="10" type="file" name="fileresume" class="text" size="65"/>
                <?php echo form_error('fileresume') ?>
            </div>
            <div class="rowbtn">
                <input taborder="30" type="submit" class="btnsubmit" value="Save"/>
            </div>
        </div>
    </form>
</div>
