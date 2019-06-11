<?php
/**
 * @author Wdarking <wdarking@gmail.com>
 */
class Wdarking_Contactform_Block_System_Config_Form_Field_Array_Subjectoptions extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * Initialize custom block options to
     * set form table options on module config
     */
    public function __construct()
    {
        $this->addColumn('code', array('label' => Mage::helper('adminhtml')->__('Code'),
                                             'style' => 'width:120px' ));

        $this->addColumn('title', array('label' => Mage::helper('adminhtml')->__('Title'),
                                              'style' => 'width:200px' ));

        $this->addColumn('email', array('label' => Mage::helper('adminhtml')->__('Email'),
                                        'style' => 'width:200px' ));

        $this->_addAfter       = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add option');

        parent::__construct();
    }
}

?>
