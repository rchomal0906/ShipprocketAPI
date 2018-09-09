<?php
class Ravi_Trackingorder_Block_Trackingorder extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTrackingorder()     
     { 
        if (!$this->hasData('trackingorder')) {
            $this->setData('trackingorder', Mage::registry('trackingorder'));
        }
        return $this->getData('trackingorder');
        
    }
	
	public function getFormAction()
    {
        return $this->getUrl('trackingorder/index/TrackOrderPost');
    }	
}