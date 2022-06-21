<?php
const FILE_TYPE = "image/png";
const MAX_FILESIZE = 200000;

print_r($_POST);

// determine if the data exists
if (!isset($_POST['classInput'])) {
    die("<h2>Please enter a course name</h2>");
}

$courseName = strtoupper(trim($_POST['classInput']));

// if course name not empty add to array

$course = (object) array(
    "name" => $courseName,
    "complete" => FALSE,
    "coursePic" => "",
);

// if image exist
if (isset($_FILES['coursePic']) && $_FILES['coursePic']['type'] == FILE_TYPE && $_FILES['coursePic']['size'] <= MAX_FILESIZE) {
    global $course;

    $coursePicLocation = "upload/" . md5(time() . $_FILES["coursePic"]["name"]) . ".png";
    move_uploaded_file($_FILES["coursePic"]["tmp_name"], $coursePicLocation);

    $course->coursePic = $coursePicLocation;
}

// ASSUME: json file already exist
// read json file 
$ContentObjects = json_decode(file_get_contents("database.json", true));
$ContentArray = $ContentObjects->courses;

if (!empty($course->name))
    array_push($ContentArray, $course);

// check which course are compeleted
foreach ($ContentArray as $courses => $course) {
    if (isset($_POST[$course->name])) {
        $course->complete = TRUE;
    } else if (isset($_POST["delete"])) {
        if ($_POST["delete"] == $course->name) {
            unset($ContentArray[$courses]);
            $ContentArray = array_values($ContentArray);
        }
    } else {
        $course->complete = FALSE;
    }
}
print_r($ContentArray);
// check if course is deleted
// write content to json file
$ContentObjects = (object) ["courses" => $ContentArray];
file_put_contents("database.json", json_encode($ContentObjects, JSON_PRETTY_PRINT));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style.css">
    <script src="scripts\myClasses.js" defer></script>
    <title>COMP3015 | Lab 5</title>
</head>

<body>
    <div id="wrapper">
        <h1>My Classes</h1>

        <form enctype="multipart/form-data" method="post" action="main.php">
            <input type="text" name="classInput" id="classInput" placeholder="ex - COMP3015">
            <input type="submit" value="ADD" id="add">
            <input type="file" name="coursePic" id="coursePic">

            <ul id="myCourses">

                <?php
                foreach ($ContentArray as $courses => $course) {
                    $checked = $course->complete ? "checked" : "";

                    echo '<li>' .
                        '<input type="checkbox" name="' . $course->name . '" id="' . $course->name . '"' . $checked . '>' .
                        '<label for="' . $course->name . '">' . $course->name . '</label>' .
                        '<input type="submit" class="delete" id="delete" name="delete" value="' . $course->name . '">' .
                        '<label id="deleteLabel" for="delete">X</label></li>';
                }
                ?>
            </ul>
        </form>
    </div>


</body>

</html>