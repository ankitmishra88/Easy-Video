<?php
/**
 * Template for Easy Video Template
 */
get_header();
global $post;
$post_id=get_the_ID();
$vid=get_post_meta($post_id,'ev_video_id',true);
//echo $vid;
$url="hhttps://www.youtube.com/embed/{$vid}?rel=0";
?>
<div id="embed_div" class="embed-responsive embed-responsive-<? echo get_option('watch_size');?>">
<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $vid; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<?php
get_footer();
?>