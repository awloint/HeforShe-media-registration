  
<?php
/**
 * This is the Notify Class
 *
 * @category Notify_Class
 * @package  Notify_Class
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
class Notify
{
    /**
     * Constructor Function
     *
     * @param string $smstoken The API token for the SMS
     */
    public function __construct($smstoken)
    {
        $this->smstoken = $smstoken;
    }
    /**
     * Send notification via SMS
     *
     * @param string $from  the SMS from identify - not more than 11 characters
     * @param string $body  - The body of the SMS
     * @param string $phone - The Phone number enclosed in Strings
     *
     * @return void
     */
    public function viaSMS($from, $body, $phone)
    {
        // prepare the parameters
        $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create';
        $token = $this->smstoken;
        $myvars = 'api_token=' . $token . '&from=' . $from . '&to='
                    . $phone . '&body=' . $body;
        //start CURL
        // create curl resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }
}