<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>
        <?php
            $categories = Kohana::config('settings.categories');
            $category = $categories[0];
            $category_title = null;
            $incident_title = null;
            if (isset($_GET["c"])) {
                $c = urldecode($_GET["c"]);
                foreach ($categories as $cat) {
                    if ($cat == $c) {
                        $category = $cat;
                        $category_title = $category->category_title;
                        break;
                    }
                }
            }
            else if (strpos($_SERVER['REQUEST_URI'],'/reports/view/') !== false) {
                $parts = explode('/', $_SERVER['REQUEST_URI']);
                $incident_id = end($parts);
                $incident = ORM::factory('incident', $incident_id);
                $incident_title = $incident->incident_title;
                foreach ($incident->category as $category) {
                    $category_title = $category->category_title;
                    break;
                }
            }
            if (isset($category_title)) {
                if (isset($incident_title)) {
                    echo $category_title . $incident_title . " | " . $site_name;
                }
                else {
                    echo $category_title . " | " . $site_name;
                }
            }
            else if (isset($category)) {
                echo $category->category_title . " | " . $site_name;
            }
            else {
                echo $page_title.$site_name;
            }
        ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
  <PageMap>
     <DataObject type="document">
        <Attribute name="title">YXE Voices</Attribute>
        <Attribute name="author">Whitespace.io & Deezine.ca</Attribute>
        <Attribute name="description">YXE Voices is a civic engagement platform to promote the sharing and discussion of ideas on ways to improve Saskatoon.</Attribute>
     </DataObject>
     <DataObject type="thumbnail">
        <Attribute name="src" value="http://yxevoices.com/themes/voices/screenshot.png" />
        <Attribute name="width" value="240" />
        <Attribute name="height" value="250" />
     </DataObject>
  </PageMap>
  -->
    <?php echo $header_block; ?>
    <?php
//        $css_url = url::file_loc('css');
//        $js_url = url::file_loc('js');
//        echo html::stylesheet($css_url."media/css/openlayers","",TRUE);
//        echo html::script($js_url."media/js/OpenLayers", TRUE);
//        echo "<script type=\"text/javascript\">OpenLayers.ImgPath = '".$js_url."media/img/openlayers/"."';</script>";
//        echo html::script($js_url."media/js/ushahidi", TRUE);
//        echo html::script($js_url."media/js/selectToUISlider.jQuery", TRUE);
//        echo html::script($js_url."media/js/jquery.jqplot.min");
//        echo html::script($js_url."media/js/jqplot.dateAxisRenderer.min");
    ?>
<!--    <script type="text/javascript">-->
<!--        --><?php //@require_once(APPPATH.'views/map_common_js.php'); ?>
<!--    </script>-->
    <?php Event::run('ushahidi_action.header_scripts'); ?>
    <script type="text/javascript">
        $(function(){
            $("#search-input").keyup(function(event){
                if(event.keyCode == 13){
                    $("#search").submit();
                    return false;
                }
            });
            //generateMap();
        });
        function generateMap(latitude, longitude, zoom) {
            if (latitude == null) {
                latitude = <?php echo Kohana::config('settings.default_lat'); ?>;
            }
            if (longitude == null) {
                longitude = <?php echo Kohana::config('settings.default_lon'); ?>;
            }
            if (zoom == null) {
                zoom = <?php echo Kohana::config('settings.default_zoom'); ?>;
            }
            if (map != null && 'destroy' in map) {
                map.destroy();
            }
            $('map').empty();
//            map = createMap('map', latitude, longitude, zoom);
//            for (var i = 0; i < map.controls.length; i++) {
//                map.removeControl(map.controls[i]);
//                map.controls[i].destroy();
//            }
            <?php echo map::layers_js(FALSE); ?>
            var config = {
                zoom: zoom,
                redrawOnZoom: true,
                center: {
                    latitude: latitude,
                    longitude: longitude
                },
                mapControls: [
                    new OpenLayers.Control.Navigation()
                ],
                baseLayers: <?php echo map::layers_array(FALSE); ?>,
                showProjection: false
            };
            map = new Ushahidi.Map('map', config);
            return map;
        }
    </script>
</head>
<body id="page">
<ul class="top left horizontal">
    <li id="header-logo">
        <?php if($banner == NULL) { ?>
            <a  class="box" title="<?php echo $site_tagline; ?>" href="<?php echo url::site();?>"><?php echo $site_name; ?></a>
        <?php } else { ?>
            <a title="<?php echo $site_name; ?>" href="<?php echo url::site(); ?>">
                <img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" />
            </a>
        <?php } ?>
    </li>
    <?php
        if ($category != null) {
            ?>
            <li id="header-question">
                <a class="box" title="<?php echo $category->category_title; ?>" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>"><?php echo $category->category_title; ?></a>
            </li>
            <?php } ?>
        <li id="header-add">
            <a class="box" title="Add Your Voice" href="<?php echo url::site(); ?>reports/submit?c=<?php echo $category; ?>"> </a>
        </li>
    </ul>

    <ul class="top right horizontal">
        <li id="header-list" class="box"><a title="List View" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>#list"> </a></li>
        <li id="header-map" class="box"><a title="Map View" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>#map"> </a></li>
        <li id="header-gallery" class="box"><a title="Gallery View" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>#gallery"> </a></li>
    </ul>

