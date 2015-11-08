<?php
  require_once("socrata.php");
 
  
class ajaxValidate {
	
        function formValidate() {
			
	$view_uid = "cdan-uybe";//"5fy3-sjg8";//"ypyx-bcrh";//"ykw4-j3aj";
  $root_url = "https://brigades.opendatanetwork.com";//"https://data.austintexas.gov";
  $app_token = "dyTNWsNZzxuGgo6FduT0JUzcx";//"B0ixMbJj4LuQVfYnz95Hfp3Ni";
                //Put form elements into post variables (this is where you would sanitize your data)
                $zipcode = @$_POST['zipcode'];
                //Establish values that will be returned via ajax
                $return = array();
                $return['msg'] = '';
                $return['error'] = false;
                //Begin form validation functionality
                if (!isset($zipcode) || empty($zipcode)){
                        $return['error'] = true;
                        $return['msg'] .= '<li>Error: Field1 is empty.</li>';
                }
                //Begin form success functionality
                if ($return['error'] === false){
					// Create a new unauthenticated client
    $socrata = new Socrata($root_url, $app_token);
	
    //$params = array("\$where" => "within_circle(location_1, $latitude, $longitude, $range)");
	$params = array("zip_code"=>$zipcode);//"within_circle(location_1, $zipcode, $longitude, $range)");
	
    $response = $socrata->get("/resource/$view_uid.json", $params);
                        $return['msg'] = '<li>Success Message</li>';
						
						$return['data'] = $response;
                }
                //Return json encoded results
                return json_encode($return);
        }
}
$ajaxValidate = new ajaxValidate;
echo $ajaxValidate->formValidate();
?>