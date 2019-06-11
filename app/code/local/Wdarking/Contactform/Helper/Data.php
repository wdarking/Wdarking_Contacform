<?php
/**
 * @author Wdarking <wdarking@gmail.com>
 */
class Wdarking_Contactform_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get module enabled config
     */
    public function getEnabled() {

        $configValue = Mage::getStoreConfig('wdk_contactform/wdk_contactform_config/wdk_contactform_enabled');

        if ($configValue) {
            return $configValue;
        }

        return false;
    }

    /**
     * Get contactform subjectptions config
     *
     * @return array options
     */
    public function getSubjectOptions() {

        $configValue = Mage::getStoreConfig('wdk_contactform/wdk_contactform_config/wdk_contactform_subjectoptions');

        if ($configValue) {
            return unserialize($configValue);
        }

        return false;
    }

    /**
     * Get selected subject email to send contact message
     *
     * @param  string $selectedSubject
     * @return string
     */
    public function getSubjectEmail($selectedSubject)
    {
        $allowedSubjects = $this->getSubjectOptions();

        $subjectEmail = null;

        foreach ($allowedSubjects as $subject) {
            if ($selectedSubject == $subject['code']) {
                $subjectEmail = $subject['email'];
            }
        }

        return $subjectEmail;
    }
}
