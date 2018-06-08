<?php

//require_once('../iyzipay/IyzipayBootstrap.php');

$this->load->library('IyzipayBootstrap');

IyzipayBootstrap::init();
class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        //gerceç: dhTnpPauML4LSVFZyrk1epCA3roRmfUT
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setApiKey("sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC");
        $options->setApiKey("dhTnpPauML4LSVFZyrk1epCA3roRmfUT");
        //gerceç: ETl7ZY3l4awBdZsuquvvXeb2qF28H9dD
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setSecretKey("sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC");
        $options->setSecretKey("ETl7ZY3l4awBdZsuquvvXeb2qF28H9dD");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        $options->setBaseUrl("https://api.iyzipay.com");
        return $options;
    }
        
}