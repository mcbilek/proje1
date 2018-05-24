<?php

require_once('config.php');

# create request class
$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId("123456789");
$request->setPrice("100");
$request->setPaidPrice("100");
$request->setCurrency(\Iyzipay\Model\Currency::TL);
$request->setBasketId("B67832");
$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
$request->setCallbackUrl("https://www.merchant.com/callback");
$request->setEnabledInstallments(array(2, 3, 6, 9));

$buyer = new \Iyzipay\Model\Buyer();
$buyer->setId("BY789");
$buyer->setName("John");
$buyer->setSurname("Doe");
$buyer->setGsmNumber("+905350000000");
$buyer->setEmail("email@email.com");
$buyer->setIdentityNumber("74300864791");
$buyer->setLastLoginDate("2015-10-05 12:43:35");
$buyer->setRegistrationDate("2013-04-21 15:12:09");
$buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
$buyer->setIp("85.34.78.112");
$buyer->setCity("Istanbul");
$buyer->setCountry("Turkey");
$buyer->setZipCode("34732");
$request->setBuyer($buyer);

$shippingAddress = new \Iyzipay\Model\Address();
$shippingAddress->setContactName("Jane Doe");
$shippingAddress->setCity("Istanbul");
$shippingAddress->setCountry("Turkey");
$shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
$shippingAddress->setZipCode("34742");
$request->setShippingAddress($shippingAddress);

$billingAddress = new \Iyzipay\Model\Address();
$billingAddress->setContactName("Jane Doe");
$billingAddress->setCity("Istanbul");
$billingAddress->setCountry("Turkey");
$billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
$billingAddress->setZipCode("34742");
$request->setBillingAddress($billingAddress);

// $basketItems = array();
// $firstBasketItem = new \Iyzipay\Model\BasketItem();
// $firstBasketItem->setId("BI101");
// $firstBasketItem->setName("Binocular");
// $firstBasketItem->setCategory1("Collectibles");
// $firstBasketItem->setCategory2("Accessories");
// $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
// $firstBasketItem->setPrice("0.3");
// $basketItems[0] = $firstBasketItem;

$secondBasketItem = new \Iyzipay\Model\BasketItem();
$secondBasketItem->setId("BI102");
$secondBasketItem->setName("Game code");
$secondBasketItem->setCategory1("Game");
$secondBasketItem->setCategory2("Online Game Items");
$secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
$secondBasketItem->setPrice("100");
$basketItems[0] = $secondBasketItem;

// $thirdBasketItem = new \Iyzipay\Model\BasketItem();
// $thirdBasketItem->setId("BI103");
// $thirdBasketItem->setName("Usb");
// $thirdBasketItem->setCategory1("Electronics");
// $thirdBasketItem->setCategory2("Usb / Cable");
// $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
// $thirdBasketItem->setPrice("0.2");
// $basketItems[2] = $thirdBasketItem;
$request->setBasketItems($basketItems);

# make request
$checkoutFormInitialize = Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());

# print result
// print_r($checkoutFormInitialize);
// print_r($checkoutFormInitialize->getStatus());
// print_r($checkoutFormInitialize->getErrorMessage());
// print_r($checkoutFormInitialize->getCheckoutFormContent());
?>
<html>
<body>
<div>
deneme
</div>

</body>
<script type="text/javascript">
    if (typeof iyziInit == 'undefined') {
        var iyziInit = {
            currency: "TRY",
            token: "86e53ed9-93ab-4026-a0b9-52f31516d1ad",
            price: 100.00,
            locale: "tr",
            baseUrl: "https://sandbox-api.iyzipay.com",
            registerCardEnabled: false,
            bkmEnabled: true,
            userCards: [],
            force3Ds: false,
            isSandbox: true,
            storeNewCardEnabled: true,
            paymentWithNewCardEnabled: true,
            enabledApmTypes: ["SOFORT", "IDEAL", "QIWI", "GIROPAY"],
            buyerProtectionEnabled: false,
            hide3DS: false,
            gsmNumber: "+905350000000",
            email: "email@email.com",
            checkConsumerDetail: {
                "checkConsumerResult": {
                    "consumerExists": false
                }
            },
            metadata: {},
            createTag: function() {
                var iyziCSSTag = document.createElement('link');
                iyziCSSTag.setAttribute('rel', 'stylesheet');
                iyziCSSTag.setAttribute('type', 'text/css');
                iyziCSSTag.setAttribute('href', 'https://sandbox-static.iyzipay.com/checkoutform/css/main.min.css?v=1527126214159');
                document.head.appendChild(iyziCSSTag);
                var iyziJSTag = document.createElement('script');
                iyziJSTag.setAttribute('src', 'https://sandbox-static.iyzipay.com/checkoutform/js/iyziCheckout.min.js?v=1527126214159');
                document.head.appendChild(iyziJSTag);
            }
        };
        iyziInit.createTag();
    }
</script>
</html>