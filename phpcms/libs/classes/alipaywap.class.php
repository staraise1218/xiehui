<?php

require_once ('./statics/plugin/payment/alipay/AopSdk.php');

class alipaywap {
	// 支付宝支付网关
	private $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	// 支付宝分配给开发者的应用ID
	private $appId = '2019032263665050'; // 
	private $rsaPrivateKey = 'MIIEowIBAAKCAQEAuaX9Jl8HlfruQDi0scZReuU+RpD/0DLiSwig1BQ9l2wIVh9yat3n+EyKpzz8zC3HxrsrBG6QdcBLWW27Ye99rf9q/IFMHmnB9rhxbkQrUU0mO6Ooa59OKKTd464crKU0yxbRAivTHkgCMVbFLr1313TZjW9oZLw9Zcghxv6WmHhZ1PMb0IZ4+/gBI/Nv9/9iG9YPt3SyIOUFodQ0OnxzZwvoOL6IQdBn5P+hIFoRFYnkOj8uElYgSKn6YB1VmcUtgmao9y3PfRU3YsutTExEPt6Fz01/OMfxzeisYv625wGvHs83o4L5+CxGC5sv/BUAHKP0rocLwUUsZdYFeVi3rwIDAQABAoIBACCOeG+TOLxXjhKbHy0R71YS/7HWWdZEJiUsdS/cANUeL/QSfbk6AyUrHyGm81pHKQKz7h5P2Wuc9lnPgY3yNuMdqMBxWEz5FPfUbqf8snAGjI7m63E8NbOw/eygqwynyDNZY/vyfYqQ7DmE0v2YYnzZVBGWmQMZc9b2mt3P5c8E9zU6keu+ZK9JBrqWAszTEAnNkF+m7Xdt+Bv+zWQbwm8K4ElpxhWYJduo/WtPMdiiVi2hW4/6VxpviMdqsq4MvdSg2SCPzpEnbcp/E42J+snSUpBRHvUqZ5ExZ5L/xSont31/PFO/sSgSZp5ulBfM0g+iPB6lZz6My3TZIcNCKokCgYEA8bSnsKvUe7G1QpHwNyOFX+nvyaYGYirR0ALYgwz2Sig26Yt37RyE5WqDnpEImv2ehJAS/UmlK5QOSOljo+LU+sEekVrylbsT86BzzQE/pndOH7ylDCcCU6uVC/yHhIazRTSYzEun5h52txm+cQik5zzgQZPwkyHfebAVa9PfjRUCgYEAxKClEdxGK/Cc0mc6rT1kZ8qk5PJfpzPD96HQYcszjjKS/QWozYtlUM+NyIGJ99LR8MLXO0o90UtNgVRvNNPXUgUi/QzOynQRGl/7exCADrFrufdmsHOMcfkNgwiX78FKs6knsygChxTQKTLr5zFAWAjD3GzybCZm1X0Bmwp9SrMCgYAXmKleSAggY0Ls0s5+s4sLyAzOxNSOtNty0TRN5vAMYUyrFCCLF2Op+fILguEyMFxPWLlh3NSxIm0alR5TG4vrRvsy+YwBLhhOinWDqAGMwMzxsDr0qsJBZNjSKL8aIwRRV0crep9TidnRGkRLSKrAoGLMRCMSWhY1DQmqUy7Z2QKBgBk54vOfpwEMJZJ42/ZN4gvO28jjr5Hr+kBS6kEhqMOdiW4cw8NbFux/NFl9BQ5eZcDVvndE1xl6576n7nyAkSdcsVh1xDIFIgyYM9NeEo/QA1oge3Q33tTgdvNQru17hvH1yboab/iUmwAuIEXQ88hXl4k4EQH/C0Jof0Q83EYxAoGBANOw5fSDSppUCnXBvT8CgRuOT38oHoW3a8yCbwVXl0rNwvd5BghzXhgJvVHPD3eM942NP2NCYJi41XWDx6MLaFLRST9ixPAT1LtgKjFi8p9DB/+f0yBb84JFz6zC8lkAR84RCQZA9oNEx2xR9M1C3mTuFfekty4R5V2semX0FUg9';
	private $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiVYPiDDjATOInaIO8zPxNT+jYgCbNhWOInB9rHTUTz/9oin5+dFE5A5Ng8l21lVAmzJB4UG4m37ua7K0ZoRCrXcV5H6zN2uz4F48BMJxzrI58QQrTs5cCnVJbwNV6XmIifmXi85uM0WSSMtxKuPzbUaWbB2JNPJ0Sz0P+Fyq0JgotVbdH3LyKmoBndMhvJMCmuPcxiDEWKl/hEeBnX1Vew7BOqTK40YA6DidlhRVedgNUaochgHLH4Id+fynpgh+zx3n7gMtZBJrWhm3ETGQoUOQC62d7kogT6xP4QhvpD6/xSPDwAXc/gmEyXy8QURo1M3EWl5saVZOyZQ3n3rwJwIDAQAB';

	private $apiVersion = '1.0';
	private $signType = 'RSA2';
	private $postCharset = 'utf-8';
	private $format = 'json';
	public $returnUrl = '';
	public $notifyUrl = '';


	public function __construct(){
		
	}

	public function pagepay($out_trade_no, $subject, $total_amount){
		//构造参数  
		$aop = new \AopClient();

		$aop->gatewayUrl = $this->gatewayUrl;
		$aop->appId = $this->appId;
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->apiVersion = $this->apiVersion;
		$aop->signType = $this->signType;
		$aop->postCharset = $this->postCharset;
		$aop->format = $this->format;
		$request = new \AlipayTradeWapPayRequest();
		$request->setReturnUrl($this->returnUrl);
		$request->setNotifyUrl($this->notifyUrl);

		$bizContent = array(
			'quit_url' => 'http://www.caapa.org',
			'product_code' => 'QUICK_WAP_WAY',
			'out_trade_no' => $out_trade_no,
			'subject' => $subject,
			'total_amount' => $total_amount
		);
		$request->setBizContent(json_encode($bizContent));

		$result = $aop->pageExecute ($request);
		echo $result;
	}

	// 回调验签
	public function checkSign(){
		$aop = new \AopClient;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
		$signType = $this->signType;

		unset($_POST['c']);
		unset($_POST['m']);
		unset($_POST['a']);
		return $aop->rsaCheckV1($_POST, null, $signType);
	}
}