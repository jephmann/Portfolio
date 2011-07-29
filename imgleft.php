
<div class="content">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <?php echo form_open_multipart($action); ?>
    <div class="data">
        <table>
            <tr>
                <td valign="top">Left Image<br/>(Maximum: 471x276)</td>
                <td><input type="file" name="imgleft" class="text"/></td>
            </tr>
            <tr>
                <td valign="top">Description for This Image</td>
                <td>
                    <textarea name="altleft" class="text"><?php echo $this->form_validation->altleft; ?></textarea>
                    <?php echo form_error('altleft') ?>
                </td>
            </tr>
            <tr>
                <td><input type="hidden" name="idproject"
                           value="<?php echo $this->form_validation->idproject; ?>"/></td>
                <td><input type="submit" value="Save"/></td>
            </tr>
        </table>
    </div>
</form>
<br /><?php echo $link_back; ?>
</div>
