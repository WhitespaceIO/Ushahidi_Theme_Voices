<div class="below center">
    <div class="box">
        <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports"> </a>
        <div class="profile-picture">
            <h2><?php echo $user->name; ?></h2>
            <div><img src="<?php echo members::gravatar($user->email,125); ?>" width="125" height="125" /></div>
            <?php if($logged_in_user){ ?>
            <div><?php echo Kohana::lang('ui_main.this_is_your_profile'); ?><br/><a href="<?php echo url::site();?>members/"><?php echo Kohana::lang('ui_main.manage_your_account'); ?></a></div>
            <?php }else{ ?>
            <div><?php echo Kohana::lang('ui_main.is_this_your_profile'); ?>
                <?php if($logged_in_id){ ?>
                    <a href="<?php echo url::site();?>logout/front"><?php echo Kohana::lang('ui_admin.logout');?></a>
                    <?php }else{ ?>
                    <a href="<?php echo url::site();?>members/"><?php echo Kohana::lang('ui_main.login'); ?></a>
                    <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="profile-details">
            <div>
                <?php if(count($reports) > 0) { ?>
                    <?php foreach($reports as $report) { ?>
                        <a href="<?php echo url::site();?>reports/view/<?php echo $report->id;?>">

                        <span class="report-question">
                            <?php foreach($report->category as $category){
                                echo $category->category_title;
                                break;
                            } ?>
                        </span>
                        <span class="report-answer">
                            <?php echo $report->incident_title; ?>
                        </span>
                        <span class="report-timestamp">
                            - <?php echo date('g:ia, F j', strtotime($report->incident_date)); ?>
                        </span>
                        </a>
                        <br/>
                    <?php } ?>
                <?php } else { ?>
                    <br/>
                     <h3>Has not shared any ideas.</h3>
                <?php } ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
</script>
