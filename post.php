<?php 

    // function processMessage($update) {
    //     if($update["result"]["action"] == "sayHello"){
    //         sendMessage(array(
    //             "source" => $update["result"]["source"],
    //             "speech" => "Hello from webhook",
    //             "displayText" => "Hello from webhook",
    //             "contextOut" => array()
    //         ));
    //     }
    // }
    
    // function sendMessage($parameters) {
    //     echo json_encode($parameters);
        
     
    // }
    
    $update_response = file_get_contents("php://input");
    $update = json_decode($update_response, true);
    
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $update_response);
    fclose($myfile);
    
    // if (isset($update["result"]["action"])) {
    //     processMessage($update);
    // }
    
    
    
    
?>