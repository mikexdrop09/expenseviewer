<?php

class Cryptor{

    public function __construct()
    {
        
    }

    function decrypt($id){
        $id = base64_decode($id);
        $key = hash('sha256', "XDT-YUGHH-GYGF-YUTY-GHRGFR");
        $iv = substr(hash('sha256',"DFYTYUITYUIUYUGYIYT"),0,16);
        $id = openssl_decrypt($id, "AES-256-CBC", $key, 0 ,$iv);
        return $id;
    }

    function encryptId($id){
        
        $key = hash('sha256', "XDT-YUGHH-GYGF-YUTY-GHRGFR");
        $iv = substr(hash('sha256', "DFYTYUITYUIUYUGYIYT"),0,16);
        $id = openssl_encrypt($id,"AES-256-CBC", $key, 0, $iv);
        $id = base64_encode($id);
        return $id;

    }

}

?>