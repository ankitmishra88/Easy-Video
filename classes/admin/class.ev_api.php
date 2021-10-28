<?php
    defined("ABSPATH")||die('No Script Kiddies Please');

    class EV_API{
        public function __construct(){
            
        }
        public function get_api_key(){
            return get_option('ev_video_yt_api_key');
        }
        public function channelFetchUrl($channel_id){
            $api_key=$this->get_api_key();
            return "https://www.googleapis.com/youtube/v3/search?key={$api_key}&channelId={$channel_id}&&part=snippet,id&order=date&maxResults=10000";
        }

        public function getVideosUrl($channel_id,$video_ids){
            $api_key=$this->get_api_key();
            return "https://www.googleapis.com/youtube/v3/videos?key={$api_key}&id={$video_ids}&&part=snippet,id&order=date&maxResults=10000";
        }
        
        public function getCategoriesUrl($category_ids){
            $api_key=$this->get_api_key();
            return "https://www.googleapis.com/youtube/v3/videoCategories?key={$api_key}&id={$category_ids}";
        }

        public function fetchChannelData($channel_id){
            
            //print_r($this->channelFetchUrl($channel_id));
            $fetched_data=wp_remote_get($this->channelFetchUrl($channel_id));
            if(!is_wp_error($fetched_data)){
                $response_body=json_decode($fetched_data['body'],true);
                if(array_key_exists('error',$response_body)){
                    return new WP_Error($response_body['error']['code'],$response_body['error']['message']);
                }
                $videoIds=array();
                foreach($response_body['items'] as $item){
                    $videoId=$item['id']['videoId'];
                    $videoIds[]=$videoId;
                }
                $video_ids=implode(',',$videoIds);
                $videosApiUrl=$this->getVideosUrl($channel_id,$video_ids);
                $videos_data=wp_remote_get($videosApiUrl);
                $response_body=json_decode($videos_data['body'],true);
                if(array_key_exists('error',$response_body)){
                    return new WP_Error($response_body['error']['code'],$response_body['error']['message']);
                }

                
                $video_posts=array();
                $already_existing=array();
                $category_ids=array();
                
                foreach($response_body['items'] as $item){
                    $videoId=$item['id'];
                    $videoIds[]=$videoId;
                    $videoTitle=$item['snippet']['title'];
                    $videoDescription=$item['snippet']['description'];
                    $thumbnail_url=$item['snippet']['thumbnails']['high'];
                    $thumbnail_url=$thumbnail_url?$thumbnail_url:$item['snippet']['thumbnails']['medium'];
                    $thumbnail_url=$thumbnail_url?$thumbnail_url:$item['snippet']['thumbnails']['default'];
                    $thumbnail_url=$thumbnail_url['url'];
                    $category_id=$item['snippet']['categoryId'];
                    $category_ids[]=$category_id;

                    $existing_video=get_posts(array(
                        'post_type'=>ev_loader()->cpt()->get_post_type(),
                        'meta_key'=>'ev_video_id',
                        'meta_value'=>$videoId
                    ));
                    
                    
                    
                    $only_ids=array();
                    if(!empty($existing_video)){
                        $already_existing[]=array($videoId=>$existing_video);
                    }
                    else{
                        //continue;
                        $video_posts[$videoId]=array(
                            'post_title'=>$videoTitle,
                            'post_content'=>$videoDescription,
                            'post_type'=>ev_loader()->cpt()->get_post_type(),
                            'post_status'=>'publish',
                            'youtube_category'=>$category_id,
                            'meta_input'=>array(
                                'ev_video_id'=>$videoId,
                                'ev_video_thumbnail'=>$thumbnail_url,
                                'ev_fetched_snippet'=>$item['snippet'],
                            )
                            );
                    }
                    

                }

                $category_ids=implode(',',$category_ids);
                $fetched_categories=wp_remote_get($this->getCategoriesUrl($category_ids));
                $categories=array();
                if(!is_wp_error($fetched_categories)){
                    $categories_data=json_decode($fetched_categories['body'],true);
                    if(!array_key_exists('error',$categories_data)){
                        foreach($categories_data['items'] as $category){
                            //print_r($category);
                            $categories[$category['id']]=$category['snippet']['title'];
                        }
                    }
                }
                
               
                
                

                return array($video_posts,$already_existing,$categories);

            }
        }
    }
?>