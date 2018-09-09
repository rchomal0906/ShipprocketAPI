<?php

class Ravi_Trackingorder_Model_Mysql4_Trackingorder_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('trackingorder/trackingorder');
    }
}