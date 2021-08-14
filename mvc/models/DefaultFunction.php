<?php


class DefaultFunction extends connection
{

    protected $connection;

    public function __construct(){
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }

    public function addLog($logUID,$logContent){
        $logRole = 0;
        $time = date("Y-m-d H:i:s");
        $sqlAddLog = "insert into logs(logUID,logTime,logRole,logContent) values ({$logUID},'$time',{$logRole},'$logContent')";
        return $this->connection->query($sqlAddLog);
    }

    public function clearString($string){
        return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($string))));
    }

    function obfuscate_email($email)
    {
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);
        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
    }

    //        convert from code to address string
    function convertCodeToAddress($wards,$district,$province){
        $address = file_get_contents('public/assets/json/nested-divisions.json');
        $arrAddress = json_decode($address, true);
        $dataAddress = array();
        foreach ($arrAddress as $adr){
            if ($adr['code'] == $province){
                $dataAddress['province'] = $adr['name'];
                foreach ($adr['districts'] as $dis){
                    if ($dis['code'] == $district){
                        $dataAddress['district'] = $dis['name'];
                        foreach ($dis['wards'] as $w){
                            if ($w['code'] == $wards){
                                $dataAddress['wards'] = $w['name'];
                            }
                        }
                    }
                }
            }
        }
        return $dataAddress;
    }

    function updateLastLogin($id){
        $time = date("Y-m-d H:i:s");
        $sqlUpdateLastLogin = "update user set uLastLogin = "."'$time'"." where uID = ". $id;
        if ($result = $this->connection->query($sqlUpdateLastLogin)){
            return true;
        }
    }
}