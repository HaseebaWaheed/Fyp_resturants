<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
class NewTarget extends CI_Controller{

    private $access_key 	= "d37e1cb911af439f2c8e7e6fd97b6e9e1dc6a166";
	private $secret_key 	= "64a53ab8f403911bcace71c34053db5f04f2558c";
	
	//private $targetId 		= "eda03583982f41cdbe9ca7f50734b9a1";
	private $url 			= "https://vws.vuforia.com";
	private $requestPath 	= "/targets";
	private $request;       // the HTTP_Request2 object
	private $jsonRequestObject;
	
	private $targetName 	= "[ name ]";
	private $imageLocation 	= "[ /path/file.ext ]";
    
    function __construct() {
        parent::__construct();
    }

    function getImageAsBase64(){
		
		$file = file_get_contents( $this->imageLocation );
		
		if( $file ){
			
			$file = base64_encode( $file );
		}
		
		return $file;
	
	}

	function setTargetName($TargetName){
		$targetName=$TargetName;
	}

	function setPath($ImagePath){
		$imageLocation=$ImagePath;
	}

		function executeQuery(){
			$this->jsonRequestObject = json_encode( array(
				'width'=>320.0 , 'name'=>$this->targetName ,
				'image'=>$this->getImageAsBase64() ,
				'application_metadata'=>base64_encode("Vuforia test metadata") 
				, 'active_flag'=>1 ) );

		$this->execPostNewTarget();
		}
		
	public function execPostNewTarget(){

		$this->request = new HTTP_Request2();
		$this->request->setMethod( HTTP_Request2::METHOD_POST );
		$this->request->setBody( $this->jsonRequestObject );

		$this->request->setConfig(array(
				'ssl_verify_peer' => false
		));

		$this->request->setURL( $this->url . $this->requestPath );

		// Define the Date and Authentication headers
		$this->setHeaders();


		try {

			$response = $this->request->send();

			if (200 == $response->getStatus() || 201 == $response->getStatus() ) {
				echo $response->getBody();
			} else {
				echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
						$response->getReasonPhrase(). ' ' . $response->getBody();
			}
		} catch (HTTP_Request2_Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}


	}

	private function setHeaders(){
        $this->load->library('SignatureBuilder');
		$sb = 	new SignatureBuilder();
        try {
            $date = new DateTime("now", new DateTimeZone("GMT"));
        } catch (Exception $e) {
        }
		$header[] = ['Date'=>$date->format("D, d M Y H:i:s") . " GMT" ];
        $header[] = ["Content-Type"=> "application/json" ];
        $header[] = ["Authorization"  => "VWS " . $this->access_key . ":" . $this->SignatureBuilder->tmsSignature( $header , $this->secret_key )];

	}

}
?>