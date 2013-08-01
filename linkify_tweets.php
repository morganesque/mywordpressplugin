<?php

mb_internal_encoding("UTF-8");

// Return hyperlinked tweet text from json_decoded status object:
function TM_linkify($text, $entities, $retweet='')
{
    $TextLength = mb_strlen($text); // Number of UTF-8 characters in plain tweet.

    for ($i = 0; $i < $TextLength; $i++)
    {
        $ch = mb_substr($text, $i, 1);
        if ($ch <> "\n")
            $ChAr[] = $ch;
        else
            $ChAr[] = "\n<br/>"; // Keep new lines in HTML tweet.
    }
    if (isset($entities['user_mentions']))
        foreach ($entities['user_mentions'] as $entity)
        {
            $ChAr[$entity['indices'][0]] = "<a href='https://twitter.com/" . $entity['screen_name'] . "'>" . $ChAr[$entity['indices'][0]];
            $ChAr[$entity['indices'][1] - 1] .= "</a>";
        }
    if (isset($entities['hashtags']))
        foreach ($entities['hashtags'] as $entity)
        {
            $ChAr[$entity['indices'][0]] = "<a href='https://twitter.com/search?q=%23" . $entity['text'] . "'>" . $ChAr[$entity['indices'][0]];
            $ChAr[$entity['indices'][1] - 1] .= "</a>";
        }
    if (isset($entities['urls']))
        foreach ($entities['urls'] as $entity)
        {
            $ChAr[$entity['indices'][0]] = "<a href='" . $entity['expanded_url'] . "'>" . $entity['display_url'] . "</a>";
            for ($i = $entity['indices'][0] + 1; $i < $entity['indices'][1]; $i++)
                $ChAr[$i] = '';
        }
    if (isset($entities['media']))
        foreach ($entities['media'] as $entity)
        {
            $ChAr[$entity['indices'][0]] = "<a href='" . $entity['expanded_url'] . "'>" . $entity['display_url'] . "</a>";
            for ($i = $entity['indices'][0] + 1; $i < $entity['indices'][1]; $i++)
                $ChAr[$i] = '';
        }
    $output = implode('', $ChAr); // HTML tweet.

    if ($retweet)
    {
        return 'RT <a href="https://twitter.com/'.$retweet.'">@'.$retweet.'</a>: '.$output;
    } else {
        return $output;
    }
}
?>

