<div class="below center">
    <?php if($site_message != '') { ?>
    <div id="main-welcome" class="box">
        <?php echo $site_message; ?>
    </div>
    <?php } ?>
    <div id="main-stats">
        <?php
        $categories = Kohana::config('settings.categories');
        $category = $categories[0];
        ?>
        <div class="main-column-left box">
            <a href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>">
                <?php
                $voices = 0;
                foreach (Kohana::config('settings.incidents') as $incident) {
                    if ($category == $incident->category_id) {
                        $voices++;
                    }
                }
                if ($voices == 1) {
                    echo "1 voice";
                }
                else {
                    echo $voices . " voices";
                }
                ?></a>
        </div>
        <div class="main-column-middle box">
            <a href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>">
            <?php
            $comments = 0;
            foreach (Kohana::config('settings.comments') as $comment) {
                if ($category == $comment->category_id) {
                   $comments++;
                }
            }
            if ($comments == 1) {
                echo "1 comment";
            }
            else {
                echo $comments . " comments";
            }
            ?></a>
        </div>
        <div class="main-column-right box">
            <a href="<?php echo url::site(); ?>reports?c=<?php echo $category; ?>">
            <?php
            $votes = 0;
            foreach (Kohana::config('settings.ratings') as $rating) {
                if ($category == $rating->category_id) {
                    $votes++;
                }
            }
                if ($votes == 1) {
                    echo "1 vote";
                }
                else {
                    echo $votes . " votes";
                }
            ?></a>
        </div>
    </div>
    <div id="main-top">
    <?php
         $incidents = Kohana::config('settings.incidents');
         for ($i = 0; $i < 3 && $i < count($incidents); $i++) {
             $incident = $incidents[$i];
             $tooltip = $category->category_title . $incident->incident_title;
             if ($i == 0) {
                 $column = "main-column-left";
             }
             else if ($i == 1) {
                 $column = "main-column-middle";
             }
             else if ($i == 2) {
                 $column = "main-column-right";
             }
//             else if ($i == 3) {
//                 echo "<div class='clear'></div>";
//                 $column = "main-column-left";
//             }
//             else if ($i == 4) {
//                 $column = "main-column-middle";
//             }
//             else if ($i == 5) {
//                 $column = "main-column-right";
//             }
             echo "<div class='" . $column . " box'>";
             echo "<div class='main-star'>" . ($i + 1) . "</div>";
             echo "<a title='" . $tooltip . "' href='" . url::site() . "reports/view/" . $incident->id . "'>";
             if (isset($incident->rating)) {
                 echo "<div class='report-rating'>" . $incident->rating  . "</div>";
             }
             if (isset($incident->comments)) {
                 echo "<div class='report-comments'>" . $incident->comments  . "</div>";
             }
             echo "<div class='report-answer'>\"..." . $incident->incident_title  . "\"</div>";
             if (isset($incident->location_name)) {
                 echo "<div class='report-author'> - " . $incident->location_name  . "</div>";
             }
             echo "</a></div>";
         }
    ?>
    </div>
    <div id="main-action" class="box">
        <a title="Add Your Voice" href="<?php echo url::site(); ?>reports/submit?c=<?php echo $category; ?>">Add Your Voice</a>
    </div>
    <?php
//    $categories = Kohana::config('settings.categories');
//    if (count($categories) > 1) {
//        echo "<div id='main-categories'>";
//        for ($i = 1; $i < count($categories); $i++) {
//            $category = $categories[$i];
//            echo "<div class='bubble'>" . $category->category_title . "</div>" ;
//        }
//        echo "</div>";
//    }
    ?>
</div>
<script type="text/javascript">
    var $PHRASES = <?php echo json_encode(
        array('server' => url::site())); ?>;
    $(function(){
        generateMap();
    });
</script>