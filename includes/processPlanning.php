<?php

$query = $conn->prepare("SELECT fixed FROM planning WHERE userid = {$_SESSION['id']} AND date = ? AND fixed = 0 AND invisible = 0");
$query->bind_param('s', date('Y-m-d'));
$query->execute();

$result = $query->get_result();

if ($row = $result->fetch_array(MYSQLI_NUM)) {


    $query = $conn->prepare("SELECT name, description, location, start_time, end_time, fixed, can_next_day, invisible FROM planning WHERE userid = {$_SESSION['id']} AND date = ? ORDER BY start_time, end_time");
    $query->bind_param('s', date('Y-m-d'));
    $query->execute();

    $result = $query->get_result();


    $fixedEvents = array();
    $todayEvents = array();
    $somedayEvents = array();
    $somedayFixedEvents = array();

    while ($row = $result->fetch_assoc()) {
        if ($row['invisible'] == 1) break;
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

    $openTimeSlots = array();


    foreach ($fixedEvents as $value) {
        $nextStartTime = 2359;
        $endTime = date('Hi', strtotime($value['end_time']));

        foreach ($fixedEvents as $testValue) {
            $startTime = date('Hi', strtotime($testValue['start_time']));
            if ($startTime > $endTime && $startTime < $nextStartTime) {
                $nextStartTime = $startTime;
            }
            if ($endTime == $startTime) {
                break; //No need to add open time slot since there is an event directly after it.
            }
        }
        if ($nextStartTime != 2359) {
            $openTimeSlots[] = array($endTime, $nextStartTime - $endTime);
        }
    }


    $possibleEvents = array();

    function planEvents($duration, $events)
    {
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
            $eventDuration = date('Hi', strtotime($value['end_time'])) - date('Hi', strtotime($value['start_time']));
            $temp = $tempPossibleEvents;
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

    $updateEvents = array();

    foreach ($openTimeSlots as $value) {
        $timeSlotPlanning = planEvents($value[1], $todayEvents);
        foreach ($timeSlotPlanning['events'] as $key => $value) {
            unset($todayEvents[$key]);
            $updateEvents[] = $value;
        }
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

}