<?php

class Ravi_Trackingorder_Model_Trackingorder extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('trackingorder/trackingorder');
    }
}