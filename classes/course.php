<?php
class course
{
    private string  $name;
    private string  $coursePic;
    private bool    $status;
    private string  $namePattern = "/\b([A-Z]{4}\d{4})\b/";

    public function __construct(string $name, bool $status, string $coursePic)
    {
        $this->setName($name);
        $this->setStatus($status);
        $this->setCoursePic($coursePic);
    }

    public function getName()
    {
        return $this->name;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCoursePic()
    {
        return $this->coursePic;
    }

    // return true when name is added otherwise return false
    // only add name when it in this formate: [A-Z][A-Z][A-Z][A-Z]/d/d/d/d
    // ie. COMP4023
    public function setName(string $name)
    {
        $name = strtoupper(trim($name));
        if (!empty($name) && preg_match($this->namePattern, $name)) {
            $this->name = $name;
            return TRUE;
        }
        return FALSE;
    }

    public function setStatus(bool $status)
    {
        $this->status = $status;
    }

    public function setCoursePic(string $coursePic)
    {
        $this->coursePic = $coursePic;
    }
}
