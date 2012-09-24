<div id="middle" class="scroll">
    <div id="content">
        <h3><?php echo Kohana::lang('ui_main.news'); ?></h3>
        <?php
        foreach ($feeds as $feed) {
            $feed_id = $feed->id;
            $feed_title = $feed->item_title;
            $feed_description = $feed->item_description;
            $feed_link = $feed->item_link;
            $feed_date = date('M j Y', strtotime($feed->item_date));
            $feed_source = $feed->feed->feed_name;
            print "<div class=\"box feed-item\">";
            print " <div class=\"feed-title\"><a target=\"_blank\" title=\"" . $feed_title . "\" href=\"$feed_link\">" . $feed_title . "</a></div>";
            print " <div class=\"feed-source\">" . $feed_source . "</div>";
            print " <div class=\"feed-description\">" . $feed_description . "</div>";
            print "<div class=\"clearfix\"></div>";
            print "</div>";
        }
        ?>
        <?php echo $pagination; ?>
    </div>
</div>