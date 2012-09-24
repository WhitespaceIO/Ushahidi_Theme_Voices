<div class="map-holder" id="divMap"></div>
<div class="alert-slider">
    <select name="alert_radius" id="alert_radius" style="visibility:hidden;">
        <option value="1">1 KM</option>
        <option value="5">5 KM</option>
        <option value="10">10 KM</option>
        <option value="20" selected="selected">20 KM</option>
        <option value="50">50 KM</option>
        <option value="100">100 KM</option>
    </select>
</div>
<?php if ($enable_find_location): ?>
<div class="location-left">
    <div>
        <?php print form::input('location_find', '', ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.find_location')) . '" '); ?>
    </div>
</div>
<div class="location-right">
    <input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find button" />
    <div id="find_loading" class="report-find-loading"></div>
</div>
<div class="clear"></div>
<?php endif; ?>