
<div class="content">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <?php echo form_open_multipart($action); ?>
    <div class="data">
        <table>
            <tr>
                <td valign="top">Right Top Image<br/>(Maximum: 223x131)</td>
                <td><input type="file" name="imgrighttop" class="text"/></td>
            </tr>
            <tr>
                <td valign="top">Description for This Image</td>
                <td>
                    <textarea name="altrighttop" class="text"><?php echo $this->form_validation->altrighttop; ?></textarea>
                    <?php echo form_error('altrighttop') ?>
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
