<div class="below center">
    <div id="profile-list" class="box">
        <a id="submit-close" title="Close" href="<?php echo url::site(); ?>reports"> </a>
        <h1>Profiles</h1>
        <div class="profile-users">
            <?php foreach($users as $user){ ?>
                <div class="profile-user"><a href="<?php echo url::site();?>profile/user/<?php echo $user->username; ?>"><?php echo $user->name; ?></a></div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        generateMap();
    });
</script>