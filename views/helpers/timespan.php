<?php

/**
 * Formats a timespan
 * 
 * @author Willi Thiel
 * @date 2010-09-11
 * @version 0.2
 */
class TimespanHelper extends AppHelper {

    /**
     * Formats a given timestring
     * 
     * @param $remain The timespan to format
     */
    function format($timespan) {
        $result = '';
        $remain = $timespan;
        $years      = floor($remain / (365 * 24 * 60 * 60));
        $remain     = $remain - ($years * (365 * 24 * 60 * 60));
        $months     = floor($remain / (30 * 24 * 60 * 60));
        $remain     = $remain - ($months * (30 * 24 * 60 * 60));
        $days       = floor($remain / (24 * 60 * 60));
        $remain     = $remain - ($days * (24 * 60 * 60));
        $hours      = floor($remain / (60 * 60));
        $remain     = $remain - ($hours * (60 * 60));
        $minutes    = floor($remain / (60));
        $seconds    = $remain - ($minutes * 60);
        $result = number_format($timespan, 0, '', ',') . 
            ' s (' .
            (($years>0) ? $years . ' years, ' : '') . 
            (($months>0) ? $months . ' months, ' : '') . 
            (($days>0) ? $days . ' days, ' : '') . 
            (($hours>0) ? $hours . ' hours, ' : '') . 
            (($minutes>0) ? $minutes . ' minutes, ' : '') . 
            (($seconds>0) ? $seconds . ' seconds, ' : '');
        $result = substr($result, 0, strlen($result)-2) . ')';    
        return $result;
    }   
}

?>
