<?php
namespace Pasls\OmnipayFonepay\Message;


use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractFonepayRequest extends AbstractRequest
{
    private $testEndpoint = 'https://dev-clientapi.fonepay.com/api/merchantRequest';
    private $liveEndpoint = 'https://clientapi.fonepay.com/api/merchantRequest';

    private $testVerifyUrl = "https://dev-clientapi.fonepay.com/api/merchantRequest/verificationMerchant";
    private $liveVerifyUrl = "https://clientapi.fonepay.com/api/merchantRequest/verificationMerchant";

    public function getServiceCode()
    {
        return $this->getParameter('serviceCode');
    }

    public function setServiceCode($serviceCode)
    {
        $this->setParameter("serviceCode", $serviceCode);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getVerifyEndpoint()
    {
        return $this->getTestMode() ? $this->testVerifyUrl : $this->liveVerifyUrl;
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($secretKey)
    {
        $this->setParameter("secretKey", $secretKey);
    }
}