<div class="below center">
    <?php if(trim(Kohana::config('settings.site_message')) != '') { ?>
    <div id="main-welcome" class="box">
        <?php echo Kohana::config('settings.site_message'); ?>
    </div>
    <?php } ?>
    <?php
    $questions = 3;
    $answers = 3;
    $categories = Kohana::config('settings.categories');
    $incidents = Kohana::config('settings.incidents');
    $comments = Kohana::config('settings.comments');
    $ratings = Kohana::config('settings.ratings');
    function show_voices($category, $incidents) {
        $number = 0;
        foreach ($incidents as $voice) {
            if ($category == $voice->category_id) {
                $number++;
            }
        }
        if ($number == 1) {
            echo "1 voice ";
        }
        else {
            echo $number . " voices ";
        }
    }
    function show_comments($category, $comments) {
        $number = 0;
        foreach ($comments as $comment) {
            if ($category == $comment->category_id) {
                $number++;
            }
        }
        if ($number == 1) {
            echo "1 comment ";
        }
        else {
            echo $number . " comments ";
        }
    }
    function show_votes($category, $ratings) {
        $number = 0;
        foreach ($ratings as $rating) {
            if ($category == $rating->category_id) {
                $number++;
            }
        }
        if ($number == 1) {
            echo "1 vote ";
        }
        else {
            echo $number . " votes ";
        }
    }
    echo "<div id='main-categories'>";
    for ($i = 0; $i < count($categories); $i++) {
        $category = $categories[$i];
        if ($i < $questions) {
            echo "<div class='box main-category'>";

            echo "<div class='main-add'>";
            echo "<a href='" . url::site() . "reports/submit?c=" . $category . "' title='" . $category->category_title . "'>";
            echo "...add your voice!</a></div>";

            echo "<div class='main-question'>";
            echo "<a href='" . url::site() . "reports?c=" . $category . "' title='" . $category->category_title . "'>";
            echo $category->category_title . "</a>";
            echo "</div>";

            echo "<ul class='vertical'>";
            $j = 0;
            foreach ($incidents as $incident) {
                $incident_category = $incident->category[0];
                if ($category == $incident_category) {
                    $tooltip = $incident_category->category_title . $incident->incident_title;
                    echo "<li>";
                    echo "<a title='" . $tooltip . "' href='" . url::site() . "reports/view/" . $incident->id . "'>";
                    echo "<span class='main-number'>" . ($j + 1) . "</span>";
                    echo "<span class='report-answer'>\"..." . $incident->incident_title  . "\"</span>";
                    if (isset($incident->location_name)) {
                        echo "<span class='report-author'> - " . $incident->location_name  . "</span>";
                    }
                    if (isset($incident->rating)) {
                        echo "<span class='report-rating'>" . $incident->rating  . "</span>";
                    }
                    if (isset($incident->comments)) {
                        echo "<span class='report-comments'>" . $incident->comments  . "</span>";
                    }
                    echo "</a>";
                    echo "</li>";
                    $j++;
                }
                if ($j >= $answers) {
                    break;
                }
            }
            if ($j == 0) {
                 echo "<li class='main-first'><a href='" . url::site() . "reports/submit?c=" . $category . "' title='" . $category->category_title . "'>";
                 echo "Be the first to add your voice!</a></li>";
            }
            echo "</ul>";
            echo "<div class='main-stats'>";
            echo "<a href='" . url::site() . "reports?c=" . $category . "' title='" . $category->category_title . "'>";
            show_voices($category, $incidents);
            show_comments($category, $comments);
            show_votes($category, $ratings);
            echo "</a></div></div>";
        }
        else {
            echo "<div class='box main-category'>";
            echo "<div class='main-add'>";
            echo "<a href='" . url::site() . "reports/submit?c=" . $category . "' title='" . $category->category_title . "'>";
            echo "...add your voice!</a></div>";

            echo "<div class='main-question'>";
            echo "<a href='" . url::site() . "reports?c=" . $category . "' title='" . $category->category_title . "'>";
            echo $category->category_title . "</a></div>";

            echo "<div class='main-stats'>";
            echo "<a href='" . url::site() . "reports?c=" . $category . "' title='" . $category->category_title . "'>";
            show_voices($category, $incidents);
            show_comments($category, $comments);
            show_votes($category, $ratings);
            echo "</a></div></div>" ;
        }
    }
    echo "</div>";
    ?>
</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site())); ?>;
    $(function(){
        generateMap();
    });
</script>