<?php
namespace Pasls\OmnipayFonepay\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class FonepayAuthorizeResponse extends AbstractResponse implements  RedirectResponseInterface
{
    public function __construct(RequestInterface $request, $data, protected $redirectUrl)
    {
        parent::__construct($request, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    public function getRedirectMethod()
    {
        return 'POST';
    }
    public function getRedirectData()
    {
        return $this->data;
    }
} 