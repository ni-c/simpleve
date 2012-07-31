<?php

/**
 * Controller for iCal
 * 
 * @author Willi Thiel
 * @date 2010-10-20
 * @version 1.0
 */
class IcalController extends AppController {

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     */
    var $name = 'Ical';

    var $uses = array(
        'User',
        'EveRamActivity'
    );

    var $characters = array();

    var $alarmAction = 'DISPLAY';

    /**
     * Provides access for actions which most often do not require any access control. 
     */
    public $allowedActions = array(
        'create'
    );

    function create($api_id = null, $api_key = null, $filename = null) {
        
        $apitype = '';
        
        // Set ALARMACTION to AUDIO if we are on an iPhone
        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')!==false) &&
            (strpos($_SERVER['HTTP_USER_AGENT'], 'iCalendar')!==false)) {
            $this->alarmAction = 'AUDIO';
        } 

        if (($api_id == null) || 
            ($api_key == null) ||
            ($filename == null)) {
                $this->redirect('/');
                return;
        }
        
        $this->User->recursive = 2;
        $this->User->Group->unbindModel(
            array(
                'hasMany' => array('User')
            )
        );
        $this->User->Option->unbindModel(
            array(
                'belongsTo' => array('User')
            )
        );
        $this->User->Api->unbindModel(
            array(
                'belongsTo' => array('User')
            )
        );
        $User = $this->User->find('first',
            array('conditions' => 
                array(
                    'User.id' => ($api_id - 1000000),
                    'User.hash' => $api_key
                )
            )
        );
        if ($User) {
            if ($User['User']['group_id']>1) {
                if (strpos($filename, '_')!==false) {
                    $tmp = split('_', $filename, 2);
                    $type = $tmp[0];
                    if ((($tmp[0]=='Skillqueue') ||
                         ($tmp[0]=='Jobs')) && 
                        (strpos($tmp[1], '.ics')!==false)) {
                        
                        foreach($User['Option'] as $option) {
                            if ($option['key'] == 'ical_feed') {
                                $enabled = $option['value'];
                            }
                        }
                        
                        if ($enabled==1) {
                            $tmp = str_replace('.ics', '', $tmp[1]);
                            $charname = str_replace('_', ' ', $tmp);
                            $charcorpID = -1;
                            $Apis = array();
                            foreach ($User['Api'] as $api) {
                                $Apis[]['Api'] = $api;
                            }
                            $characterSheets = $this->AleApi->getCharacterSheets($Apis);
                            foreach ($characterSheets as $characterSheet) {
                                $chars = $this->AleApi->convertToArray($characterSheet);
                                foreach ($chars as $char) {
                                    if ($char['name'] == $charname) {
                                        $charcorpID = $char['characterID'];
                                        $apitype = 'char';
                                    }
                                    $this->characterNames[$char['characterID']] = $char['name'];
                                }
                            }
                            if ($charname=='All') {
                                $charcorpID = 0;
                                $apitype = 'char';
                            } else {
                                if ($charcorpID == -1) {
                                    // Look for matching corporation
                                    $Corporations = $this->AleApi->getCorporations($Apis);
                                    foreach ($Corporations as $key => $corp) {
                                        if (!$corp['npccorp']) {
                                            if (trim($corp['corporationSheet']->ticker) == $charname) {
                                                $charname = '[' . $charname . ']';
                                                $charcorpID = $key;
                                                $apitype = 'corp';
                                            }
                                        }   
                                    }
                                }
                            }        
                            if ($type == 'Skillqueue') {
                                $apiResult = $this->AleApi->requestApis($Apis, 'char', 'SkillQueue');
                            }
                            if ($type == 'Jobs') {
                                if ($apitype == 'corp') {
                                    $apiResult = $this->AleApi->requestApis($Apis, 'corp', 'IndustryJobs');
                                } else {
                                    $apiResult = $this->AleApi->requestApis($Apis, 'char', 'IndustryJobs');
                                }
                            }
    
                            if ($charcorpID>=0) {
                                if (($apitype=='char') && ($charcorpID>0)) {
                                    foreach ($apiResult as $id => &$data) {
                                        foreach ($data as $key => $value) {
                                            if ($value['characterID']!=$charcorpID) {
                                                unset($data[$key]);
                                            }
                                        }
                                        if (count($data)==0) {
                                            unset($apiResult[$id]);
                                        }
                                    }
                                    $result = $apiResult;
                                } 
                                if ($apitype=='corp') {
                                    foreach ($apiResult as $id => &$data) {
                                        foreach ($data as $key => $value) {
                                            if ($value['corporationID']==$charcorpID) {
                                                $result = array();
                                                $result[$id][$key] = $data[$key];unset($data[$key]);
                                            }
                                        }
                                    }
                                }
                                if (!isset($result)) {
                                    $result = $apiResult;
                                }
                                
                                header("Content-Type: text/calendar");
                                header("Content-Disposition: inline; filename=$filename");
                                if ($type == 'Skillqueue') {
                                    if ($charcorpID==0) {
                                        $name = 'Skillqueues';
                                    } else {
                                        $name = 'Skillqueue ' . $charname;
                                    }
                                    echo $this->_createSkillQueueCal($result, $name, $api_id . $api_key . str_replace('.ics', '', $type));
                                }
                                
                                if ($type == 'Jobs') {
                                    if ($charcorpID==0) {
                                        $name = 'Industry Jobs';
                                    } else {
                                        $name = 'Industry Jobs ' . $charname;
                                    }
                                    echo $this->_createJobsCal($result, $name, $api_id . $api_key . str_replace('.ics', '', $type), $apitype, $charname);
                                }
                                
                                die();
                            }
                        }
                    }
                }
            }
        }        
        $this->redirect('/');   
        die();
    }

    private function _createJobsCal($jobs, $name, $id, $corp, $charname) {

        $ical_feed_alarm = ((isset($this->options['ical_feed_alarm'])) ? $this->options['ical_feed_alarm'] : 0);
        $ical_feed_alarm_from = ((isset($this->options['ical_feed_alarm_from'])) ? $this->options['ical_feed_alarm_from'] : 0);
        $ical_feed_alarm_to = ((isset($this->options['ical_feed_alarm_to'])) ? $this->options['ical_feed_alarm_to'] : 0);
        if ($ical_feed_alarm_from<10) {
            $ical_feed_alarm_from = '0' . $ical_feed_alarm_from;
        }
     
        App::import('Vendor', 'ical/vcalendar');
        $ical = new vcalendar();
        $ical->setConfig('unique_id', $id . '.simpleve.com');
        $ical->setProperty('method', 'PUBLISH');
        $ical->setProperty('X-WR-CALDESC', 'SimplEve Industry Jobs');
        $ical->setProperty('X-WR-TIMEZONE', 'UTC/GMT');
        $ical->setProperty('X-WR-CALNAME', $name);
        foreach ($jobs as $job) {
            foreach ($job as $value) {
                $value = $this->AleApi->convertToArray($value['api']);
                foreach ($value as $item) {
                    if (!empty($item['endProductionTime'])) {
                        $EveInvType = $this->requestAction('/database/invtype/' . $item['outputTypeID']);

                        $EveRamActivity = $this->EveRamActivity->toArray();
                        $activity = $EveRamActivity[$item['activityID']];
                        $activity['activityName'] = str_replace('Researching Material Productivity', 'Material Research', $activity['activityName']);
                        $activity['activityName'] = str_replace('Researching Time Productivity', 'Time Efficiency Research', $activity['activityName']);
                        if ($corp=='corp') {
                            $titleName = $charname;
                        } else {
                            $titleName = $this->characterNames[$item['installerID']];
                        }

                        $title = $titleName . ': ' . $activity['activityName'] . ' (' . $EveInvType['EveInvType']['typeName'] . ')';
                        $EveStaStation = $this->requestAction('/database/stastation/' . $item['outputLocationID']);
                        $description = 
                            'Activity: ' . $activity['activityName'] . "\r\n" .
                            'Type: ' . $EveInvType['EveInvType']['typeName'] . "\r\n" .
                            'Owner: ' . $this->characterNames[$item['installerID']] . "\r\n" .
                            'Location: ' . $EveStaStation['EveStaStation']['stationName'];
                            
                        $e = new vevent();
                        $e->setProperty('categories', 'Eve Online' );
                        $e->setProperty('dtstart',  date('Ymd\THis\Z', strtotime($item['endProductionTime'])));
                        $e->setProperty('duration', 0, 0, 0, 0, 1);
                        $e->setProperty('summary', $title);
                        $e->setProperty('description', $description);
                        if ($ical_feed_alarm!=0) {
                            if ((($ical_feed_alarm_from < $ical_feed_alarm_to) &&
                                 (date('H', strtotime($item['endProductionTime']))>$ical_feed_alarm_from) && 
                                 (date('H', strtotime($item['endProductionTime']))<$ical_feed_alarm_to)) || 
                                (($ical_feed_alarm_from > $ical_feed_alarm_to) &&
                                 ((date('H', strtotime($item['endProductionTime']))>$ical_feed_alarm_from) || 
                                  (date('H', strtotime($item['endProductionTime']))<$ical_feed_alarm_to))) ||
                                 ($ical_feed_alarm_from == $ical_feed_alarm_to)) {
                                $trigger = date('Ymd\THis\Z', strtotime($item['endProductionTime']));
                            } else {
                                if (date('H', strtotime($item['endProductionTime']))>$ical_feed_alarm_from) {
                                    $trigger = date('Ymd\T', strtotime($item['endProductionTime']) + 24 * 60 * 60) . $ical_feed_alarm_from . '0000Z';
                                } else {
                                    $trigger = date('Ymd\T', strtotime($item['endProductionTime'])) . $ical_feed_alarm_from . '0000Z';
                                }
                            }
                            $a = new valarm();
                            $a->setProperty('action', $this->alarmAction);
                            $a->setProperty('description', $title);
                            $a->setProperty('trigger', $trigger);
                            $e->setComponent($a); 
                        }
                        
                        $ical->addComponent($e);
                    }
                }
            }
        }
        
        return $ical->createCalendar();
    }

    private function _createSkillQueueCal($skillQueues, $name, $id) {

        $ical_feed_alarm = ((isset($this->options['ical_feed_alarm'])) ? $this->options['ical_feed_alarm'] : 0);
        $ical_feed_alarm_from = ((isset($this->options['ical_feed_alarm_from'])) ? $this->options['ical_feed_alarm_from'] : 0);
        $ical_feed_alarm_to = ((isset($this->options['ical_feed_alarm_to'])) ? $this->options['ical_feed_alarm_to'] : 0);
        if ($ical_feed_alarm_from<10) {
            $ical_feed_alarm_from = '0' . $ical_feed_alarm_from;
        }
     
        App::import('Vendor', 'ical/vcalendar');
        $ical = new vcalendar();
        $ical->setConfig('unique_id', $id . '.simpleve.com');
        $ical->setProperty('method', 'PUBLISH');
        $ical->setProperty('X-WR-CALDESC', 'SimplEve Skillqueue');
        $ical->setProperty('X-WR-TIMEZONE', 'UTC/GMT');
        $ical->setProperty('X-WR-CALNAME', $name);
        foreach ($skillQueues as $skillQueue) {
            foreach ($skillQueue as $queue) {
                $charname = $this->characterNames[$queue['characterID']];
                $queue = $this->AleApi->convertToArray($queue['api']);
                foreach ($queue as $item) {
                    if (!empty($item['endTime'])) {
                        switch ($item['level']) {
                            case 1:
                                $level = 'I';
                                break;
                            case 2:
                                $level = 'II';
                                break;
                            case 3:
                                $level = 'III';
                                break;
                            case 4:
                                $level = 'IV';
                                break;
                            case 5:
                                $level = 'V';
                                break;
                            default:
                                $level = '';
                                break;
                        }
                        $skill = $this->requestAction('/database/invtype/' . $item['typeID']);
                                                
                        $e = new vevent();
                        $e->setProperty('categories', 'Eve Online' );
                        $e->setProperty('dtstart',  date('Ymd\THis\Z', strtotime($item['endTime'])));
                        $e->setProperty('duration', 0, 0, 0, 0, 1);
                        $e->setProperty('summary', $charname . ': ' . $skill['EveInvType']['typeName'] . ' ' . $level);
                        $e->setProperty('description', $charname . ' completes ' . $skill['EveInvType']['typeName'] . ' ' . $level);
                        if ($ical_feed_alarm!=0) {
                            if ((($ical_feed_alarm_from < $ical_feed_alarm_to) &&
                                 (date('H', strtotime($item['endTime']))>$ical_feed_alarm_from) && 
                                 (date('H', strtotime($item['endTime']))<$ical_feed_alarm_to)) || 
                                (($ical_feed_alarm_from > $ical_feed_alarm_to) &&
                                 ((date('H', strtotime($item['endTime']))>$ical_feed_alarm_from) || 
                                  (date('H', strtotime($item['endTime']))<$ical_feed_alarm_to))) ||
                                 ($ical_feed_alarm_from == $ical_feed_alarm_to)) {
                                $trigger = date('Ymd\THis\Z', strtotime($item['endTime']));
                            } else {
                                if (date('H', strtotime($item['endTime']))>$ical_feed_alarm_from) {
                                    $trigger = date('Ymd\T', strtotime($item['endTime']) + 24 * 60 * 60) . $ical_feed_alarm_from . '0000Z';
                                } else {
                                    $trigger = date('Ymd\T', strtotime($item['endTime'])) . $ical_feed_alarm_from . '0000Z';
                                }
                            }
                            $a = new valarm();
                            $a->setProperty('action', $this->alarmAction);
                            $a->setProperty('description', $charname . ' completed ' . $skill['EveInvType']['typeName'] . ' ' . $level);
                            $a->setProperty('trigger', $trigger);
                            $e->setComponent($a); 
                        }
                        
                        $ical->addComponent($e);
                    }
                }
            }
        }
        
        return $ical->createCalendar();
    }
}
