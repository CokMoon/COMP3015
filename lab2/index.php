<?php
function isLeapYear($year) {
    // leap year every 4 years but every 100 it's skip unless it's at the start of the leap cycle at every 400 years
    // echo $year%4 . " ";
    // echo $year%400 . " ";

    if($year % 100 === 0 && !($year % 400 == 0))
        return false;
    else if ($year % 4 === 0) 
        return true;
    else 
        return false;
}

function getDayOfTheWeek($year, $month, $day) {
    $monthCode = [  "Jan" => 1, "Feb" => 4, "Mar" => 4, 
                    "Apr" => 0, "May" => 2, "Jun" => 5, 
                    "Jul" => 0, "Aug" => 3, "Sep" => 6, 
                    "Oct" => 1, "Nov" => 4, "Dec" => 6  ];

    $dayOfTheWeek = [ "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

    $yearOffset = [1600 => 6, 1700 => 4, 1800 => 2, 2000 => 6, 2100 => 4];

    $leapYearOffset = 1;

    // Step 1: Only look at the last two digits of the year and determine how many 12s fit in it
    $step1Result = floor(substr($year, -2) / 12);
    // echo $step1Result ." ";

    // Step 2: Look at the remainder of this division:
    $step2Result = substr($year, -2) - 12 * $step1Result;
    // echo $step2Result." ";

    // Step 3: How many 4s fit into that remainder:
    $step3Result = floor($step2Result / 4);
    // echo $step3Result." ";

    // Step 4: Add the day of the month:
    $step4Result = $day;
    // echo $step4Result." ";
    
    // Step 5: Add the month code & any offsets:
    $step5Result = 0;

    // leap year offset
    if (isLeapYear($year))
        $step5Result--;
    
    // year offset
    if ($year >= 1600 && $year < 1700)
        $step5Result += $yearOffset[1600];
    else if ($year >= 1700 && $year < 1800)
        $step5Result += $yearOffset[1700];
    else if ($year >= 1800 && $year < 1900)
        $step5Result += $yearOffset[1800];
    else if ($year >= 2000 && $year < 2100)
        $step5Result += $yearOffset[2000];
    else if ($year >= 2100 && $year < 2200)
        $step5Result += $yearOffset[2100];
    
    // adding month code
    $step5Result += $monthCode[substr($month, 0, 3)];
    // echo $step5Result." ";

    // Step 6: Add all of the above numbers, then mod by 7:
    $step6Result = ($step1Result + $step2Result + $step3Result + $step4Result + $step5Result) % 7;
    // echo $step6Result." ";
    
    return $dayOfTheWeek[$step6Result]; 
}

function makeCalendar(){
    $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    $year = 2022;

    $daysInMonth30 = 30;
    $daysInMonth31 = 31;
    $daysInMonth28 = 28;

    foreach($months as $month) {
        if ($month === "Feb") {
            for($day = 1; $day <= $daysInMonth28; $day++)
                echo "$month $day, 2022 is a " . getDayOfTheWeek($year, $month, $day) ."<br>";
        } else if ($month === "Apr" || $month === "Jun" || $month === "Sep" || $month === "Nov") {
            for ($day = 1; $day <= $daysInMonth30; $day++)
                echo "$month $day, 2022 is a " . getDayOfTheWeek($year, $month, $day) . "<br>";
        } else {
            for ($day = 1; $day <= $daysInMonth31; $day++)
                echo "$month $day, 2022 is a " . getDayOfTheWeek($year, $month, $day). "<br>";
        }
    }
}

makeCalendar();