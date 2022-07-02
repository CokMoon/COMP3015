<?php
require "./interface/iReadWritable.php";
require "./classes/io/remoteReadWriter.php";

const READWRITER = new remoteReadWriter();
$courses = READWRITER->getCourses();
$courseList = "";

foreach ($courses as $course) {
    $checked = $course->complete ? "checked" : "";
    $img = empty($course->coursePic) ? "" :
        '<img src="' . $course->coursePic . '" alt="' . $course->name . ' course image">';


    $courseList .=
        '<li>' .
        '<input type="checkbox" name="' . $course->name . '" id="' . $course->name . '"' . $checked . '>' .
        '<label for="' . $course->name . '"></label>' .
        $img .
        '<p class="edit">' . $course->name . '</p>' .
        '<button name="delete" value="' . $course->name . '">X</button>' .
        '</li>';
}

require "index.view.php";
