<?php

class Ravi_Trackingorder_Block_Adminhtml_Trackingorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'trackingorder';
        $this->_controller = 'adminhtml_trackingorder';
        
        $this->_updateButton('save', 'label', Mage::helper('trackingorder')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('trackingorder')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('trackingorder_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'trackingorder_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'trackingorder_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('trackingorder_data') && Mage::registry('trackingorder_data')->getId() ) {
            return Mage::helper('trackingorder')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('trackingorder_data')->getTitle()));
        } else {
            return Mage::helper('trackingorder')->__('Add Item');
        }
    }
}