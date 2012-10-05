<div class="below center">
    <div class="box">
        <?php
        foreach ($categories as $cat) {
            if ($cat == urldecode($_GET["c"])) {
                $category = $cat;
            }
        }
        if (!isset($category)) {
            $category = $categories[0];
        }
        ?>
        <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>#list"> </a>
        <?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms', 'onSubmit' => 'return validateFields();')); ?>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
        <input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
        <input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />
        <input type="hidden" name="incident_category[]" id="incident_category[]" value="<?php echo $category; ?>" />
        <input type="hidden" name="incident_date" id="incident_date" value="<?php echo date("m/d/Y"); ?>" />
        <input type="hidden" name="incident_hour" id="incident_hour" value="<?php echo date("g"); ?>" />
        <input type="hidden" name="incident_minute" id="incident_minute" value="<?php echo date("i"); ?>" />
        <input type="hidden" name="incident_ampm" id="incident_ampm" value="<?php echo date("a"); ?>" />
        <fieldset>
            <label><span class="required">*</span><?php echo $category->category_title; ?></label>
            <span><?php print form::input('incident_title', $form['incident_title'], ' class="text" placeholder="describe your idea." '); ?></span>
        </fieldset>
        <fieldset>
            <label><span class="required">*</span><?php echo $category->category_description; ?></label>
            <span><?php print form::textarea('incident_description', $form['incident_description'], ' class="text" placeholder="explain your reasoning." ') ?></span>
        </fieldset>
        <fieldset>
            <label><span class="required">*</span>Location...</label>
            <div id="submit-map">
                <div id="divMap" class="report-map"></div>
            </div>
        </fieldset>
        <fieldset>
            <label><span class="required">*</span>Name...</label>
            <span><?php print form::input('location_name', $form['location_name'], ' class="text" placeholder="enter your name" '); ?></span>
        </fieldset>
        <fieldset id="submit-photo">
            <label>Photos...</label>
            <?php
            $this_parent = "submit-photo";
            $this_field = "incident_photo";
            $this_start = "photo_id";
            $this_type = "file";
            if (empty($form[$this_field]['name'][0])) {
                $i = 1;
                print "<span class=\"dynamic\">";
                print form::upload($this_field . '[]', '', ' class="file"');
                print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                print "</span>";
            }
            else {
                $i = 0;
                foreach ($form[$this_field]['name'] as $value) {
                    print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                    print form::upload($this_field . '[]', $value, ' class="file long2"');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    if ($i != 0)
                    {
                        print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                    }
                    print "</span>\n";
                    $i++;
                }
            }
            print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
            ?>
        </fieldset>
        <fieldset id="submit-video">
            <label>Videos...</label>
            <?php
            $this_parent = "submit-video";
            $this_field = "incident_video";
            $this_start = "video_id";
            $this_type = "text";
            if (empty($form[$this_field])) {
                $i = 1;
                print "<span class=\"dynamic\">";
                print form::input($this_field . '[]', '', ' class="text" placeholder="address of a video clip" ');
                print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                print "</span>";
            }
            else {
                $i = 0;
                foreach ($form[$this_field] as $value) {
                    print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                    print form::input($this_field . '[]', $value, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    if ($i != 0) {
                        print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); removeFormField(\"#label_" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                    }
                    print "</span>\n";
                    $i++;
                }
            }
            print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
            ?>
        </fieldset>
        <fieldset id="submit-news">
            <label>Links...</label>
            <?php
            $this_parent = "submit-news";
            $this_field = "incident_news";
            $this_start = "news_id";
            $this_type = "text";
            if (empty($form[$this_field])) {
                $i = 1;
                print "<span class=\"dynamic\">";
                print form::input($this_field . '[]', '', ' class="text" placeholder="address of a webpage" ');
                print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                print "</span>";
            }
            else {
                $i = 0;
                foreach ($form[$this_field] as $value) {
                    print "<label id=\"label_$i\"></label><span id=\"$i\" class=\"dynamic\">\n";
                    print form::input($this_field . '[]', $value, ' class="text" placeholder="' . strtolower(Kohana::lang('ui_main.url')) . '" ');
                    print "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('$this_parent','$this_field','$this_start','$this_type'); return false;\">+</a>";
                    if ($i != 0) {
                        print "<a href=\"#\" class=\"button dynamic-remove\" onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); removeFormField(\"#label_" . $this_field . "_" . $i . "\"); return false;'>-</a>";
                    }
                    print "</span>\n";
                    $i++;
                }
            }
            print "<input type=\"hidden\" name=\"$this_start\" value=\"$i\" id=\"$this_start\">";
            ?>
        </fieldset>
        <fieldset>
            <label> </label>
            <span><input name="submit" type="submit" class="button" value="Add Your Voice" /></span>
        </fieldset>
    </div>
    <?php if ($form_error): ?>
    <?php
    foreach ($errors as $error_item => $error_description) {
        print (!$error_description) ? '' : "<div class='box red shadow'><h3>" . $error_description . "</h3></div>";
    }
    ?>
    <?php endif; ?>
    <?php if ($site_submit_report_message != ''): ?>
    <br/>
    <div class="box shadow submit-message">
        <?php echo $site_submit_report_message; ?>
    </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
    function getParameter(name) {
        return decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
    }
    function addFormField(parent, field, hidden, type) {
        var id = document.getElementById(hidden).value;
        $("#" + parent).append("<label id=\"label_" + field + "_" + id + "\"></label><span class=\"dynamic\" id=\"" + field + "_" + id + "\">" +
            "<input type=\"" + type + "\" name=\"" + field + "[]\" class=\"" + type + " \" />" +
            "<a href=\"#\" class=\"button dynamic-add\" onClick=\"addFormField('" + parent + "','" + field + "','" + hidden + "','" + type + "'); return false;\">+</a>" +
            "<a href=\"#\" class=\"button dynamic-remove\"  onClick='removeFormField(\"#" + field + "_" + id + "\"); removeFormField(\"#label_" + field + "_" + id + "\");return false;'>-</a></span>");
        id = (id - 1) + 2;
        document.getElementById(hidden).value = id;
    }
    function removeFormField(id) {
        $(id).remove();
    }
    function validateFields() {
        var isValid = true;
        $("#incident_title, #incident_description, #location_name").each(function() {
            if ($(this).val() == '') {
                $(this).css("border-color", "#F5A9BC");
                $(this).css("background-color", "#FBEFF2");
                isValid = false;
            }
        });
        return isValid;
    }
</script>
