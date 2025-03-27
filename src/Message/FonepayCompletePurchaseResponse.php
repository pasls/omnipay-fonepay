<?php
namespace Pasls\OmnipayFonepay\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class FonepayCompletePurchaseResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return mixed
     */
    public function getVerificationResponse()
    {
        return $this->verificationResponse;
    }

    /**
     * @{@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->data['status'] == true;
    }

    /**
     * @{@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->getPurchaseResponse()['UID'];
    }

    /**
     * @return mixed
     */
    public function getPurchaseRequest()
    {
        return $this->data['purchaseRequest'];
    }

    /**
     * @return mixed
     */
    public function getPurchaseResponse()
    {
        return $this->data['purchaseResponse'];
    }

} 