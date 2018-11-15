<?php
namespace Star\Util;

class Encrypt
{
    private $vi;
    private $mode;
    private $key;

    public function __construct()
    {
        //算法
        $this->mode ='aes-256-cfb8';
        //基准
        $this->vi = str_pad('', 16,'9');
        //密钥
        $this->key ='dafa88..';
    }

    //编码
    protected function encrypt($msg=null,int $type=1){
        if(!$msg){
            return null;
        }
        $mode =$this->mode;
        $vi = $this->vi;
        $key =$this->key;
        switch ($type) {
            case 0:
                break;
            case 1:
            case 2:
                $msg =base_convert((int)$msg,10,36);
                break;
            default:
                break;
        }

        $msg_new =openssl_encrypt($msg, $mode, $key,0,$vi);
        $count =substr_count($msg_new,'=');
        if($type !=2){
            $count+=20;
        }
        $count =base_convert($count,10,36);
        $msg_new = str_replace('=', '', $msg_new).$count;
        if($type==2){   //ID编码
            $arr = str_split($msg_new,1);
            $msg_new ='';
            foreach($arr as $value){
                $msg_new.=ord($value)-23;
            }
        }

        return $msg_new;
    }

    //解码
    protected function decrypt($msg=null,$type=0){
        if(!$msg){
            return null;
        }
        if($type==2){
            $arr = str_split($msg,2);
            $msg ='';
            foreach($arr as $value){
                $msg.=chr($value+23);
            }
        }
        $mode =$this->mode;
        $vi = $this->vi;
        $key =$this->key;
        $count =substr($msg, -1,1);
        $count =base_convert($count,36,10);
        if($type !=2){
            $count-=20;
        }
        $msg = substr($msg,0,strlen($msg)-1);
        while($count--){
            $msg.='=';
        }
        $msg_new =openssl_decrypt($msg, $mode, $key,0,$vi);
        switch ($type) {
            case 0:
                break;
            case 1:
            case 2:
                $msg_new =(int)base_convert($msg_new,36,10);
                break;
            default:
                break;
        }
        return $msg_new;
    }

    static public function encode($msg,$type)
    {
        $obj =new self();
        $msg = $obj->encrypt($msg,$type);
        return $msg;
    }

    static public function decode($msg,$type)
    {
        $obj =new self();
        $msg =$obj->decrypt($msg,$type);
        return $msg;
    }
}