<?php
$query = $conn->prepare("SELECT processed FROM planning_processed WHERE userid = {$userid} AND date = {date('Y-m-d')}");
$query->execute();

$result = $query->get_result();

//while ($row = $result->fetch_array(MYSQLI_NUM)) {
//    if ($row[0] != 0) {


$query = $conn->prepare("SELECT name, description, location, start_time, end_time, fixed, can_next_day FROM planning WHERE userid = {$_SESSION['id']} AND date = ? ORDER BY start_time, end_time");
$query->bind_param('s', date('Y-m-d'));
$query->execute();

$result = $query->get_result();


$fixedEvents = array();
$todayEvents = array();
$somedayEvents = array();
$somedayFixedEvents = array();

while ($row = $result->fetch_assoc()) {
    echo "<br>ADDED ROW";
    if ($row['can_next_day'] == 1 && $row['fixed'] == 0) {
        $somedayFixedEvents[] = $row;
    } else if ($row['can_next_day'] == 1) {
        $somedayEvents[] = $row;
    } else if ($row['fixed'] == 0) {
        $todayEvents[] = $row;
    } else {
        $fixedEvents[] = $row;
    }
}

echo "<br><br>";

print_r($todayEvents);

$openTimeSlots = array();


foreach ($fixedEvents as $value) {
    $nextStartTime = 2359;
    $endTime = date('Hi', strtotime($value['end_time']));

    echo "<br>EVENT: " . $value['name'] . " ENDTIME: " . $endTime;
    foreach ($fixedEvents as $testValue) {
        $startTime = date('Hi', strtotime($testValue['start_time']));
        echo "<br>EVENT: " . $testValue['name'] . " STARTTIME: " . $startTime;
        if ($startTime > $endTime && $startTime < $nextStartTime) {
            $nextStartTime = $startTime;
        }
        if ($endTime == $startTime) {
            break; //No need to add open time slot since there is an event directly after it.
        }
    }
    echo "<br>NEXTSTARTTIME: " . $nextStartTime;
    if ($nextStartTime != 2359) {
        echo "<br>ADDEDTIMESLOT: " . $endTime . " DURATION: " . $nextStartTime - $endTime;
        $openTimeSlots[] = array($endTime, $nextStartTime - $endTime);
    }
}


$possibleEvents = array();

function planEvents($duration, $events) {
    echo "<br><br>DURATION: ".$duration;
    $temp = array();
    $temp['duration'] = 0;
    settype($temp['duration'], "integer");
    $temp['events'] = array();
    global $possibleEvents;
    $possibleEvents = array();
    nextEvent($duration, $events, $temp);
    $bestOption = $possibleEvents[0];
    foreach($possibleEvents as $key=>$value) {
        if($value['duration'] > $bestOption['duration']) {
            $bestOption = $value;
        }
    }
    return $bestOption;
}

function nextEvent($duration, $events, $tempPossibleEvents) {
    foreach($events as $key=>$value) {
        $eventDuration = date('Hi', strtotime($value['end_time']))-date('Hi', strtotime($value['start_time']));
        $temp = $tempPossibleEvents;
        echo "<br><br>";
        print_r($temp);
        if ($eventDuration + $temp['duration'] > $duration) {
            global $possibleEvents;
            $possibleEvents[] = $temp;
        } else {
            $temp['duration'] += $eventDuration;
            $temp['events'][$key] = $value;
            $newEvents = $events;
            unset($newEvents[$key]);
            nextEvent($duration, $newEvents, $temp);
        }
    }
}

echo "<br><br><br>PLANNINGS: ";

foreach($openTimeSlots as $value) {
    $timeSlotPlanning = planEvents($value[1], $todayEvents);
    foreach($timeSlotPlanning['events'] as $key=>$value) {
        unset($todayEvents[$key]);
    }

    print "<pre>";
    print_r($timeSlotPlanning);
    print "</pre><br><br>";
}



print "<br><br>ITEMS LEFT: <pre>";
print_r($todayEvents);
print "</pre><br><br>";


echo "<br><br>";

print_r($openTimeSlots);


echo "<br><br><br>";

//        $query = $conn->prepare("INSERT userid, date, processed INTO planning_processed VALUES({$userid}, {date('Y-m-d')}, 1)");
//        $query->execute();
//    }
//}