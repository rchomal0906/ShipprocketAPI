<?php

class Ravi_Trackingorder_Block_Adminhtml_Trackingorder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('trackingorder_form', array('legend'=>Mage::helper('trackingorder')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('trackingorder')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('trackingorder')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('trackingorder')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('trackingorder')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('trackingorder')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('trackingorder')->__('Content'),
          'title'     => Mage::helper('trackingorder')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getTrackingorderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTrackingorderData());
          Mage::getSingleton('adminhtml/session')->setTrackingorderData(null);
      } elseif ( Mage::registry('trackingorder_data') ) {
          $form->setValues(Mage::registry('trackingorder_data')->getData());
      }
      return parent::_prepareForm();
  }
}