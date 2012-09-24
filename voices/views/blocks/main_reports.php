<div id="main-reports" class="column">
    <div class="box">
        <?php if (Kohana::config('settings.checkins')) { ?>
            <h3><?php echo Kohana::lang('ui_admin.checkins'); ?></h3>
            <ul></ul>
        <?php } else { ?>
            <h3><?php echo Kohana::lang('ui_main.reports'); ?></h3>
            <ul>
            <?php
            if ($total_items == 0) {
                ?>
                <li><?php echo Kohana::lang('ui_main.no_reports'); ?></li>
                <?php
            }
            foreach ($incidents as $incident) {
                $incident_id = $incident->id;
                $incident_title = $incident->incident_title;
                $incident_description = strip_tags($incident->incident_description);
                $location_id = $incident->location->id;
                $location_name = $incident->location->location_name;
                ?>
                <li>
                    <a title="<?php echo $incident_description; ?>" href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>">
                        <?php echo $incident_title; ?>
                    </a>
                    <span>(<?php echo $location_name; ?>)</span>
                </li>
            <?php } ?>
            <?php if ($total_items > 0) { ?>
            <li class="more">
                <a href="<?php echo url::site() . 'reports/'; ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
            </li>
            <?php } ?>
            </ul>
        <?php } ?>
        <div class="clear"></div>
    </div>
</div>