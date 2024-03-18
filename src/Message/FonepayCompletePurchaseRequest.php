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
                $this->getServiceCode(),
                $this->getAmount(),
                $data['PRN'],
                $data['BID'] ?? '',
                $data['UID'],
            ]) , $this->getSecretKey())
        ];

        try{
            $response = $this->httpClient->request('GET', $this->getVerifyEndpoint()."?".http_build_query($query));
            $raw = $response->getBody()->getContents();
            $data['purchaseResponse'] = (string) $raw;
            $data['xml'] = new \SimpleXMLElement($response->getBody());
        }catch(RequestException $e)
        {
            if ($e->hasResponse()) {
                $response = (string) $e->getResponse()->getBody()->getContents();
                $data['purchaseResponse'] = $response;
            }else{
                $data['purchaseResponse'] = $e->getMessage();
            }

            $data['xml'] = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?><response><success>false</success></response>");
        }

        $data['purchaseRequest'] = $query;

        return $data;

    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $data = array_merge($data,$this->verifyPayment($data));

        return $this->response = new FonepayCompletePurchaseResponse($this, $data, $data['xml']);
    }

}