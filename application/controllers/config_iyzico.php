<?php

//require_once('../iyzipay/IyzipayBootstrap.php');

$this->load->library('IyzipayBootstrap');

IyzipayBootstrap::init();
class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        //gerceç:
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setApiKey("sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC");
        //gerceç:
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setSecretKey("sandbox-Nd3QpNBw7m9RPi4bAz2fEyCcoO21nAD7");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        return $options;
    }
        
}