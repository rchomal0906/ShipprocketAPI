<?php

class Ravi_Trackingorder_Model_Mysql4_Trackingorder extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the trackingorder_id refers to the key field in your database table.
        $this->_init('trackingorder/trackingorder', 'trackingorder_id');
    }
}