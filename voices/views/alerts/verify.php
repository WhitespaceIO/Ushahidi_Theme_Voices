<div id="middle" class="scroll">
    <div id="content">
        <div class="content-bg">
            <div class="big-block">
                <h1><?php echo Kohana::lang('ui_main.alerts_get') ?></h1>
                <?php
                switch ($errno)
                {
                    // IF the code provided was not found ...
                    case ER_CODE_NOT_FOUND:
                        ?>
                            <div class="red-box">
                                <h3><?php echo Kohana::lang('alerts.code_not_found'); ?></h3>
                            </div>
                            <?php
                        break;
                    // IF the code provided means the alert has already been verified ...
                    case ER_CODE_ALREADY_VERIFIED:
                        ?>
                            <div class="red-box">
                                <h3><?php echo Kohana::lang('alerts.code_already_verified'); ?></h3>
                            </div>
                            <?php
                        break;
                    // IF the code provided means the code is now verified ...
                    case ER_CODE_VERIFIED:
                        ?>
                            <div class="green-box">
                                <h3><?php echo Kohana::lang('alerts.code_verified'); ?></h3>
                            </div>
                            <?php
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>
