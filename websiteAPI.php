
<?php
include_once("includes/config.php");
// Detta är taget från teori och läsanvisningar. 

/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla) 
// uppladdad till filezilla med studenter.miun.se istället för *
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}


$website = new Website();

switch($method) {
    case 'GET':
        //Skickar en "HTTP response status code"
        http_response_code(200); //Ok - The request has succeeded

        $response = $website->getWebsite();
       
        // kontroll
        if(count($response) == 0) {
        //Lagrar ett meddelande som sedan skickas tillbaka till anroparen
        $response = array("message" => "There is nothing to get yet");
        
        }


        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));
        
        if($data->website_name == "" 
        || $data->website_url == "" 
        || $data->website_course ==""
        || $data->website_img ==""
        || $data->website_about =="") {
            $response = array("message"  => "Please enter the form." );
            http_response_code(400); //user error. Fel av användaren. 
        } else {
            if($website->setWebsite(
                $data->website_name, 
                $data->website_url, 
                $data->website_course,
                $data->website_img,
                $data->website_about)) {
                    // meddelande att det lyckats
                    $response = array("message" => "Created");
                    
                    http_response_code(201); //Created
                } else {
                    $response = array("message" => "Something went wrong");
                    
                    http_response_code(500); // server error. Felmeddelande om att det är fel backend.
                }
        }

        break;
    case 'PUT':
        //Om inget id är med skickat, skicka felmeddelande
        if(!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");
        
        //Om id är skickad   
        } else {
            $data = json_decode(file_get_contents("php://input"));

            if(
                $data->id ==""
            || $data->website_name == "" 
            || $data->website_url== "" 
            || $data->website_course ==""
            || $data->website_img ==""
            || $data->website_about=="") {
                $response = array("message"  => "Please enter the form." );
                
                http_response_code(400); //user error. Fel av användaren. 
            } else {
                if($website->updateWebsite(
                    $data->id,
                    $data->website_name,
                    $data->website_url,
                    $data->website_course,
                    $data->website_img,
                    $data->website_about)) {
                        // ok
                        http_response_code(200);
                        $response = array("message" => "website with id=$id is updated");
                        
                    } else {
                        // server error
                        http_response_code(503); 
                        $response=array("message" => "website not updated");
                     
                    }
            }
      }
        break;
    case 'DELETE':
        if(!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");  
            
            // om id skickas
        } else {
            // radera 
            if($website->deleteWebsite($id)) {
                http_response_code(200);
                $response = array("message" => "website with id=$id is deleted");
                
            } else {
                // server error
                http_response_code(503); 
                $response =array("message" =>"website not deleted.");
               
            }
          
        }
        break;
        
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);