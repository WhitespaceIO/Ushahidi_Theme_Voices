<div id="middle" >
    <div id="content">
        <div class="column">
            <h1><?php echo Kohana::lang('ui_main.alerts'); ?></h1>
            <?php if($show_mobile == TRUE): ?>
                <div class="alerts_confirm_mobile box">
                    <?php if ($alert_mobile): ?>
                        <?php echo "<h3>".Kohana::lang('alerts.mobile_ok_head')."</h3>"; ?>
                    <?php endif; ?>
                   <?php if ($alert_mobile) {
                            echo Kohana::lang('alerts.mobile_alert_request_created')."<u><strong>".
                                $alert_mobile."</strong></u>.".
                                Kohana::lang('alerts.verify_code');
                    } ?>
                    <?php print form::open('/alerts/verify'); ?>

                    <label><?php echo Kohana::lang('ui_main.verification'); ?></label>
                    <span><?php print form::input('alert_code', '',  ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.verification')) . '" '); ?></span><br/>

                    <label><?php echo Kohana::lang('ui_main.alerts_mobile_phone'); ?></label>
                    <span><?php print form::input('alert_mobile', $alert_mobile, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.alerts_mobile_phone')) . '" '); ?></span><br/>

                    <label></label>
                    <span><?php print form::submit('button', 'Confirm Alert Request', ' class="button"'); ?></span>
                    <?php print form::close(); ?>
                </div>
                <br/>
            <?php endif; ?>

            <div class="box">
                <?php
                if ($alert_email) {
                    echo "<h3>".Kohana::lang('alerts.email_ok_head')."</h3>";
                }
                ?>
                <?php
                if ($alert_email) {
                    echo Kohana::lang('alerts.email_alert_request_created')."<u><strong>".
                        $alert_email."</strong></u>.".
                        Kohana::lang('alerts.verify_code');
                }
                ?>
                <?php print form::open('/alerts/verify'); ?>

                <label><?php echo Kohana::lang('ui_main.verification'); ?></label>
                <span><?php print form::input('alert_code', '', ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.verification')) . '" '); ?></span><br/>

                <label><?php echo Kohana::lang('ui_main.email_address'); ?></label>
                <span><?php print form::input('alert_email', $alert_email, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.email_address')) . '" '); ?></span><br/>

                <label></label>
                <span><?php print form::submit('button', 'Confirm Alert Request', ' class="button"'); ?></span>
                <?php print form::close(); ?>
            </div>

            <br/>

            <div class="box confirm">
                <a href="<?php echo url::site().'alerts'?>"><?php echo Kohana::lang('alerts.create_more_alerts'); ?></a>
            </div>

        </div>
    </div>
</div>