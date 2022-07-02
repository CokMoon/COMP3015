<?php

interface iReadWriteable
{
    public function getCourses();
    public function addCourse(course $course);
    public function deleteCourse(string $courseName);
    public function editCourse(string $courseName, string $newCourseName);
    public function completeCourse(string $courseName, bool $status);
}
