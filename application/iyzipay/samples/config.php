<?php

require_once('../IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        //gerce�:
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setApiKey("sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC");
        //gerce�:
        //test:sandbox-ILKG6BJ27Df1mTXErRliLIh7xb9LLwEC
        $options->setSecretKey("sandbox-Nd3QpNBw7m9RPi4bAz2fEyCcoO21nAD7");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        return $options;
    }
}