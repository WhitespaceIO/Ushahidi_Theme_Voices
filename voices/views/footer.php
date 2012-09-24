<ul id="sources" class="bottom right horizontal">
    <li><a target="_blank" href="http://www.whitespace.io" title="Whitespace"><img id="whitespace" src="<?php echo url::site(); ?>themes/voices/images/whitespace.png"/></a></li>
    <li><a target="_blank" href="http://www.deezine.ca" title="Deezine"><img id="deezine" src="<?php echo url::site(); ?>themes/voices/images/deezine.png"/></a></li>
    <li><a target="_blank" href="http://www.ushahidi.com" title="Ushahidi"><img id="ushahidi" src="<?php echo url::site(); ?>themes/voices/images/ushahidi.png"/></a></li>
</ul>

<ul id="links" class="bottom left horizontal">
    <?php if (Kohana::config('settings.user_id') != NULL) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_admin.logout');?>" href="<?php echo url::site()."logout/front";?>"><?php echo Kohana::lang('ui_admin.logout');?></a></li>
    <?php } else { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.login'); ?>" href="<?php echo url::site()."login";?>"><?php echo Kohana::lang('ui_main.login'); ?></a></li>
    <?php } ?>
    <?php if (Kohana::config('settings.user_id') != NULL) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.public_profile'); ?>" href="<?php echo url::site() . "profile/user/" . Kohana::config('settings.user_username') ;?>">
        Profile</a></li>
    <?php } ?>
    <?php if(Kohana::config('settings.allow_alerts')) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.alerts'); ?>" href="<?php echo url::site()."alerts"; ?>">Alerts</a></li>
    <?php } ?>
    <?php if(Kohana::config('settings.site_contact_page')) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.contact'); ?>" href="<?php echo url::site()."contact"; ?>">Contact</a></li>
    <?php } ?>
    <?php foreach (ORM::factory('page')->where('page_active', '1')->find_all() as $page) { ?>
        <li class="box"><a title="<?php echo $page->page_tab; ?>" href="<?php echo url::site()."page/index/".$page->id; ?>"><?php echo $page->page_tab; ?></a></li>
    <?php }?>
    <?php if (ORM::factory('feed_item')->find_all()->count() > 0) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.news'); ?>" href="<?php echo url::site(); ?>feeds/"><?php echo Kohana::lang('ui_main.news'); ?></a></li>
    <?php }?>
    <?php if(Kohana::config('settings.allow_feed')) { ?>
        <li class="box"><a title="<?php echo Kohana::lang('ui_main.rss'); ?>" href="<?php echo url::site(); ?>feed/"><?php echo Kohana::lang('ui_main.rss'); ?></a></li>
    <?php }?>
    <li class="box">
        <form action="<?php echo url::site(); ?>search" method="get" id="search">
            <input id="search-input" type="text" name="k" value="<?php echo isset($_GET["k"]) ? urldecode($_GET["k"]) : ''; ?>" class="text" placeholder="Search...">
        </form>
    </li>
</ul>

<?php echo $footer_block; ?>
<div id="map"></div>
<?php Event::run('ushahidi_action.main_footer'); ?>
</body>
</html>