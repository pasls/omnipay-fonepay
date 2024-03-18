<?php
namespace Pasls\OmnipayFonepay\Message;


use Omnipay\Common\Message\ResponseInterface;

class FonepayPostAuthorizeRequest extends AbstractFonepayRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = array();
        $data['PID'] = $this->getServiceCode();
        $data['MD'] = "P";
        $data['PRN'] = $this->getTransactionId();
        $data['AMT'] = $this->getAmount();
        $data['CRN'] = "NPR";
        $data['DT'] = date("m/d/Y"); // MM/dd/yyyy
        $data['R1'] = "remark1";
        $data['R2'] = "remark2";
        $data['RU'] = $this->getReturnUrl();

        $signatureData = "";
        $data['DV'] = hash_hmac("sha512",join(",", [
            $data['PID'],
            $data['MD'],
            $data['PRN'],
            $data['AMT'],
            $data['CRN'],
            $data['DT'],
            $data['R1'],
            $data['R2'],
            $data['RU']
        ]) , $this->getSecretKey());
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        return $this->response = new FonepayAuthorizeResponse($this, $data, $this->getEndpoint());
    }

} 