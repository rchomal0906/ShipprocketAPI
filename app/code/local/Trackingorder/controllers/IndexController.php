<?php
class Ravi_Trackingorder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
		$this->loadLayout(); 
		$this->getLayout()->getBlock("head")->setTitle($this->__("Tracking Order"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("tailor", array(
                "label" => $this->__("Tracking Order"),
                "title" => $this->__("Tracking Order")
		   ));
    
		$this->renderLayout();
    }
	
	
	public function TrackOrderPostAction(){
		$post = $this->getRequest()->getPost();
		$customerOrderId = $post['orderid'];
		$resOrderAPI = Mage::helper('trackingorder')->callAPI('GET', 'https://apiv2.shiprocket.in/v1/external/orders?page=1&search='.$customerOrderId.'');
		$resOrderTArr = Mage::helper('core')->jsonDecode($resOrderAPI);	
		//echo '<pre>';
		//print_r($resOrderTArr);
		//echo '</pre>';
		//echo '</br>==========================</br>';
		$getAWBNumber = $resOrderTArr['data'][0]['shipments'][0]['awb'];
		$getCourierCompanyName = $resOrderTArr['data'][0]['shipments'][0]['courier'];
		$getCustomerNamePhone = $resOrderTArr['data'][0]['customer_name'].' / '.$resOrderTArr['data'][0]['customer_phone'];
		if($getAWBNumber){
			$resAWBAPI = Mage::helper('trackingorder')->callAPI('GET', 'https://apiv2.shiprocket.in/v1/external/courier/track/awb/'.$getAWBNumber.'');
			$resAwbDaata = Mage::helper('core')->jsonDecode($resAWBAPI);
			//echo '<pre>';
			//print_r($resAwbDaata);
			//echo '</pre>';
			//echo '</br>==========================</br>';
			$shipmentAWB = $resAwbDaata['tracking_data']['shipment_track'][0]['awb_code'];
			$orderNumber = $resAwbDaata['tracking_data']['shipment_track'][0]['order_id'];
			$currentStatus = $resAwbDaata['tracking_data']['shipment_track'][0]['current_status'];
			$pickupDate = $resAwbDaata['tracking_data']['shipment_track'][0]['pickup_date'];
			$deliveredTo = $resAwbDaata['tracking_data']['shipment_track'][0]['delivered_to'];
			$destination = $resAwbDaata['tracking_data']['shipment_track'][0]['destination'];
			$receivedBy = $resAwbDaata['tracking_data']['shipment_track'][0]['consignee_name'];
			$origin = $resAwbDaata['tracking_data']['shipment_track'][0]['origin'];
			$weight = $resAwbDaata['tracking_data']['shipment_track'][0]['weight'];
			$packages = $resAwbDaata['tracking_data']['shipment_track'][0]['packages'];
			$deliveredDate = $resAwbDaata['tracking_data']['shipment_track'][0]['delivered_date'];
			
			$trackingDetails = array();
			$trackingDetails = $resAwbDaata['tracking_data']['shipment_track_activities'];
			$showDeatils = '<div class="mailercontainer pb-xl ng-scope">
   <div class="header-infomation">
      <h2 class="text-normal inline m0 ng-binding">Order #'.$customerOrderId.'</h2>
   </div>
   <div class="mailer-block-">
      <h4 class="trackorder-deatils">Tracking Update for order no. '.$customerOrderId.' and AWB no. '.$shipmentAWB.'</h4></div>
   </div>
   <div class="mailer-block-" ng-hide="track_status == 0">
      <div class="col-md-6 col-sm-12 p0">
         <div class="bg-white">
            <h4 class="trackorder-deatils-title">Shipment Summary</h4>
            <div class="table-responsive b">
               <table class="table mb0 table-striped">
                  <tbody ng-repeat="ship in shippingDetails" class="ng-scope" style="">
                     <tr>
                        <th class="" align="left">Order Number</th>
                        <td class="ng-binding" align="left">'.$orderNumber.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Pickup Date</th>
                        <td class="ng-binding" align="left">'.$pickupDate.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Current Status</th>
                        <td class="ng-binding" align="left">'.$currentStatus.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Date of Delivery</th>';
						if($deliveredDate){
                         $showDeatils .='<td class="ng-binding" align="left">'.$deliveredDate.'</td>';
						}else{
						 $showDeatils .='<td class="ng-binding" align="left">Information not available</td>';			 
						}
                     $showDeatils .='</tr>
                     <tr>
                        <th class="" align="left">Delivered To</th>
                        <td class="ng-binding" align="left">'.$deliveredTo.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Origin City</th>
                        <td class="ng-binding" align="left">'.$origin.'</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-62 col-sm-12 p0">
         <div class="bg-white">
            <h4 class="trackorder-deatils-title">Shipment Details</h4>
            <div class="table-responsive b mb0">
               <table class="table mb0 table-striped">
                  <tbody ng-repeat="ship in shippingDetails" class="ng-scope" style="">
                     <tr>
                        <th class="" align="left">Number of Items</th>
                        <td class="ng-binding" align="left">'.$packages.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Weight</th>
                        <td class="ng-binding" align="left">'.$weight.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Received By</th>
                        <td class="ng-binding" align="left">'.$receivedBy.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Destination City</th>
                        <td class="ng-binding" align="left">'.$destination.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Shipment Type</th>
                        <td class="ng-binding" align="left">'.$getCourierCompanyName.'</td>
                     </tr>
                     <tr>
                        <th class="" align="left">Customer Details</th>
                        <td class="ng-binding" align="left">'.$getCustomerNamePhone.'</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="mailer-block text-center bg-white block-center">
      <div class="table-responsive b bb0">
         <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
               <td>
                  <div class="table-height scroll-table ng-binding">
                      <table class="table table-history table-striped mb0" width="100%">
                        <tbody><tr>
                           <th width="33.33%" align="left" class="p-lg bb text-normal">LOCATION</th>
                           <th width="33.33%" align="left" class="p-lg bb text-normal">DATE</th>
                           <th width="33.33%" align="left" class="p-lg bb text-normal">ACTIVITY</th>
                        </tr>';
                        foreach($trackingDetails as $details => $detail){
						$showDeatils .='<tr class="ng-scope" style="">
						   <td width="33.33%" align="left" class="p-lg ng-binding">'.$detail["location"].'</td>
                           <td width="33.33%" align="left" class="p-lg ng-binding">'.$detail["date"].'</td>
                           <td width="33.33%" align="left" class="p-lg ng-binding">'.$detail["activity"].'</td>
                        </tr>';
						}
                     $showDeatils .='</tbody></table>                     
                  </div>
               </td>
            </tr>
         </tbody></table>
      </div>
   </div>
</div>';
			echo $showDeatils;
		}else{
			echo '<div class="fieldset"><div class="text-tailor-page">Your shippment is not created yet for this order number.</div></div>';
		}
	}
}