
<div class="content">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <?php echo form_open_multipart($action); ?>
    <div class="data">
        <table>
            <tr>
                <td valign="top">Resume File</td>
                <td>
                    <input type="file" name="fileresume" class="text" />
    <?php echo form_error('fileresume') ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Save"/></td>
            </tr>
        </table>
    </div>
</form>
<br /><?php echo $link_back; ?>
</div>
