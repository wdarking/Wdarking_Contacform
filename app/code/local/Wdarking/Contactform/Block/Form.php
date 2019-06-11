<?php
/**
 * @author Wdarking <wdarking@gmail.com>
 */
class Wdarking_Contactform_Block_Form extends Mage_Core_Block_Template
{
    /**
     * Initialize custom to set custom
     * template on module enabled.
     */
    public function __construct()
    {
        parent::__construct();

        if (Mage::helper('wdarking_contactform/data')->getEnabled()) {
            $this->setTemplate('wdarking/contacts/form.phtml');
        }
    }

    /**
     * Get config contact options and unserialize
     */
    public function getContactOptions()
    {
        $options = Mage::helper('wdarking_contactform/data')->getSubjectOptions();

        return $options;
    }
}
