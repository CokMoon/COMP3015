
<?php
// The form processing should include the following validation:
// Any problems detected during form validation should result in displaying the HTML form again, including descriptive error messages so that the user can learn how to fill out the form correctly.

const MIN_USERNAME_LENGTH = 2;
const KEY_CODE = "bcit";
const NO_LANGUAGE_SELECTED = "You are not studying any computer language(s)";
const MORE_THAN_TWO_LANGUAGE_SELECTED = "You are multilingual";
const MORE_THAN_FIVE_LANGUAGE_SELECTED = "Impressive. You have been studying quite a few computing languages";
const BCIT_STUDENT_NUMBER_PATTERN = "/^((A|a)0)\d{7}$/";

$htmForm = file_get_contents("./index.html");

var_dump($_POST);

// determine if the data exists: (A gender must be selected)
if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["gender"]) || !isset($_POST["gender"])) {
    echo $htmForm;
    die("Error: Make sure username, password, student number and gender fields are filled in!");
}

$username = trim($_POST["username"]);
$password = $_POST["password"];
$studentNum = trim($_POST["studentNum"]);
$gender = $_POST["gender"];


//     - Username field must be 2 characters or more
if (strlen($username) < 2) {
    echo $htmForm;
    die("Error: Make sure username is aleast 2 characters long!");
}

//     - Password field must match the lowercase string “bcit”
if($password !== KEY_CODE) {
    echo $htmForm;
    die("Error: The password is incorrect");
}

//     - Student number must match BCIT student number pattern: A0nnnnnnn
if(!preg_match(BCIT_STUDENT_NUMBER_PATTERN, $studentNum)) {
    echo $htmForm;
    die("Error: Student number must match BCIT student number pattern: A0nnnnnnn");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3: Form Processed</title>
</head>
<body>
    <?php
    // If all the form data is valid, 
//     - display a specific message using the data from the username field, eg: Hello, Ms. Username! (Or Mr. Username if they selected male)
if ($gender === "male")
    echo "<h1>Hello, Mr.$username!</h1>";
else
    echo "<h1>Hello, Ms.$username!</h1>";

//     - If no computer language checkboxes were chosen, display the message “You are not studying any computer language(s)”
//     - If one or more computer languages were chosen, display all of them in an HTML list. Also, if the user chose more than 2, display “You are multilingual”.
//     If the user chose more than 5, display “Impressive. You have been studying quite a few computing languages” 
if(isset($_POST["codes"])){
    $codes = $_POST["codes"];
    
    // ul list 
    echo "<ul>Here are all the computer lanuages are you studying:";
    foreach($codes as $code) 
        echo "<li>$code</li>";
    echo "</ul>";

    //speical message base on # of programing lanaguages
    if((count($codes) > 2) && (count($codes) <= 5)) 
        echo "<h2>You are multilingual</h2>";
    else if (count($codes) > 5)
        echo "<h2>Impressive. You have been studying quite a few computing languages</h2>";
} else {
    echo "<p>You are not studying any computer language(s)</p>";
}

    ?>

</body>
</html>


