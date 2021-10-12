<?php 

class Website {
    // properties
    private $db;
    private $website_name;
    private $website_url;
    private $website_course;
    private $website_img;
    private $website_about;

       // conustruct 
   function __construct() {
    $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
    // kontroll vid anslutning till servern.
    if ($this->db->connect_errno > 0) {
        die("Fel vid anslutning: " . $this->db->connect_error);
    }  
}


// lägg till webbplats.
public function setWebsite(string $website_name, string $website_url, string $website_course, string $website_img, string $website_about) :bool {
    $minValue =min(strlen($website_name), strlen($website_url), strlen($website_course), strlen($website_img), strlen($website_about));
    if($minValue >= 1) {
        $this->website_name = $website_name;
        $this->website_url = $website_url;
        $this->website_course = $website_course;
        $this->website_img = $website_img;
        $this->website_about = $website_about;

        $stmt = $this->db->prepare("INSERT INTO website_list (website_name, website_url, website_course, website_img, website_about) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $this->website_name, $this->website_url, $this->website_course, $this->website_img, $this->website_about);

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

// hämta webbplats
public function getWebsite() : array {
    $sql = "SELECT * FROM website_list ORDER BY created DESC;";
    // skicka
    $result = $this->db->query($sql);

    // array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// hämta enskild webbplats
public function getWebSiteById(int $id) : array {
    $id = intval($id);
    // fråga
    $sql = "SELECT * FROM website_liste WHERE id=$id;";
    // skicka
    $result = $this->db->query($sql);
    // array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// uppdatera webbplats
public function updateWebsite(int $id, string $website_name, string $website_url, string $website_course, string $website_img, string $website_about): bool {
    $this->website_name = $website_name;
    $this->website_url = $website_url;
    $this->website_course=$website_course;
    $this->website_img=$website_img;
    $this->website_about=$website_about;
    $id=intval($id);

    $stmt = $this->db->prepare("UPDATE website_list SET website_name=?, website_url=?, website_course=?, website_img=?, website_about=? WHERE id=$id;");
    $stmt->bind_param("sssss", $this->website_name, $this->website_url, $this->website_course, $this->website_img, $this->website_about);

    if($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

public function deleteWebsite(int $id) : bool {
    $id=intval($id);
    $sql = "DELETE FROM website_list WHERE id=$id;";
    $result = mysqli_query($this->db, $sql);
    return $result;
}

    // stäng
    function destructor() {
        mysqli_close($this->db);
    }
}

