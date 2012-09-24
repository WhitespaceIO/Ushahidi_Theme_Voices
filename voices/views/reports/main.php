<div id="reports">
    <?php echo $report_listing_view; ?>
</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site(),
              'reports' => Kohana::lang('ui_main.reports'),
              'checkins' => Kohana::lang('ui_admin.checkins'))); ?>;
    $(function(){
        $(window).resize(function() {
            splitListView();
        });
        $(document).ready(function() {
            loadSelectedView();
            addReportViewEvents();
        });
    });
<?php
    $layers = array();
    foreach (ORM::factory('layer')->where('layer_visible', 1)->find_all() as $layer) {
        $lay = array();
        $lay['id'] = $layer->id;
        $lay['name'] = $layer->layer_name;
        $lay['color'] = $layer->layer_color;
        if ($layer->layer_url) {
            $lay['url'] = $layer->layer_url;
        }
        else {
            $lay['url'] = url::convert_uploaded_to_abs($layer->layer_file);
        }
        array_push($layers, $lay);
    } ?>
    var $LAYERS = <?php echo json_encode($layers); ?>;
</script>