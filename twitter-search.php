<?php
/*
    A class to retreive tweets from a twitter account to display on a page.
    It uses v1 of their API: https://api.twitter.com/1/statuses/user_timeline.json
    So it may break one day.

    $twitter = new Twitter($name,$force);
    list($is_cache,$tweets) = $twitter->getTweets();
*/

class Twitter {
    
    public $cache_file; 
    public $force;
    public $screenname;
    
    public function __construct($name='morganesque',$force=false) 
    {
        $this->force = $force;
        $this->cache_file = TOM_PATH.'twitter-search.txt';
        $this->screenname = $name;
    }
    
    public function getTweets($force = false)
    {
        $data = $this->getParsedResults();
        $tweet = array();
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
        
        if (!isset($tmp['results'])) $new['results'] = $tmp;
        else $new = $tmp;
        
        if (is_array($new['results']))
        {
            if ($new['results']['error'])
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
                /*
                    If you get results process them and return them.
                */
                foreach($new['results'] as $k=>$t)
                {   
                    $text = $t['text'];                 
                    $text = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $text);
                    $text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $text);
                    $text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $text);
                    $new['results'][$k]['text'] = $text;
                }                
            }

        }

        /*
            If you've got here you haven't errored. So cache the results.
        */
        $h = fopen($this->cache_file,'w');
        fwrite($h,serialize($new));
        fclose($h);
        return array('new',$new);
    }
    
    private function doTwitterSearch()
    {
        $url = $this->getSearchURL();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        return json_decode($output,true);
    }
    
    private function getSearchURL()
    {
        return 'https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name='.$this->screenname.'&count=20';
    }
}

// $LSXTwit = new LSXTwitter();

?>