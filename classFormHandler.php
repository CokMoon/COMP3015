<?php
require "./interface/iReadWritable.php";
require "./classes/io/remoteReadWriter.php";
require "./classes/course.php";

const FILE_TYPE = "image/png";
const MAX_FILESIZE = 20000000;

const READWRITER = new remoteReadWriter();
print_r($_POST);

// ASSUME: json file already exist
// read json file with all the courses
$courses = READWRITER->getCourses();

if (!isset($_POST['classInput'])) {
    die("<h2>Please enter a course name</h2>");
}

$courseName = strtoupper(trim($_POST['classInput']));

// create course object
$newCourse = new course($courseName, FALSE, "");

// if image exist add it to the course info
if (isset($_FILES['coursePic']) && $_FILES['coursePic']['type'] == FILE_TYPE && $_FILES['coursePic']['size'] <= MAX_FILESIZE) {
    // global $course;

    $coursePicLocation = "upload/" . md5(time() . $_FILES["coursePic"]["name"]) . ".png";
    move_uploaded_file($_FILES["coursePic"]["tmp_name"], $coursePicLocation);

    $newCourse->setCoursePic($coursePicLocation);
}

// add to new course to database
if (!empty($_POST['classInput'])) {
    READWRITER->addCourse($newCourse);
}

// check which course are compeleted
foreach ($courses as $course) {
    if (isset($_POST[$course->name])) {
        if ($_POST[$course->name] === "on")
            READWRITER->completeCourse($course->name, TRUE);
    } else
        READWRITER->completeCourse($course->name, FALSE);
}

// check if course is deleted
if (isset($_POST["delete"])) {
    READWRITER->deleteCourse($_POST["delete"]);
}

// check which course is edited
if (isset($_POST["original"]) && isset($_POST["edited"])) {
    READWRITER->editCourse($_POST["original"], $_POST["edited"]);
}

// print_r($ContentArray);
header("location: index.php");
exit();
