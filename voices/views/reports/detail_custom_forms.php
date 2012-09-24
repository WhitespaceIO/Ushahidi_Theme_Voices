<?php if (count($form_field_names) > 0) { ?>
<?php
foreach ($form_field_names as $field_id => $field_property) {
    $value = $field_property['field_response'];
    if ($value == "") continue;
    echo '<div class="report-custom box">';
    if ($field_property['field_type'] == 1 OR $field_property['field_type'] == 1 OR $field_property['field_type'] > 3) {
        echo '<div class="report-label">'.html::specialchars($field_property['field_name']).'</div>';
        echo '<div class="report-value">';
        $regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $regex_email = "/([\s]*)[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
        if(preg_match($regex_url, $value, $url)) {
            echo preg_replace($regex_url, "<a href=\"{$url[0]}\">{$url[0]}</a> ", $value);
        }
        else if(preg_match($regex_email, $value, $email)) {
            echo preg_replace($regex_email, "<a href=\"mailto:{$email[0]}\">{$email[0]}</a> ", $value);
        }
        else {
            echo $value;
        }
        echo '</div>';
    }
    elseif ($field_property['field_type'] == 3) {
        echo '<div class="report-label">'.html::specialchars($field_property['field_name']).'</div>';
        echo '<div class="report-value">'.date('M d Y', strtotime($value)).'</div>';
    }
    echo '<div class="clear"></div>';
    echo '</div>';
}
?>
<?php } ?>