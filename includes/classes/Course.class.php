<?php 

class Course {
    // properties
    private $db;
    private $course_school;
    private $course_name;
    private $course_time;
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
    public function setCourse( string $course_school, string $course_name, string $course_time, string $course_syllabus, string $course_grade) : bool {
        $minValue = min(strlen($course_school), strlen($course_name),strlen($course_time),strlen($course_syllabus), strlen($course_grade));
        if($minValue >= 1) {       
            $this->course_school = $course_school;
            $this->course_name = $course_name;
            $this->course_time = $course_time;
            $this->course_syllabus = $course_syllabus;
            $this->course_grade = $course_grade;
    
            $stmt = $this->db->prepare("INSERT INTO course_list2 (course_school, course_name, course_time, course_syllabus, course_grade) VALUES(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $this->course_school, $this->course_name, $this->course_time, $this->course_syllabus, $this->course_grade);
    
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
        $sql = "SELECT * FROM course_list2 ORDER BY created DESC;";
        $result = $this ->db->query($sql);

        // array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // hämta ut spcefik kurs.
    public function getcourseById(int $id) : array {
        $id = intval($id);

        $sql = "SELECT * FROM course_list2 WHERE id=$id;";
        $result = $this ->db->query($sql);

        // array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // uppdatera kurs, måste ändra alla värden.
    public function updateCourse(int $id, string $course_school, string $course_name, string $course_time, string $course_syllabus, string $course_grade) : bool {
        
        $this->course_school = $course_school;
        $this->course_name = $course_name;
        $this->course_time = $course_time;
        $this->course_syllabus = $course_syllabus;
        $this->course_grade = $course_grade;
        $id = intval($id);
  
       
        $stmt = $this->db->prepare("UPDATE course_list2 SET course_school=?, course_name=?, course_time=?, course_syllabus=?, course_grade=? WHERE id=$id;");
        $stmt->bind_param("sssss", $this->course_school, $this->course_name, $this->course_time, $this->course_syllabus, $this->course_grade);

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
        $sql = "DELETE FROM course_list2 WHERE id=$id;";
        $result = mysqli_query($this->db, $sql); 
        return $result;
    } 


    // // setters 
    public function setCode(string $course_code) : bool {
        $course_code = strip_tags($course_code, "<br><i><em><b><strong><li><ul><ol>");
        if (strlen($course_code) > 3) {
            $this->course_code=$this->db->real_escape_string($course_code);
            return true;
        } else {
            return false;
        }
    }

    public function setName(string $course_name) : bool {
        $course_name = strip_tags($course_name, "<br><i><em><b><strong><li><ul><ol>");
        if (strlen($course_name) > 3) {
            $this->course_name=$this->db->real_escape_string($course_name);
            return true;
        } else {
            return false;
        }
    }

    public function setProg(string $course_progression) : bool {
        $course_progression = strip_tags($course_progression, "<br><i><em><b><strong><li><ul><ol>");
        if (strlen($course_progression) > 3) {
            $this->course_progression=$this->db->real_escape_string($course_progression);
            return true;
        } else {
            return false;
        }
    }

    public function setSyllabus(string $course_syllabus) : bool {
        $course_syllabus = strip_tags($course_syllabus, "<br><i><em><b><strong><li><ul><ol>");
        if (strlen($course_syllabus) > 3) {
            $this->course_syllabus=$this->db->real_escape_string($course_syllabus);
            return true;
        } else {
            return false;
        }
    }

    public function setGrade(string $course_grade) : bool {
        $course_grade = strip_tags($course_grade, "<br><i><em><b><strong><li><ul><ol>");
        if (strlen($course_grade) > 3) {
            $this->course_grade=$this->db->real_escape_string($course_grade);
            return true;
        } else {
            return false;
        }
    }

        // stäng
        function destructor() {
            mysqli_close($this->db);
        }
}