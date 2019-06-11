<?php
/**
 * @author Wdarking <wdarking@gmail.com>
 */
class Wdarking_Contactform_Model_Observer extends Mage_Captcha_Model_Observer
{
    /**
     * Observe contacts page form submit
     */
    public function checkContactPage($observer)
    {
        $formId = 'contact_page_captcha';

        $controller = $observer->getControllerAction();

        if ($data = $controller->getRequest()->getPost()) {
            if (isset($data['wdk_contactform_subject'])) {
                $selectedSubject = $data['wdk_contactform_subject'];
                $subjectEmail = Mage::helper('wdarking_contactform/data')->getSubjectEmail($selectedSubject);

                $data['email'] = $subjectEmail;

                $controller->getRequest()->setPost($data);
            }
        }

        $captchaModel = Mage::helper('captcha')->getCaptcha($formId);
        if ($captchaModel->isRequired()) {
            if (!$captchaModel->isCorrect($this->_getCaptchaString($controller->getRequest(), $formId))) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                $controller->getResponse()->setRedirect(Mage::getUrl('*/*/'));
            }
        }
        return $this;
    }
}
