
        <div class="content">
            <h1><?php echo $title; ?></h1>
            <?php echo $message; ?>
            <?php echo form_open_multipart($action); ?>
            <div class="data">
                <table>
                    <tr>
                        <td valign="top">First Name</td>
                        <td>
                            <input type="text" name="namefirst" class="text"
                                   value="<?php echo $this->form_validation->namefirst; ?>"/>
                                   <?php echo form_error('namefirst') ?> 
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Last Name</td>
                        <td>
                            <input type="text" name="namelast" class="text"
                                   value="<?php echo $this->form_validation->namelast; ?>"/>
                                   <?php echo form_error('namelast') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Link to LinkedIn</td>
                        <td>
                            <input type="text" name="urllinkedin" class="text"
                                   value="<?php echo $this->form_validation->urllinkedin; ?>"/>
                                   <?php echo form_error('urllinkedin') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Contact E-Mail</td>
                        <td>
                            <input type="text" name="contactemail" class="text"
                                   value="<?php echo $this->form_validation->contactemail; ?>"/>
                                   <?php echo form_error('contactemail') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Contact Message</td>
                        <td>
                            <input type="text" name="contactmessage" class="text"
                                   value="<?php echo $this->form_validation->contactmessage; ?>"/>
                                   <?php echo form_error('contactmessage') ?>
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
