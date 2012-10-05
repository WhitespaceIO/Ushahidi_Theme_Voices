<div id="reports">
    <div id="list" style="display:none;" class="below left right">
        <?php
            $comments = Kohana::config('settings.comments');
            $ratings = Kohana::config('settings.ratings');
            $incidentIndex = 0;
            foreach ($incidents as $incident) {
                $incidentIndex += 1;
                $incident = ORM::factory('incident', $incident->incident_id);
                $incident_id = $incident->id;
                $incident_sort = "" . $incidentIndex;
                $incident_time = date('g:ia', strtotime($incident->incident_date));
                $incident_date = date('F j, Y', strtotime($incident->incident_date));
                $incident_title = $incident->incident_title;
                $incident_description = $incident->incident_description;
                $location_name = $incident->location->location_name;
                $incident_thumb = null;
                $incident_comments = 0;
                if ($comments != null && count($comments) > 0) {
                    foreach ($comments as $comment) {
                        if ($incident->id == $comment->incident_id) {
                            $incident_comments += 1;
                        }
                    }
                }
                $incident_ratings = 0;
                $incident_rating = 0;
                if ($ratings != null && count($ratings) > 0) {
                    foreach ($ratings as $rating) {
                        if ($incident->id == $rating->incident_id) {
                            $incident_ratings += 1;
                            $incident_rating += $rating->rating;
                        }
                    }
                }
                if ($incident->media->count()) {
                    foreach ($incident->media as $photo) {
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
                            break;
                        }
                    }
                }
                $category_title = null;
                $category_description = null;
                foreach ($incident->category as $category) {
                    $category_title = $category->category_title;
                    $category_description = $category->category_description;
                    break;
                }
                $incident_tooltip = $category_description . $incident_description;
                $user_tooltip = $location_name . " on " . $incident_date;
            ?>
            <div class="report-item" title="<?php echo $incident_sort; ?>">
                <div class="box bubble">
                    <ul class="vertical vote">
                        <li class="vote-up"><a title="Vote Up" href="javascript:vote('<?php echo $incident_id; ?>','add','original','vote-<?php echo $incident_id; ?>')"></a></li>
                        <li class="vote-value" id="vote-<?php echo $incident_id; ?>"><?php echo $incident_rating; ?></li>
                        <li class="vote-down"><a title="Vote Down" href="javascript:vote('<?php echo $incident_id; ?>','subtract','original','vote-<?php echo $incident_id; ?>')"></a></li>
                    </ul>
                    <?php if (!empty($incident_thumb)) { ?>
                        <a title="<?php echo $incident_tooltip; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                            <img class="report-image" src="<?php echo $incident_thumb; ?>" />
                        </a>
                    <?php }?>
                    <div class="report-primary">
                        <a title="<?php echo $incident_tooltip; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                            <span class="report-question"><?php echo $category_title; ?></span>
                            <span class="report-answer"><?php echo $incident_title; ?></span>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="report-author">
                    <a class="box" title="<?php echo $user_tooltip; ?>" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                        <?php echo $location_name; ?>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
        <?php } ?>
    </div>
    <div id="gallery" style="display:none;" class="below left right">
        <div id="content">
            <?php
            $thumbnails = 0;
            foreach ($incidents as $incident) {
                $incident = ORM::factory('incident', $incident->incident_id);
                $incident_id = $incident->id;
                $incident_title = $incident->incident_title;
                $incident_description = $incident->incident_description;
                $category_title = null;
                $category_description = null;
                foreach ($incident->category as $category) {
                    $category_title = $category->category_title;
                    $category_description = $category->category_description;
                    break;
                }
                $incident_tooltip = $category_title . '&#13;' . strip_tags(str_replace('<br/>', '&#13;', $incident_title));
                if ($incident->media->count()) {
                    foreach ($incident->media as $photo) {
                        if ($photo->media_thumb) {
                            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
                            $thumbnails++;
                        ?>
                            <div class="report-thumbnail shadow">
                                <div class="report-thumbnail-frame">
                                    <a title="<?php echo $incident_tooltip; ?>"
                                       href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>">
                                        <img src="<?php echo $incident_thumb; ?>" />
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                    }
                }
            }
            if ($thumbnails == 0) {
                echo "<div class='report-no-thumbnails'>No photos</div>";
            }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
<?php
    $reports = array();
    foreach ($incidents as $incident) {
        $incident = ORM::factory('incident', $incident->incident_id);
        $item = array();
        $item['id'] = $incident->id;
        $item['time'] = date('g:ia', strtotime($incident->incident_date));
        $item['date'] = date('F j', strtotime($incident->incident_date));
        $item['link'] = url::site().'reports/view/'.$incident->id;
        $item['title'] = $incident->incident_title;
        $item['description'] = $incident->incident_description;
        $item['location'] = $incident->location->location_name;
        $item['latitude'] = $incident->location->latitude;
        $item['longitude'] = $incident->location->longitude;
        $item['comments'] = 0;
        if ($comments != null && count($comments) > 0) {
            foreach ($comments as $comment) {
                if ($incident->id == $comment->incident_id) {
                    $item['comments'] += 1;
                }
            }
        }
        $item['ratings'] = 0;
        $item['rating'] = 0;
        if ($ratings != null && count($ratings) > 0) {
            foreach ($ratings as $rating) {
                if ($incident->id == $rating->incident_id) {
                    $item['ratings'] += 1;
                    $item['rating'] += $rating->rating;
                }
            }
        }
        if ($incident->media->count()) {
            foreach ($incident->media as $media) {
                if ($media->media_thumb) {
                    $item['thumb'] = url::convert_uploaded_to_abs($media->media_thumb);
                    break;
                }
            }
            $photos = array();
            foreach ($incident->media as $media) {
                $photo = array();
                if ($media->media_thumb) {
                    $photo['thumb'] = $media->media_thumb;
                }
                if ($media->media_link) {
                    $photo['large'] = $media->media_link;
                }
                array_push($photos, $photo);
            }
            $item['photos'] = $photos;
        }
        $categories = array();
        foreach ($incident->category as $category) {
            $cat = array();
            $cat['id'] = $category->id;
            $cat['title'] = $category->category_title;
            $cat['color'] = "#".$category->category_color;
            $cat['description'] = $category->category_description;
            if ($category->category_image_thumb) {
                $cat['image'] = url::convert_uploaded_to_abs($category->category_image);
                $cat['thumb'] = url::convert_uploaded_to_abs($category->category_image_thumb);
                $item['icon'] = url::convert_uploaded_to_abs($category->category_image);
            }
            array_push($categories, $cat);
        }
        $item['categories'] = $categories;
        array_push($reports, $item);
    }
?>
    var $INCIDENTS = <?php echo json_encode($reports); ?>;
</script>
