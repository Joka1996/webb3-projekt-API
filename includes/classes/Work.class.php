<?php 

class Work{
    // properties
    private $db;
    private $work_place;
    private $work_year;
    private $work_title;

   // conustruct 
   function __construct() {
    $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
    // kontroll vid anslutning till servern.
    if ($this->db->connect_errno > 0) {
        die("Fel vid anslutning: " . $this->db->connect_error);
    }  
}

    // lägg till jobb
    public function setWork(string $work_place, string $work_year, string $work_title) : bool {
        $minValue = min(strlen($work_place), strlen($work_year), strlen($work_title));
        if($minValue >= 1 ){
            $this->work_place = $work_place;
            $this->work_year = $work_year;
            $this->work_title = $work_title;

            $stmt = $this->db->prepare("INSERT INTO work_list (work_place, work_year, work_title) VALUES(?,?,?)");
            $stmt ->bind_param("sss", $this->work_place, $this->work_year, $this->work_title);
            
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

    // hämta jobb
    public function getWork() : array{
        $sql = "SELECT * FROM work_list ORDER BY created DESC;";
        $result =$this->db->query($sql);

        // array 
        return $result-> fetch_all(MYSQLI_ASSOC);
    }

    // uppdatera 
    public function updateWork(int $id, string $work_place, string $work_year, string $work_title) : bool {
        $this->work_place=$work_place;
        $this->work_year=$work_year;
        $this->work_title=$work_title;
        $id=intval($id);
        // prepared statement 
        $stmt=$this->db->prepare("UPDATE work_list SET work_place=?, work_year=?, work_title=? WHERE id=$id;");
        $stmt->bind_param("sss", $this->work_place, $this->work_year, $this->work_title);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // ta bort 
    public function deleteWork($id) : bool {
        $id = intval($id);
        $sql = "DELETE FROM work_list WHERE id=$id;";
        $result = mysqli_query($this->db,$sql);
        return $result;
    }
    // stäng
    function destructor() {
        mysqli_close($this->db);
    }

}