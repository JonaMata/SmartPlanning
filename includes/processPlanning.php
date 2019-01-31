<?php

$query = $conn->prepare("SELECT fixed FROM planning WHERE userid = {$_SESSION['id']} AND date = ? AND fixed = 1");
$query->bind_param('s', date('Y-m-d'));
$query->execute();

$result = $query->get_result();

if ($row = $result->fetch_array(MYSQLI_NUM) && $_GET['plan'] != "no") {


    $query = $conn->prepare("SELECT name, description, location, start_time, end_time, fixed, can_next_day, invisible FROM planning WHERE userid = {$_SESSION['id']} AND date = ? ORDER BY start_time, end_time");
    $query->bind_param('s', date('Y-m-d'));
    $query->execute();

    $result = $query->get_result();


    $fixedEvents = array();
    $todayEvents = array();
    $somedayEvents = array();
    $somedayFixedEvents = array();

    while ($row = $result->fetch_assoc()) {
//        echo "<br>ADDED ROW";
        if ($row['invisible'] == 1) {

        } else {
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
    }

//    echo "<br><br>";
//
//    print_r($todayEvents);

    $openTimeSlots = array();


    foreach ($fixedEvents as $value) {
        $nextStartTime = PHP_INT_MAX;
        $endTime = strtotime($value['end_time']);

//        echo "<br>EVENT: " . $value['name'] . " ENDTIME: " . $endTime;
        foreach ($fixedEvents as $testValue) {
            $startTime = strtotime($testValue['start_time']);
//            echo "<br>EVENT: " . $testValue['name'] . " STARTTIME: " . $startTime;
            if ($startTime > $endTime && $startTime < $nextStartTime) {
                $nextStartTime = $startTime;
            }
            if ($endTime == $startTime) {
                break; //No need to add open time slot since there is an event directly after it.
            }
        }
//        echo "<br>NEXTSTARTTIME: " . $nextStartTime;
        if ($nextStartTime != PHP_INT_MAX) {
//            echo "<br>ADDEDTIMESLOT: " . $endTime . " DURATION: " . $nextStartTime - $endTime;

            $openTimeSlots[] = array($endTime, $nextStartTime - $endTime);
        }
    }


    $possibleEvents = array();

    function planEvents($duration, $events)
    {
//        echo "<br><br>DURATION: " . $duration;
        $temp = array();
        $temp['duration'] = 0;
        settype($temp['duration'], "integer");
        $temp['events'] = array();
        global $possibleEvents;
        $possibleEvents = array();
        nextEvent($duration, $events, $temp);
        $bestOption = $possibleEvents[0];
        foreach ($possibleEvents as $key => $value) {
            if ($value['duration'] > $bestOption['duration']) {
                $bestOption = $value;
            }
        }
        return $bestOption;
    }

    function nextEvent($duration, $events, $tempPossibleEvents)
    {
        foreach ($events as $key => $value) {
            $eventDuration = strtotime($value['end_time']) - strtotime($value['start_time']);
            $temp = $tempPossibleEvents;
//            echo "<br><br>";
//            print_r($temp);
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
//
//    echo "<br><br><br>PLANNINGS: ";

    $updateEvents = array();

    foreach ($openTimeSlots as $value) {
        $timeSlotPlanning = planEvents($value[1], $todayEvents);
        $startTime = $value[0];
        foreach ($timeSlotPlanning['events'] as $key => $value) {
            unset($todayEvents[$key]);
            $value['new_start_time'] = date('H:i', $startTime);
            $endTime = $startTime + (strtotime($value['end_time'])-strtotime($value['start_time']));
            $value['new_end_time'] = date('H:i', $endTime);
            $updateEvents[] = $value;
            $startTime = $endTime;
        }
//
//        print "<pre>";
//        print_r($timeSlotPlanning);
//        print "</pre><br><br>";
    }


    $query = $conn->prepare("UPDATE planning SET start_time = ?, end_time = ?, fixed = 1 WHERE userid = {$_SESSION['id']} AND name = ? AND description = ? AND location = ? AND start_time = ? AND end_time = ? AND fixed = 0");

    foreach ($updateEvents as $value) {
        $query->bind_param('sssssss', $value['new_start_time'], $value['new_end_time'], $value['name'], $value['description'], $value['location'], $value['start_time'], $value['end_time']);
        $query->execute();
    }

    $query = $conn->prepare("UPDATE planning SET invisible = 1 WHERE userid = {$_SESSION['id']} AND name = ? AND description = ? AND location = ? AND start_time = ? AND end_time = ? AND fixed = 0");

    foreach ($todayEvents as $value) {
        $query->bind_param('sssss', $value['name'], $value['description'], $value['location'], $value['start_time'], $value['end_time']);
        $query->execute();
    }
//
//
//    print "<br><br>ITEMS LEFT: <pre>";
//    print_r($todayEvents);
//    print "</pre><br><br>";
//
//
//    echo "<br><br>";
//
//    print_r($openTimeSlots);
//
//
//    echo "<br><br><br>";
}