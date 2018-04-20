<?php

/**
 * Instagram Spider [MOD : WP - Insta Gallery]
 * @author Karan Singh
 * @version 1.3.8
 * @depends RUSpider
 * @description script to get instagram media by using Username and Tag-name. added WP (wp_remote_request) to run in WP.
 */

// loading dependencies
class InstagramSpider
{

    protected $instagram;

    // handle raw result from server, for further processing in your app
    public $instagramResult;

    public $messages;

    public function __construct()
    {
        $this->instagram = 'https://www.instagram.com/';
        $this->messages = array();
    }

    /**
     * takes username and return items list array
     *
     * @param string $username            
     * @return array|false
     */
    public function getUserItems($username = '')
    {
        $username = urlencode((string) $username); // non-english string support
        if (empty($username)) {
            $this->messages[] = 'Please provide a valid username';
            return false;
        }
        
        // $inURL = $this->instagram . $username . '/media/';
        $inURL = $this->instagram . $username . '/?__a=1';
        // For next 12 images, use ID of the last item (maxId = media.nodes[11].id) in the max_id param: /{USER_NAME}/?__a=1&max_id={maxId}
        $instaRes = $this->igSpider($inURL);
        $instaRes = @json_decode($instaRes);
        
        $items = array();
        
        // new API update Mar1418
        if (isset($instaRes->graphql->user->edge_owner_to_timeline_media->edges)) {
            $instaItems = $instaRes->graphql->user->edge_owner_to_timeline_media->edges;
            if (! empty($instaItems) && is_array($instaItems)) {
                foreach ($instaItems as $res) {
                    
                    if (! isset($res->node->display_url)) {
                        continue;
                    }
                    
                    $type = 'image';
                    if (isset($res->node->is_video) && (true === $res->node->is_video)) {
                        $type = 'video';
                    }
                    
                    $items[] = array(
                        'img_standard' => $res->node->display_url,
                        'img_low' => $res->node->thumbnail_src,
                        'img_thumb' => $res->node->thumbnail_resources[0]->src,
                        'likes' => $res->node->edge_liked_by->count,
                        'comments' => $res->node->edge_media_to_comment->count,
                        'caption' => '',
                        'code' => $res->node->shortcode,
                        'type' => $type
                    );
                }
            }
        }
        
        // if empty, continus with the HTML API
        if (empty($items)) {
            $inURL = $this->instagram . $username . '/';
            $items = $this->getFromHtmlAPI($inURL);
        }
        
        return empty($items) ? false : $items;
    }

    /**
     * takes #Tag name and return items list array
     *
     * @param string $tag            
     * @param
     *            boolean get top posts (10 posts)
     * @return array|false
     */
    public function getTagItems($tag = '', $getTopItems = false)
    {
        $tag = urlencode((string) $tag);
        if (empty($tag)) {
            $this->messages[] = 'Please provide a valid # tag';
            return false;
        }
        $inURL = $this->instagram . 'explore/tags/' . $tag . '/?__a=1';
        $instaRes = $this->igSpider($inURL);
        $instaRes = json_decode($instaRes);
        
        $items = array();
        // continue to next API : API updated on Jan 03 17
        if (isset($instaRes->graphql->hashtag->edge_hashtag_to_media->edges)) {
            $instaItems = $instaRes->graphql->hashtag->edge_hashtag_to_media->edges;
            
            // get top posts
            if ($getTopItems && isset($instaRes->graphql->hashtag->edge_hashtag_to_top_posts->edges)) {
                $instaItems = $instaRes->graphql->hashtag->edge_hashtag_to_top_posts->edges;
            }
            
            if (! empty($instaItems) && is_array($instaItems)) {
                foreach ($instaItems as $res) {
                    
                    if (! isset($res->node->display_url)) {
                        continue;
                    }
                    
                    $type = 'image';
                    if (isset($res->node->is_video) && (true === $res->node->is_video)) {
                        $type = 'video';
                    }
                    
                    $items[] = array(
                        'img_standard' => $res->node->display_url,
                        'img_low' => $res->node->thumbnail_src,
                        'img_thumb' => $res->node->thumbnail_resources[0]->src,
                        'likes' => $res->node->edge_liked_by->count,
                        'comments' => $res->node->edge_media_to_comment->count,
                        'caption' => '',
                        'code' => $res->node->shortcode,
                        'type' => $type
                    );
                }
            }
        }
        
        // if empty, continus with the HTML API
        if (empty($items)) {
            $inURL = $this->instagram . 'explore/tags/' . $tag . '/';
            $items = $this->getFromHtmlAPI($inURL);
        }
        
        return empty($items) ? false : $items;
    }

    /**
     * takes page URL and return items list array
     *
     * @param
     *            string url
     * @return array
     */
    protected function getFromHtmlAPI($inURL = '')
    {
        $instaRes = $this->igSpider($inURL);
        
        $items = array();
        
        if (! empty($instaRes)) {
            $insta_json = explode('window._sharedData = ', $instaRes);
            $insta_json = explode(';</script>', $insta_json[1]);
            $instaArray = json_decode($insta_json[0], true);
            
            $nodes = array();
            if (isset($instaArray['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'])) {
                $nodes = $instaArray['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            } else if (isset($instaArray['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'])) {
                $nodes = $instaArray['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            }
            if (! empty($nodes) && is_array($nodes)) {
                foreach ($nodes as $node) {
                    if (! isset($node['node']['display_url'])) {
                        continue;
                    }
                    
                    $node = $node['node'];
                    
                    $type = 'image';
                    if (isset($node['is_video']) && (true === $node['is_video'])) {
                        $type = 'video';
                    }
                    
                    $items[] = array(
                        'img_standard' => $node['display_url'],
                        'img_low' => $node['thumbnail_src'],
                        'img_thumb' => $node['thumbnail_resources'][0]['src'],
                        'likes' => $node['edge_liked_by']['count'],
                        'comments' => $node['edge_media_to_comment']['count'],
                        'caption' => '',
                        'code' => $node['shortcode'],
                        'type' => $type
                    );
                }
            }
        }
        
        return empty($items) ? false : $items;
    }

    /**
     * takes URL string and return URL content
     *
     * @param string $url            
     * @return string|boolean
     */
    public function igSpider($url = '')
    {
        if (empty($url) || (! filter_var($url, FILTER_VALIDATE_URL))) {
            $this->messages[] = 'Please provide a Valid URL';
            return false;
        }
        $instaItems = '';
        
        // get results if script executed in WP
        if (function_exists('wp_remote_request')) {
            $result = wp_remote_request($url);
            if (is_wp_error($result)) {
                $this->messages[] = 'WP Error: ' . implode(', ', $result->get_error_messages());
            } else {
                if (200 !== wp_remote_retrieve_response_code($result)) {
                    $this->messages[] = 'Invalid response from Instagram.';
                } else {
                    if (! empty($result['body'])) {
                        $instaItems = $result['body'];
                    }
                }
            }
        } else {
            $this->messages[] = 'Error: running outside WP.';
        }
        
        $this->instagramResult = $instaItems;
        return $instaItems;
    }

    // return messages array
    public function getMessages()
    {
        return array_unique($this->messages);
    }
}

