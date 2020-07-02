<?php

class SMS
{
    private $recipients = array();
    private $sender;

    public static function newSMS()
    {
        return new self();
    }

    public function from($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function addRecipient($number)
    {
        $this->recipients = array_merge($this->recipients, explode(",", $number));
        return $this;
    }

    public function sendMessage($message)
    {
        $endpoint = "https://rest.moceanapi.com/rest/2/sms";
        $credential = Credential::load();
        $api_key = $credential->key;
        $api_secret = $credential->secret;

        $chunk_recipients = array_chunk($this->recipients, 50);

        foreach ($chunk_recipients as $recipients)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                "mocean-api-key" => $api_key,
                "mocean-api-secret" => $api_secret,
                "mocean-resp-format" => "JSON",
                "mocean-from" => $this->sender,
                "mocean-to" => implode(",", $recipients),
                "mocean-text" => $message
            ), "", "&"));
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            if ((int)$http_code === 401) {
                throw new AuthenticationError("Invalid Credential", 401);
            } else if ((int)$http_code === 400) {
                if ($data["status"]) {
                    throw new InsufficientCreditError("Insufficient credit. Please do top up.", 400);
                }
            } else if ($http_code > 299) {
                throw new Exception("Unknown error.", 500);
            }
        }


        $history = new History();
        $history->text = $message;
        $history->receiver = implode(",", $this->recipients);
        $history->ip = isset($_SERVER["REMOTE_HOST"]) ? $_SERVER['REMOTE_HOST'] : $_SERVER['REMOTE_ADDR'];
        $history->datetime = date("Y-m-d H:i:s");
        $history->save();
        return true;
    }

}