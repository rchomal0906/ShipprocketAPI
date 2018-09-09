<?php
class Ravi_Trackingorder_Helper_Data extends Mage_Core_Helper_Abstract
{

		public function callAPI($method, $url, $data){
			$res = Mage::helper('trackingorder')->callAPIGetToken('POST', 'https://apiv2.shiprocket.in/v1/external/auth/login','{"email": "rchomal09@gmail.com","password": "Rchomal09@123"}');
			$resArr = Mage::helper('core')->jsonDecode($res);	
			$Authtoken = trim($resArr['token']);
			   $curl = curl_init();
			   $token = "Bearer ".$Authtoken;
			   switch ($method){
				  case "POST":
					 curl_setopt($curl, CURLOPT_POST, 1);
					 if ($data)
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					 break;
				  case "PUT":
					 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
					 if ($data)
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
					 break;
				  default:
					 if ($data)
						$url = sprintf("%s?%s", $url, http_build_query($data));
			   }
			
			   // OPTIONS:
			   curl_setopt($curl, CURLOPT_URL, $url);
			   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				  'Content-Type: application/json',
				  'Authorization: '.$token
			   ));
			   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			
			   // EXECUTE:
			   $result = curl_exec($curl);
			   if(!$result){die("Connection Failure");}
			   curl_close($curl);
			   return $result;
		}
		
		public function callAPIGetToken($method, $url, $data){
				   $curl = curl_init();
				
				   switch ($method){
					  case "POST":
						 curl_setopt($curl, CURLOPT_POST, 1);
						 if ($data)
							curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
						 break;
					  case "PUT":
						 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
						 if ($data)
							curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
						 break;
					  default:
						 if ($data)
							$url = sprintf("%s?%s", $url, http_build_query($data));
				   }
				
				   // OPTIONS:
				   curl_setopt($curl, CURLOPT_URL, $url);
				   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					  "Content-Type: application/json"
				   ));
				   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				
				   // EXECUTE:
				   $result = curl_exec($curl);
				   if(!$result){die("Connection Failure");}
				   curl_close($curl);
				   return $result;
	 }

}