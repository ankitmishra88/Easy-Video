<?php
    defined('ABSPATH')||die('No Script Kiddies Please');

    if(isset($_POST['channelId'])){
        $EV_api=ev_loader()->api();
        $fetched_data=$EV_api->fetchChannelData(sanitize_text_field($_POST['channelId']));
        if(!is_wp_error($fetched_data)){
            $new_posts=$fetched_data[0];
            $categories=$fetched_data[2];
            foreach($new_posts as $vid_post){
                //print_r($vid_post);
                $post_id=wp_insert_post($vid_post);
                $cat_id=$vid_post['youtube_category'];
                if(in_array($cat_id,array_keys($categories))){
                    wp_set_object_terms($post_id,$categories[$cat_id],'category');
                    //echo "setting category to $categories[$cat_id]";
                }
            }

            $total_new=count($new_posts);
            $already=count($fetched_data[1]);

            echo "<p class='ev_notice'>{$total_new} New Video Fetched, {$already} Video was already there</p>";
        }
        else{
            echo $fetched_data->get_error_message();
        }

    }


?>
<form action="" method="post">
    <div><label for="">Channel ID</label><input type="text" name="channelId" required></div>
    <div><button type="submit">Fetch</button></div>
</form>