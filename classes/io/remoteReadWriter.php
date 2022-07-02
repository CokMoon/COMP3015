<?php

class remoteReadWriter implements iReadWriteable
{
    // returns an array of course objects
    public function getCourses()
    {
        // ASSUME: json file already exist
        // read json file 
        $ContentObjects = json_decode(file_get_contents("database.json", true));
        return $ContentObjects->courses;
    }

    // update courses list
    private function updateCourseList(array $courses)
    {
        // write content to json file
        $ContentObjects = (object) ["courses" => $courses];
        file_put_contents("database.json", json_encode($ContentObjects, JSON_PRETTY_PRINT));
    }

    // check if course exist
    // return an array [bool - true (if found) false (not found), integer - when true index of course]
    private function courseExist(string $courseName)
    {
        $courses = $this->getCourses();

        for ($i = 0; $i < sizeof($courses); $i++) {
            if ($courseName === $courses[$i]->name) {
                return [TRUE, $i];
            }
        }
        return [FALSE, null];
    }

    // return true when ADDING course is successful otherwise false 
    public function addCourse(course $newCourse)
    {
        $courses = $this->getCourses();

        // create course object
        $newCourseObject = (object) array(
            "name"      => $newCourse->getName(),
            "complete"  => $newCourse->getStatus(),
            "coursePic" => $newCourse->getCoursePic(),
        );

        // if the data does not currently exists add to database
        [$courseExist, $courseIndex] = $this->courseExist($newCourseObject->name);

        if (!$courseExist) {
            array_push($courses, $newCourseObject);
            $this->updateCourseList($courses);
            return TRUE;
        }
        return FALSE;
    }

    // return true when DELETEING course is successful otherwise false 
    public function deleteCourse(string $courseName)
    {
        $courses = $this->getCourses();
        [$courseExist, $courseIndex] = $this->courseExist($courseName);

        // check if course exist
        if ($courseExist) {
            // remove saved course picture if it exist
            if (!empty($courses[$courseIndex]->coursePic)) {
                unlink($courses[$courseIndex]->coursePic);
            }

            // removes course item from array (messes up array indexes)
            unset($courses[$courseIndex]);
            // reset array index
            $courses = array_values($courses);
            $this->updateCourseList($courses);
            return TRUE;
        }
        return FALSE;
    }

    // return true when EDITING course is successful otherwise false 
    public function editCourse(string $courseName, string $newCourseName)
    {
        $courses = $this->getCourses();
        $newCourse = new course($newCourseName, FALSE, "");
        [$oldCourseExist, $oldCourseIndex] = $this->courseExist($courseName);
        [$newCourseExist, $newCourseIndex] = $this->courseExist($newCourseName);

        // make sure the (old) course that is being edit exist
        // and the new course name does not already exist 
        // and new course is created successfuly
        if ($oldCourseExist && !$newCourseExist && $newCourse) {
            $courses[$oldCourseIndex]->name = $newCourse->getName();
            $this->updateCourseList(($courses));
            return TRUE;
        }
        return FALSE;
    }

    // return true when EDITING course is successful otherwise false 
    public function completeCourse(string $courseName, bool $status)
    {
        $courses = $this->getCourses();
        $course = new course($courseName, $status, "");
        [$courseExist, $courseIndex] = $this->courseExist($courseName);
        $newCourse = new course($courseName, $status, "");

        // if course exist and new course is created successfuly
        if ($courseExist && $course) {
            $courses[$courseIndex]->complete = $newCourse->getStatus();
            $this->updateCourseList(($courses));
            return TRUE;
        }
        return FALSE;
    }
}
