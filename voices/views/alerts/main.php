<div class="below center">
    <div id="content">
        <h1><?php echo Kohana::lang('ui_main.alerts_get'); ?></h1>
        <?php print form::open() ?>
        <div class="column">
            <?php if ($form_error): ?>
            <div class="box red-box">
                <h3><?php echo Kohana::lang('ui_main.error'); ?></h3>
                <ul>
                    <?php
                    foreach ($errors as $error_item => $error_description) {
                        print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="alerts-step box">
                <div>
                    <h3><?php echo Kohana::lang('ui_main.alerts_step1_select_city'); ?></h3>
                    <?php echo $alert_radius_view; ?>
                </div>
                <input type="hidden" id="alert_lat" name="alert_lat" value="<?php echo $form['alert_lat']; ?>">
                <input type="hidden" id="alert_lon" name="alert_lon" value="<?php echo $form['alert_lon']; ?>">
                <input type="hidden" id="alert_country" name="alert_country" value="<?php echo $form['alert_country']; ?>" />
                <input type="hidden" id="alert_confirmed" name="alert_confirmed" value="<?php echo $form['alert_confirmed']; ?>" />
            </div>
        </div>
        <div class="column">
            <div class="alerts-step box">
                <h3><?php echo Kohana::lang('ui_main.alerts_step2_send_alerts'); ?></h3>
                <?php if ($show_mobile == TRUE): ?>
                    <label for="alert_mobile">
                        <?php $checked = ($form['alert_mobile_yes'] == 1); ?>
                        <?php print form::checkbox('alert_mobile_yes', '1', $checked); ?>
                        <?php echo Kohana::lang('ui_main.alerts_mobile_phone'); ?>
                    </label>
                    <span><?php print form::input('alert_mobile', $form['alert_mobile'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.alerts_mobile_phone')) . '" '); ?></span>
                    <br/>
                <?php endif; ?>
                <label for="alert_email">
                    <?php $checked = ($form['alert_email_yes'] == 1) ?>
                    <?php print form::checkbox('alert_email_yes', '1', $checked); ?>
                    <?php echo Kohana::lang('ui_main.alerts_email'); ?>
                </label>
                <span><?php print form::input('alert_email', $form['alert_email'], ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.alerts_email')) . '" '); ?></span>
            </div>
            <div class="alerts-step box">
                <h3><?php echo Kohana::lang('ui_main.alerts_step3_select_catgories'); ?></h3>
                <div class="holder">
                    <?php foreach ($categories as $category): ?>
                        <?php if($category->category_visible == 1) { ?>
                            <ul class="horizontal">
                                <li class="parent">
                                    <?php print form::checkbox('alert_category[]', $category->id, false); ?>
                                    <?php echo $category->category_title; ?>
                                </li>
                                <?php foreach ($category->children as $child) { ?>
                                    <li>
                                        <?php print form::checkbox('alert_category[]', $child->id, false); ?>
                                        <?php echo $child->category_title; ?>
                                    </li>
                                <?php }  ?>
                            </ul>
                        <?php } ?>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="alerts-step box">
                <input id="btn-send-alerts" class="button" type="submit" value="<?php echo Kohana::lang('ui_main.alerts_btn_send'); ?>" />
            </div>

            <div class="alerts-step box confirm">
                <a href="<?php echo url::site()."alerts/confirm";?>"><?php echo Kohana::lang('ui_main.alert_confirm_previous'); ?></a>
            </div>
        </div>
        <?php print form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
</script>