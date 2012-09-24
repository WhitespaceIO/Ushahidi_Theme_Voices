<div class="below center">
    <div class="report-main box">
        <?php
        $category = null;
        $icon = null;
        foreach($incident_category as $cat){
            $category = $cat->category;
            if ($cat->category->category_image_thumb) {
                $icon = url::base().Kohana::config('upload.relative_directory')."/".$cat->category->category_image_thumb;
            }
        }
        $page_title_new = $category->category_title . $incident_title;
        ?>
        <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>"> </a>
        <div class="report-votes">
            <?php
            $title = $category->category_title . $incident_title;
            $description =  $category->category_description . $incident_description;
            $url = url::site() . "reports/view/" . $incident_id;
            $tweet = $title . " #yxe";
            ?>
            <ul class="vertical share">
                <li>
                    <iframe src="https://platform.twitter.com/widgets/tweet_button.html?text=<?php echo rawurlencode($tweet); ?>"
                            allowtransparency="true" frameborder="0" scrolling="no" style="border:none;width:100px;height:20px;"></iframe>
                </li>
                <li>
                    <iframe src="http://www.facebook.com/widgets/like.php?href=<?php echo rawurlencode($url); ?>&layout=button_count&data-show-faces=false"
                            allowtransparency="true" frameborder="0" scrolling="no" style="border:none;width:100px;height:20px"></iframe>
                </li>
                <li>
                    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                    <div class="g-plusone" data-size="medium" style="width:100px;height:20px;"></div>
                </li>
            </ul>
            <ul class="vertical vote">
                <li class="vote-up"><a title="Vote Up" href="javascript:vote('<?php echo $incident_id; ?>','add','original','vote-<?php echo $incident_id; ?>')"></a></li>
                <li class="vote-value" id="vote-<?php echo $incident_id; ?>"><?php echo $incident_rating; ?></li>
                <li class="vote-down"><a title="Vote Down" href="javascript:vote('<?php echo $incident_id; ?>','subtract','original','vote-<?php echo $incident_id; ?>')"></a></li>
            </ul>
        </div>

        <div class="report-primary">
            <span class="report-question"><?php echo $category->category_title; ?></span>
            <span class="report-answer"><?php echo $incident_title; ?></span>
        </div>
        <br/>

        <div class="report-secondary">
            <span class="report-question"><?php echo $category->category_description; ?></span>
            <span class="report-answer"><?php echo $incident_description; ?></span>
        </div>
    </div>

    <div class="report-about box">
        <div class="report-label"><?php echo $incident_location; ?></div>
        <div class="report-value"><?php echo date('F j, Y', strtotime($incident_date)); ?></div>
    </div>

    <?php foreach( $incident_news as $incident_new) { ?>
    <div class="report-custom box">
        <div class="report-label">
            <?php echo Kohana::lang('ui_main.url');?>
        </div>
        <div class="report-value">
            <a href="<?php echo $incident_new; ?> " target="_blank">
                <?php echo $incident_new;?>
            </a>
        </div>
        <div class="clear"></div>
    </div>
    <?php } ?>

    <?php if(strlen($custom_forms) > 0) { ?>
    <div class="report-extras">
        <?php Event::run('ushahidi_action.report-extra', $incident_id); ?>
        <?php echo $custom_forms; ?>
    </div>
    <?php } ?>

    <?php Event::run('ushahidi_action.report-display-media', $incident_id); ?>

    <div class="box report-media <?php if(count($incident_photos) == 0){ echo "hidden";}?>">
        <?php
        if(count($incident_photos) > 0) {
            foreach ($incident_photos as $photo) {
                echo '<div class="report-media-image"><a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img src="'.$photo['large'].'"/></a></div>';
            };
        }
        ?>
        <div class="clear"></div>
    </div>

    <div class="box report-media <?php if(count($incident_videos) == 0){ echo "hidden";}?>">
        <?php
        if(count($incident_videos) > 0 ){
            foreach( $incident_videos as $incident_video) {
                $videos_embed->embed($incident_video,'');
            };
        }
        ?>
    </div>

    <?php Event::run('ushahidi_filter.comment_block', $comments); ?>
    <?php if(isset($comments) && count($comments) > 0 && trim($comments) !== ''){ ?>
    <div class="report-comments">
        <?php echo $comments; ?>
    </div>
    <?php } ?>

    <?php if (Kohana::config('settings.allow_comments') ) { ?>
    <div class="report-comment-form">
        <?php Event::run('ushahidi_filter.comment_form_block', $comments_form); ?>
        <?php echo $comments_form; ?>
    </div>
    <?php } ?>
</div>

<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site(),
            'reports' => Kohana::lang('ui_main.reports'),
            'checkins' => Kohana::lang('ui_admin.checkins'))); ?>;
    $(function(){
        $(window).resize(function() {
            adjustThumbnails();
        });
        //loadFacebook(document);
        adjustThumbnails();
        addReport(<?php echo $incident_latitude; ?>, <?php echo $incident_longitude; ?>, 17, '<?php echo $icon; ?>');
    });
    function loadFacebook(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        ref.parentNode.insertBefore(js, ref);
    }
    function adjustThumbnails() {
        $('.report-media-image').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report-media object').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
        $('.report-media object embed').each(function() {
            var width = $(this).width();
            $(this).height(width*0.65);
            $(this).css("height", width*0.65);
            $(this).css("minHeight", width*0.65);
            $(this).css("maxHeight", width*0.65);
        });
    }
    function addReport(latitude, longitude, zoom, icon) {
        map = createMap('map', latitude, longitude, zoom);
        for (var i = 0; i < map.controls.length; i++) {
            map.removeControl(map.controls[i]);
            map.controls[i].destroy();
        }
        var externalGraphic = null;
        if (icon) {
            externalGraphic = icon;
        }
        else {
            externalGraphic = $PHRASES.server + "themes/voices/images/report_red.png";
        }
        var styleMap = new OpenLayers.StyleMap({
            "default": new OpenLayers.Style({
                cursor: "pointer",
                graphicOpacity: 0.9,
                graphicWidth: 40,
                graphicHeight: 40,
                externalGraphic: externalGraphic
            })
        });
        var reportLayer = new OpenLayers.Layer.Vector($PHRASES.reports, {styleMap: styleMap});
        map.addLayers([reportLayer]);
        var proj_4326 = new OpenLayers.Projection('EPSG:4326');
        var proj_900913 = new OpenLayers.Projection('EPSG:900913');
        var reportPoint = new OpenLayers.Geometry.Point(parseFloat(longitude), parseFloat(latitude));
        reportPoint.transform(proj_4326, proj_900913);
        var reportVector = new OpenLayers.Feature.Vector(reportPoint, {});
        reportLayer.addFeatures([reportVector]);
    }
</script>