<?php
/*
    A class to retreive tweets from a twitter account to display on a page.
    It uses v1 of their API: https://api.twitter.com/1/statuses/user_timeline.json
    So it may break one day.

    $twitter = new Twitter($name,$force);
    list($is_cache,$tweets) = $twitter->getTweets();
*/

include_once('linkify_tweets.php');

class Twitter {
    
    private $token = 'XXX'; // add your own access token here http://ghijklmno.net/twitter-migration-to-v1-1-api/

    public $cache_file; 
    public $force;
    public $screenname;
    
    public function __construct($name='morganesque',$force=false) 
    {
        $this->force = $force;
        $this->screenname = $name;
        $this->cache_file = TOM_PATH.$this->screenname.'-twitter-search.txt';        
    }
    
    public function getTweets($force = false)
    {
        $data = $this->getParsedResults();
        $tweet = array();
        if ($data['results'])
        foreach($data['results'] as $t)
        {
            $tweets[] = array(
                 'text' => $t['text']
                ,'id' => $t['id_str']
            );;
        }
        return array($data['label'], $tweets);
    }
    
    public function getParsedResults()
    {
        $o = $this->checkCache();
        $j = $o[1];
        $j['label'] = $o[0];
        return $j;
    }
    
    private function checkCache()
    {            
        if (file_exists($this->cache_file) && !$this->force)
        {
            $m = filemtime($this->cache_file); 
            $d = (time() - $m)/3600;
            if ($d < 3 && !$this->force)
            {
                return array('cache',unserialize(trim(file_get_contents($this->cache_file))));
            } else {
                return $this->getNewData();
            }
        } else {
            return $this->getNewData();
        }
    }
    
    private function getNewData()
    {
        $tmp = $this->doTwitterSearch();
        $new = array();
                
        // this is for if an error is returned (pass it into "results" anyway).
        if (!isset($tmp['results'])) $new['results'] = $tmp;
        else $new = $tmp;
        
        // this is for if absolutely nothing is returned (basically if JSON doesn't parse).
        if (!$new['results']) $new['results'] = array('error' => 1);
        
        if (is_array($new['results']))
        {
            if (isset($new['results']['error']))
            {
                /*
                    If there's an error return the cache if you can.
                */
                if (file_exists($this->cache_file))
                {
                    return array('error',unserialize(trim(file_get_contents($this->cache_file))));
                } else {
                    return array('error',array());
                }
            } else {

                foreach($new['results'] as $k=>$n)
                {                   
                    if (isset($n['retweeted_status']))
                    {
                        $text = $n['retweeted_status']['text'];
                        $entities = $n['retweeted_status']['entities'];
                        $retweet = $n['retweeted_status']['user']['screen_name'];
                    } else {
                        $text = $n['text'];
                        $entities = $n['entities'];
                        $retweet = '';
                    }

                    $output_text = TM_linkify($text,$entities,$retweet);

                    $new['results'][$k]['rawtext'] = $n['text'];
                    $new['results'][$k]['text'] = $output_text;
                }
                /*
                    If you've got here you've got data. So cache the results.
                */
                $h = fopen($this->cache_file,'w');
                fwrite($h,serialize($new));
                fclose($h);
                return array('new',$new);
            }

        }
    }

    private function doTwitterSearch()
    {
        $data = json_decode('{"token_type":"bearer","access_token":"'.$this->token.'"}',true);

        $url = $this->getSearchURL();

        $ch = curl_init($url);
            $headers = array('Authorization: Bearer '.$data['access_token']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERAGENT, 'WandP');    
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        $output = curl_exec($ch);  
        $output = utf8_decode($output);
        return json_decode($output,true);
    }
    
    private function getSearchURL()
    {
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?count=20&screen_name='.$this->screenname;
        return $url;
        // return 'https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name='.$this->screenname.'&count=20';
    }
}


/*
    This was here for a bit of testing I was doing to try and work out why the links weren't appearing properly in the tweets. It took fucking ages but I managed to work it out in the end thanks to this page: http://stackoverflow.com/questions/11533214/php-how-to-use-the-twitter-apis-data-to-convert-urls-mentions-and-hastags-in
    
define('TOM_PATH', '');
?>
<html>
    <head>
        <!-- <meta http-equiv="Content-Type" content="text/html charset=utf-8" /> -->
    </head>
<body>
<?php
$twitter = new Twitter('wreakevalleyac',true);
list($is_cache,$tweets) = $twitter->getTweets();
for($i=0; $i<20; $i++)
{
    $t = $tweets[$i];
    echo '<p>'.$t['text'].'</p>'."\n";
}
?>
</body>
</html>
<?
/* */
?>