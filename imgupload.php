
<div class="content">
    <h1>Update <?=$whichimage ?> Image</h1>
    <?php echo $message; ?>
    <?php echo form_open_multipart($action); ?>
    <div class="data">
        <div class="row">
            <label name="lblimage" id="lblimage" for="image">Maximum: <?=$width ?>x<?=$height ?></label>
            <input type="file" name="image" class="text"/>
        </div>
        <div class="row">
            <label name="lblalt" id="lbldescr" for="alt">Description</label>
            <textarea name="alt" class="text"><?php echo $this->form_validation->alt; ?></textarea>
            <?php echo form_error('alt') ?>
        </div>
        <div class="row">
            <input type="hidden" name="idproject"
                   value="<?php echo $this->form_validation->idproject; ?>"/>
            <input type="submit" value="Save"/>
        </div>
    </div>
</form>
<br /><?php echo $link_back; ?>
</div>
