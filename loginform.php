<h1>Portfolio Management: Login</h1>
<?php echo form_open('verifylogin'); ?>
    <div class="row">
        <label for="username">
            Username:
            <span class="phperror"><?=form_error('username') ?></span>
        </label>
        <input type="text" size="20" id="username" name="username"/>
        
    </div>
    <div class="row">
        <label for="password">
            Password:
            <span class="phperror"><?=form_error('password') ?></span>
        </label>
        <input type="password" size="20" id="password" name="password"/>
    </div>
    <div class="rowbtn">
        <input type="submit" class="btnsubmit" value="Login"/>
    </div>
</form>