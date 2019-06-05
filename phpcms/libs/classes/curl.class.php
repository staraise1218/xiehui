<?php
/**
 * curl 执行get 和 post请求
 */
 
class curl {
 
    protected $_post; 
    protected $_postFields;

    public function get($url)
    {
        return $this->exec($url);
    }

    public function post($url, $postFields = '') 
    { 
       $this->_post = true; 
       $this->_postFields = $postFields;
       return $this->exec($url);
    }

    private function exec($url) 
    {
        if(!$url)
            return false;

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书

        if($this->_post) 
        {
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $this->_postFields); 
        }  

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
} 
