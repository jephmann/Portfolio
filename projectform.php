
        <div class="content">
            <h1><?php echo $title; ?></h1>
            <?php echo $message; ?>
            <?php echo form_open_multipart($action); ?>
            <div class="data">
                <table>
                    <tr>
                        <td valign="top">Project Title</td>
                        <td>
                            <input type="text" name="title" class="text"
                                   value="<?php echo $this->form_validation->title; ?>"/>
                                   <?php echo form_error('title') ?> 
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Project Description</td>
                        <td>
                            <textarea name="description" class="text"><?php echo $this->form_validation->description; ?></textarea>
                                   <?php echo form_error('description') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Link to Work</td>
                        <td>
                            <input type="text" name="urlwork" class="text"
                                   value="<?php echo $this->form_validation->urlwork; ?>"/>
                                   <?php echo form_error('urlwork') ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                    <input type="hidden" name="idproject"
                           value="<?php echo $this->form_validation->idproject; ?>"/></td>
                        <td><input type="submit" value="Save"/></td>
                    </tr>
                </table>
            </div>
        </form>
        <br /><?php echo $link_back; ?>
        </div>
