<?php
defined('ABSPATH')||die('No Script Kiddies Please');

if(isset($_POST['ev_video_yt_api_key'])){
    update_option('ev_video_yt_api_key',sanitize_text_field($_POST['ev_video_yt_api_key']));
}
$youtube_api_key=ev_loader()->api()->get_api_key();

?>
<form action="" method="POST">
    <div>
        <div><label for="">API Key</label><input value="<?php echo $youtube_api_key; ?>" type="text" name="ev_video_yt_api_key" class="regular-text"></div>
    </div>
    <div><button type="submit">Update</button></div>
</form>