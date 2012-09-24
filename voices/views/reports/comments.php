<?php if(count($incident_comments) > 0): ?>
    <?php foreach($incident_comments as $comment): ?>
    <div class="report-comment box">
        <div class="report-label">
            <span class="comment-description">"<?php echo $comment->comment_description; ?>"</span>
            <span class="comment-author"> - <?php echo $comment->comment_author; ?></span>
        </div>
        <div class="report-value"><?php echo date('F j, Y', strtotime($comment->comment_date)); ?></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>