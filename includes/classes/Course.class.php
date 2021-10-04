<?php 

class Course {
    // properties
    private $db;
    private $course_code;
    private $course_name;
    private $course_progression;
    private $course_syllabus;
    private $course_grade;

   // conustruct 
   function __construct() {
    $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
    // kontroll vid anslutning till servern.
    if ($this->db->connect_errno > 0) {
        die("Fel vid anslutning: " . $this->db->connect_error);
    }  
}


    // lägg till kurs. 
    public function setCourse( string $course_code, string $course_name, string $course_progression, string $course_syllabus, string $course_grade) : bool {
        $minValue = min(strlen($course_code), strlen($course_name),strlen($course_progression),strlen($course_syllabus), strlen($course_grade));
        if($minValue >= 1) {       
            $this->course_code = $course_code;
            $this->course_name = $course_name;
            $this->course_progression = $course_progression;
            $this->course_syllabus = $course_syllabus;
            $this->course_grade = $course_grade;
    
            $stmt = $this->db->prepare("INSERT INTO course_list (course_code, course_name, course_progression, course_syllabus, course_grade) VALUES(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $this->course_code, $this->course_name, $this->course_progression, $this->course_syllabus, $this->course_grade);
    
            if($stmt->execute()) {
                return true; 
            } else {
                return false;
            }
            $stmt->close();
    } else {
        return false;
    }


    }
      // hämta lista med kurser
      public function getCourses() : array {
        $sql = "SELECT * FROM course_list ORDER BY created DESC;";
        $result = $this ->db->query($sql);

        // array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // hämta ut spcefik kurs.
    public function getcourseById(int $id) : array {
        $id = intval($id);

        $sql = "SELECT * FROM course_list WHERE id=$id;";
        $result = $this ->db->query($sql);

        // array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // uppdatera kurs, måste ändra alla värden.
    public function updateCourse(int $id, string $course_code, string $course_name, string $course_progression, string $course_syllabus, string $course_grade) : bool {
    
        $this->course_code = $course_code;
        $this->course_name = $course_name;
        $this->course_progression = $course_progression;
        $this->course_syllabus = $course_syllabus;
        $this->course_grade = $course_grade;
        $id = intval($id);
  

        $stmt = $this->db->prepare("UPDATE course_list SET course_code=?, course_name=?, course_progression=?, course_syllabus=?, course_grade=? WHERE id=$id;");
        $stmt->bind_param("sssss", $this->course_code, $this->course_name, $this->course_progression, $this->course_syllabus, $this->course_grade);

        if($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
        $stmt->close();
      
  
    }
    
    // ta bort en kurs
    public function deleteCourse(int $id) : bool {
        $id = intval($id);
        $sql = "DELETE FROM course_list WHERE id=$id;";
        $result = mysqli_query($this->db, $sql); 
        return $result;
    } 


}