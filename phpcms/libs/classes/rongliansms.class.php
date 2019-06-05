<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */


class rongliansms{

	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
	private $accountSid= '8a216da85d7dbf78015d883b6f15048a';
	
	//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
	private $accountToken= 'a661980337d3471aa04204b3c98290e1';
	
	//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
	//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
	private $appId='8aaf07085ea24877015ea91bca2403d4';
	
	//请求地址
	//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
// 	private $serverIP = 'sandboxapp.cloopen.com';
	
	//生产环境（用户应用上线使用）：app.cloopen.com
	private $serverIP = 'app.cloopen.com';
	
	
	
	//请求端口，生产环境和沙盒环境一致
	private $serverPort='8883';
	
	//REST版本号，在官网文档REST介绍中获得。
	private $softVersion='2013-12-26';
	
	function __construct()
	{
		@include("statics/plugin/sms/CCPRestSmsSDK.php");
	}
	
	
	/**
	  * 发送模板短信
	  * @param to 手机号码集合,用英文逗号分开
	  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
	  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
	  */       
	function sendTemplateSMS($to,$datas,$tempId)
	{
	     // 初始化REST SDK
	     $rest = new REST($this->serverIP,$this->serverPort,$this->softVersion);
	     $rest->setAccount($this->accountSid,$this->accountToken);
	     $rest->setAppId($this->appId);
	    
	     // 发送模板短信
	     $log .= "Sending TemplateSMS to $to :";
	     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
	     if($result == NULL ) {
	     	 $log .= "result error!\n\r";
	     	 kernel::log($log);
	     	 return false;
	     }
	     if($result->statusCode!=0) {
	     	 $log .="error code :" . $result->statusCode . ",";
	     	 $log .="error msg :" . $result->statusMsg . "\n\r";
	     	 $result->statusReturn = false;
	         //TODO 添加错误处理逻辑
	     }else{
	     	$log .="Sendind TemplateSMS success!";
	         // 获取返回信息
	         $smsmessage = $result->TemplateSMS;
	         $log .="dateCreated:".$smsmessage->dateCreated.",";
	         $log .="smsMessageSid:".$smsmessage->smsMessageSid."\n\r";
	         $result->statusReturn= true;
	         //TODO 添加成功处理逻辑
	     }

	     return $result;
	}
}
//Demo调用 
		//**************************************举例说明***********************************************************************
		//*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
		//*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");																		  *
		//*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
		//*********************************************************************************************************************
// sendTemplateSMS("",array('',''),"");//手机号码，替换内容数组，模板ID
?>