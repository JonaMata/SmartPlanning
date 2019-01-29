<?php
$query = $conn->prepare("SELECT processed FROM planning_processed WHERE userid = {$userid} AND date = {date('Y-m-d')}");
$query->execute();

$result = $query->get_result();

//while ($row = $result->fetch_array(MYSQLI_NUM)) {
//    if ($row[0] != 0) {


        $query = $conn->prepare("SELECT name, description, location, start_time, end_time FROM planning WHERE userid = {$_SESSION['id']} AND date = {date('Y-m-d')} ORDER BY start_time, end_time");
        $query->execute();

        $result = $query->get_result();

        $planningItems = array();

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            echo "<br>ADDED ROW";
            $planningItems[] = $row;
        }

        $fixedEvents = array();
        $openTimeSlots = array();


        foreach($fixedEvents as $value) {
            $nextStartTime = 0;
            $endTime = date('Hi');

            echo "<br>EVENT: ".$value[0]." ENDTIME: ".$endTime;
            foreach($fixedEvents as $testValue) {
                $startTime = date('Hi');
                echo "<br>EVENT: ".$testValue[0]." STARTTIME: ".$startTime;
                if($startTime > $endTime && $startTime < $nextStartTime) {
                    $nextStartTime = $startTime;
                }
                if($endTime == $startTime) {
                    break; //No need to add open time slot since there is an event directly after it.
                }
            }
            if($nextStartTime != 0) {
                echo "<br>ADDEDTIMESLOT: ".$endTime." DURATION: ".$nextStartTime-$endTime;
                $openTimeSlots[] = [$endTime, $nextStartTime-$endTime];
            }
        }

        foreach($openTimeSlots as $value){
            print_r($value);
        }


//        $query = $conn->prepare("INSERT userid, date, processed INTO planning_processed VALUES({$userid}, {date('Y-m-d')}, 1)");
//        $query->execute();
//    }
//}