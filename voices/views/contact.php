<div class="below center">
    <div id="content">
        <div>
            <?php
            if ($form_error) {
                ?>
                <!-- red-box -->
                <div class="red-box">
                    <h3>Error!</h3>
                    <ul>
                        <?php
                        foreach ($errors as $error_item => $error_description)
                        {
                            print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            if ($form_sent) {  ?>
                <!-- green-box -->
                <div class="box green">
                    <h3><?php echo Kohana::lang('ui_main.contact_message_has_send'); ?></h3>
                </div>
                <?php
            }
            ?>
            <div class="box">
                <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports"> </a>
                <h1><?php echo Kohana::lang('ui_main.contact'); ?></h1>
                <?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>

                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_name'); ?></label>
                <span><?php print form::input('contact_name', $form['contact_name'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.contact_name')) . '" '); ?></span>
                </fieldset>


                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_email'); ?></label>
                <span><?php print form::input('contact_email', $form['contact_email'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.contact_email')) . '" '); ?></span>
                </fieldset>

                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_phone'); ?></label>
                <span><?php print form::input('contact_phone', $form['contact_phone'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.contact_phone')) . '" '); ?></span>
                </fieldset>

                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_subject'); ?></label>
                <span><?php print form::input('contact_subject', $form['contact_subject'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.contact_subject')) . '" '); ?></span>
                </fieldset>

                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_message'); ?></label>
                <span><?php print form::input('contact_message', $form['contact_message'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.contact_message')) . '" ') ?></span>
                </fieldset>

                <fieldset>
                <label><?php echo Kohana::lang('ui_main.contact_code'); ?></label>
                <span class="captcha"><?php print form::input('captcha', $form['captcha'], ' class="text" placeholder="' . $captcha->render() . '" '); ?></span>
                </fieldset>

                <fieldset>
                <label> </label>
                <span><input  name="submit" type="submit" class="button" type=button value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" /></span>
                </fieldset>

                <?php print form::close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
</script>