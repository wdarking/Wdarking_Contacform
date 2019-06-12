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
                $subjectRecipientEmail = Mage::helper('wdarking_contactform/data')->getSubjectEmail($selectedSubject);

                $dataObject = new Varien_Object();
                $dataObject->setData($data);

                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($data['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig('contacts/email/email_template'),
                        Mage::getStoreConfig('contacts/email/sender_email_identity'),
                        $subjectRecipientEmail,
                        null,
                        array('data' => $dataObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    Mage::log("Wdarking_Contactform_Model_Observer: could not send email to {$subjectRecipientEmail}");
                    Mage::log($data);
                }
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
