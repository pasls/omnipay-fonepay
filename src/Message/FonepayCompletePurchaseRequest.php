<?php
namespace Pasls\OmnipayFonepay\Message;


use GuzzleHttp\Exception\RequestException;

class FonepayCompletePurchaseRequest extends AbstractFonepayRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [];
    }

    private function verifyPayment($data)
    {
        $query = [
            'PRN'   =>  $data['PRN'],
            'PID'   =>  $this->getServiceCode(),
            'BID'   =>  $data['BID'] ?? '',
            'AMT'   =>  $this->getAmount(),
            'RU'   =>  $this->getReturnUrl(),
            'UID'   =>  $data['UID'],
            'DV'   =>  hash_hmac("sha512",join(",", [
                $data['PRN'],
                $this->getServiceCode(),
                $data['PS'],
                $data['RC'],
                $data['UID'],
                $data['BC'],
                $data['INI'],
                $data['P_AMT'],
                $data['R_AMT'],
            ]) , $this->getSecretKey())
        ];

        if(strtoupper($query['DV']) == $data['DV'] && $data['RC'] == 'successful'){
            return [
                'status' => true,
                'purchaseRequest' => $query,
                'purchaseResponse' => $data
            ];
        }

        return [
            'status' => false,
            'purchaseRequest' => $query,
            'purchaseResponse' => $data
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $response =  $this->verifyPayment($data);

        return $this->response = new FonepayCompletePurchaseResponse($this, $response);
    }

}