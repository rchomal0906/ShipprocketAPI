<?php
class Ravi_Trackingorder_Block_Adminhtml_Trackingorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_trackingorder';
    $this->_blockGroup = 'trackingorder';
    $this->_headerText = Mage::helper('trackingorder')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('trackingorder')->__('Add Item');
    parent::__construct();
  }
}