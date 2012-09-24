<div class="below center">
    <div class="box">
        <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports"> </a>
        <div class="page-title"><?php echo $page_title ?></div>
        <div class="page-text"><?php
            echo htmlspecialchars_decode($page_description);
            Event::run('ushahidi_action.page_extra', $page_id);
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
</script>