<?php
namespace Pasls\OmnipayFonepay;


use Omnipay\Common\AbstractGateway;

class FonepayGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "Fonepay";
    }

    public function getDefaultParameters()
    {
        return [
            'serviceCode'   =>  "",
            'testMode'      =>  false,
            "secretKey"     =>  ""
        ];
    }

    public function switchToTestMode()
    {
        $this->setParameter('testMode', true);
    }

    public function switchToLiveMode()
    {
        $this->setParameter('testMode', false);
    }

    public function getServiceCode()
    {
        return $this->getParameter('serviceCode');
    }

    public function setServiceCode($serviceCode)
    {
        $this->setParameter("serviceCode", $serviceCode);
    }


    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($secretKey)
    {
        $this->setParameter("secretKey", $secretKey);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Pasls\OmnipayFonepay\Message\FonepayPostAuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Pasls\OmnipayFonepay\Message\FonepayCompletePurchaseRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Pasls\OmnipayFonepay\Message\FonepayPostAuthorizeRequest', $parameters);
    }
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Pasls\OmnipayFonepay\Message\FonepayCompletePurchaseRequest', $parameters);
    }
} 