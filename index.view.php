<?php require "header.php"; ?>

<h1>My Classes</h1>
<!-- <a href="./pages/myClass/classList.php">To My Class List</a> -->
<form enctype="multipart/form-data" method="post" action="./classFormHandler.php">
    <input type="text" name="classInput" id="classInput" placeholder="ex - COMP3015">
    <input type="submit" value="ADD" id="add">
    <input type="file" name="coursePic" id="coursePic">

    <ul id="myCourses">
        <?= $courseList ?>
    </ul>
</form>

<?php require "footer.php"; ?>