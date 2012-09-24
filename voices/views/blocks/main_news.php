<div id="main-news" class="column">
    <div class="box">
        <h3><?php echo Kohana::lang('ui_main.news'); ?></h3>
        <ul>
         <?php if ($feeds->count() == 0) { ?>
                <li><?php echo Kohana::lang('ui_main.no'); ?> <?php echo Kohana::lang('ui_main.news'); ?></li>
         <?php } else {
                foreach ($feeds as $feed) {
                    $feed_id = $feed->id;
                    $feed_title = $feed->item_title;
                    $feed_link = $feed->item_link;
                    $feed_source = $feed->feed->feed_name;
                    $feed_description = $feed->item_description;
                    ?>
                <li>
                    <a title="<?php echo $feed_description; ?>" href="<?php echo $feed_link; ?>" target="_blank"><?php echo $feed_title; ?></a>
                    <span class="main-news-source">(<?php echo $feed_source; ?>)</span>
                </li>
                <?php } ?>
                <li class="more">
                    <a title="<?php echo Kohana::lang('ui_main.view_more'); ?>" href="<?php echo url::site() . 'feeds'; ?>">
                        <?php echo Kohana::lang('ui_main.view_more'); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>