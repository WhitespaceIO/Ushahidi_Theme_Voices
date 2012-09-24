<?php print form::open(NULL, array('id' => 'commentForm', 'name' => 'commentForm')); ?>

<div id="comment-description" class="bubble">
    <?php print form::input('comment_description', $form['comment_description'], ' class="text" placeholder="Add your voice, share a comment on this idea..." ') ?>
</div>

<?php if (!$user) { ?>
    <div id="comment-author" class="box">
        <div><?php print form::input('comment_author', $form['comment_author'], ' class="text" placeholder="Your name" '); ?></div>
        <div><?php print form::input('comment_email', $form['comment_email'], ' class="text" placeholder="Your email" '); ?></div>
        <div><?php print form::input('captcha', $form['captcha'], ' class="text" placeholder="'.  $captcha->render() . '" '); ?></div>
        <div><input name="submit" type="submit" class="button" value="Comment" /></div>
    </div>
<?php } else { ?>
    <div id="comment-user" class="box">
        <div><span><?php echo $user->name; ?></span></div>
        <div><?php print form::input('captcha', $form['captcha'], ' class="text" placeholder="'.  $captcha->render() . '" '); ?></div>
        <div><input name="submit" type="submit" class="button" value="Comment" /></div>
    </div>
<?php } ?>
<?php print form::close(); ?>
<?php if ($form_error) {
    foreach ($errors as $error_item => $error_description) {
        print (!$error_description) ? '' : "<div class='red box'><h3>" . $error_description . "</h3></div>";
    }
} ?>