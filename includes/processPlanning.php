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

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    echo "<br>ADDED ROW";
    if ($row[6] == 1 && $row[5] == 0) {
        $somedayFixedEvents[] = $row;
    } else if ($row[6] == 1) {
        $somedayEvents[] = $row;
    } else if ($row[5] == 0) {
        $todayEvents[] = $row;
    } else {
        $fixedEvents[] = $row;
    }
}

echo "<br><br>";

print_r($fixedEvents);

$openTimeSlots = array();


foreach ($fixedEvents as $value) {
    $nextStartTime = 2359;
    $endTime = date('Hi', strtotime($value[4]));

    echo "<br>EVENT: " . $value[0] . " ENDTIME: " . $endTime;
    foreach ($fixedEvents as $testValue) {
        $startTime = date('Hi', strtotime($testValue[3]));
        echo "<br>EVENT: " . $testValue[0] . " STARTTIME: " . $startTime;
        if ($startTime > $endTime && $startTime < $nextStartTime) {
            $nextStartTime = $startTime;
        }
        if ($endTime == $startTime) {
            break; //No need to add open time slot since there is an event directly after it.
        }
    }
    echo "<br>NEXTSTARTTIME: ".$nextStartTime;
    if ($nextStartTime != 2359) {
        echo "<br>ADDEDTIMESLOT: " . $endTime . " DURATION: " . $nextStartTime - $endTime;
        $openTimeSlots[] = array($endTime, $nextStartTime - $endTime);
    }
}

echo "<br><br>";

print_r($openTimeSlots);


echo "<br><br><br>";

//        $query = $conn->prepare("INSERT userid, date, processed INTO planning_processed VALUES({$userid}, {date('Y-m-d')}, 1)");
//        $query->execute();
//    }
//}