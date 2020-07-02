<?php

class Credential
{

    private $_data = array(
        "key" => null,
        "secret" => null
    );


    public function __get($key)
    {
        switch ($key) {
            case "key":
            case "secret":
                return $this->_data[$key];

        }
        return null;
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key,$this->_data)) {
            $this->_data[$key] = $value;
        }
        return false;
    }

    public function save()
    {
        $credential_string = json_encode(array("key" => $this->key, "secret" => $this->secret));
        $file_dir = dirname(__FILE__);
        $file_name = $file_dir . "/../.credential";
        $file = fopen($file_name, "w");
        fwrite($file, $credential_string);
        fclose($file);
    }


    private function fill_from_array($row)
    {
        if (is_array($row)) {

            foreach ($row as $key => $value) {
                if (array_key_exists($key,$this->_data)) {
                    $this->_data[$key] = $value;
                }
            }
        }
    }

    public static function &load()
    {
        $file_dir = dirname(__FILE__);
        $file_name = $file_dir . "/../.credential";
        $json = array();

        if (file_exists($file_name)) {
            $file = fopen($file_name, "r");
            $json = fread($file, filesize($file_name));
            fclose($file);
        }

        $obj = new self();
        if (file_exists($file_name)) $obj->fill_from_array(json_decode($json, true));
        return $obj;
    }

    public static function verifyCredential($key, $secret)
    {
        $endpoint = "https://rest.moceanapi.com/rest/2/account/balance?" . http_build_query(array(
                "mocean-api-key" => $key,
                "mocean-api-secret" => $secret,
                "mocean-response" => "JSON",
                "mocean-medium" => "cmsmadesimple",
            ), "", "&");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code >= 200 && $http_code <= 299) {
            return true;
        }
        return false;
    }

    public static function credentialAdded()
    {
        $file_dir = dirname(__FILE__);
        $file_name = $file_dir . "/../.credential";
        return file_exists($file_name);
    }
}

?>