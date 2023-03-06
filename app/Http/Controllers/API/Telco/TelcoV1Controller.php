<?php

namespace App\Http\Controllers\API\Telco;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TelcoV1Controller extends Controller
{
    private $API_URL = 'https://api.digitalcore.telkomsel.com/digihub/v1/apiwrapper';
    private $API_KEY = 'qarf9g47db996y5fc9jg7b9f';
    private $SECRET_KEY = 'NzvmY';
    private $ENCRYPTION_KEY = 'DAL9ac1d89e';
    private $PARTNER_ID = 'dalnet';
    private $AES_256_CBC = 'aes-256-cbc';
    private $CHANNEL = 'internal-reseller';
    private $PRODUCT_IDS = [
        'idver', 'ktpscore', 'recycle', 'roaming2', 'lastloc2', 'loyalist', 'telcoses',
        'substat2', 'numberswitching2', 'forwarding2', 'simswap', 'tscore',
    ];

    private $RESPONSE = array(
        'code' => 500,
        'message' => 'Server Error',
        'count' => 0,
        'data' => array()
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());

        $validator = Validator::make($request->input(), [
            'transaction_id' => 'required|string|min:5|max:30',
            'client_id' => 'required|string',
            'product_id' => 'required|string',
            'consent' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->RESPONSE['message'] = $validator->errors();
        }
        else {
            $requestMessage = '';

            switch ($request->product_id) {
                case 'idver': $requestMessage = $this->prepareLocationScoringRequestMessage($request); break;
                case 'ktpscore': $requestMessage = $this->prepareKtpMatchRequestMessage($request); break;
                case 'recycle': $requestMessage = $this->prepareRecycleNumberRequestMessage($request); break;
                case 'roaming2': $requestMessage = $this->prepareActiveRoamingRequestMessage($request); break;
                case 'lastloc2': $requestMessage = $this->prepareLastLocationRequestMessage($request); break;
                case 'loyalist': $requestMessage = $this->prepareInterestRequestMessage($request); break;
                case 'telcoses': $requestMessage = $this->prepareTelcoSesRequestMessage($request); break;
                case 'substat2': $requestMessage = $this->prepareActiveStatusRequestMessage($request); break;
                case 'numberswitching2': $requestMessage = $this->prepareOneImeiMultipleNumberRequestMessage($request); break;
                case 'forwarding2': $requestMessage = $this->prepareCallForwardingStatusRequestMessage($request); break;
                case 'simswap': $requestMessage = $this->prepareSimSwapRequestMessage($request); break;
                case 'tscore': $requestMessage = $this->prepareTelcoScoreBin25RequestMessage($request); break;
                default: break;
            }
            
            if (!empty($requestMessage)) {
                $cipherText = $this->AESCBCEncrypt(json_encode($requestMessage), $this->ENCRYPTION_KEY);
                $requestMessage = $this->createRequestMessage($request, $cipherText);

                $curl = curl_init();
    
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => $this->API_URL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode($requestMessage),
                        CURLOPT_HTTPHEADER => array(
                            "Accept: */*",
                            "api_key: " . $this->API_KEY,
                            "x-signature: " . $this->createSignature($this->API_KEY, $this->SECRET_KEY),
                            "Content-Type: application/json"
                        ),
                        CURLOPT_SSL_VERIFYHOST => storage_path('cacert/cacert.pem'),
                        CURLOPT_SSL_VERIFYPEER => storage_path('cacert/cacert.pem'),
                    )
                );
    
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
                
                if ($err) {
                    $this->RESPONSE['message'] = $err;
                }
                else {
                    $decipherResponse = $this->decipherResponse($response, $this->ENCRYPTION_KEY);

                    $this->RESPONSE['code'] = 200;
                    $this->RESPONSE['message'] = 'OK';
                    $this->RESPONSE['count'] = 1;
                    $this->RESPONSE['data']['request'] = $requestMessage;
                    $this->RESPONSE['data']['api_response'] = json_decode($response);
                    $this->RESPONSE['data']['result'] = $decipherResponse;
                }
            }
            else {
                $this->RESPONSE['code'] = 404;
                $this->RESPONSE['message'] = 'Unknown API call';
            }

            return response()->json($this->RESPONSE, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function prepareLocationScoringRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'msisdn' => $request->msisdn_imei_key,
            'home_work' => $request->home_work,
            'long' => $request->long,
            'lat' => $request->lat,
            'address' => $request->address,
            'zip_code' => $request->zipcode,
        ];
        return $apiParams;
    }

    private function prepareKtpMatchRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'channel' => 'of',
            'msisdn' => $request->msisdn_imei_key,
            'nik' => $request->nik,
        ];
        return $apiParams;
    }

    private function prepareRecycleNumberRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'msisdn' => $request->msisdn_imei_key,
            'timestamp' => $request->timestamp,
            'channel' => $this->CHANNEL,
        ];
        return $apiParams;
    }

    private function prepareActiveRoamingRequestMessage($request)
    {
        $apiParams = array(
            'transaction_id' => $request->transaction_id,
            'key' => $request->msisdn_imei_key,
        );
        return $apiParams;
    }

    private function prepareLastLocationRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'key' => $request->msisdn_imei_key,
            'param' => $request->param,
        ];
        return $apiParams;
    }

    private function prepareInterestRequestMessage($request)
    {
        $plainText = [
            'transaction_id' => $request->transaction_id,
            'msisdn' => $request->msisdn_imei_key,
            'partner_name' => $request->partner
        ];
        return $apiParams;
    }

    private function prepareTelcoSesRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'msisdn' => $request->msisdn_imei_key,
            'consentID' => $request->consent_id,
            'partner_name' => $request->partner,
        ];
        return $apiParams;
    }

    private function prepareActiveStatusRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'key' => $request->msisdn_imei_key,
        ];
        return $apiParams;
    }

    private function prepareOneImeiMultipleNumberRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'key' => $request->msisdn_imei_key,
            'param' => $request->param,
            'min' => $request->min,
            'max' => $request->max,
        ];
        return $apiParams;
    }

    private function prepareCallForwardingStatusRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'key' => $request->msisdn_imei_key,
        ];
        return $apiParams;
    }

    private function prepareSimSwapRequestMessage($request)
    {
        $apiParams = [
            'transaction_id' => $request->transaction_id,
            'msisdn' => $request->msisdn_imei_key,
        ];
        return $apiParams;
    }

    private function prepareTelcoScoreBin25RequestMessage($request)
    {
        $apiParams = array(
            'transaction' => array(
                'transaction_id' => $request->transaction_id
            ),
            'request' => array(
                'msisdn' => $request->msisdn_imei_key,
                'srd_flag' => (is_numeric($request->srd_flag) && ((int) $request->srd_flag == 1)) ? true : false,
                'table_code' => 'testonlytable'
            )
        );
        return $apiParams;
    }

    private function createRequestMessage($request, $cipherText)
    {
        $POSTED_DATA_ARRAY = array(
            'transaction' => array(
                'transaction_id' => $request->transaction_id,
                'partner_id' => $this->PARTNER_ID,
                'client_id' => $request->client_id,
                'product_id' => $request->product_id,
                'consent_reference' => $request->consent,
              ),
              'request' => array(
                'ciphertext' => $cipherText,
              ),
        );
        
        // dd($POSTED_DATA_ARRAY);
        return $POSTED_DATA_ARRAY;
    }

    private function createSignature($apiKey, $secretKey) {
        return hash('sha256', $apiKey . $secretKey . time());
    }

    private function decipherResponse($jsonResponse, $encryptionKey) {
        $result = '';
        $response = json_decode($jsonResponse); //echo '<pre>'; print_r($response); echo '</pre>';
        // echo AESCBCDecrypt($response->response->ciphertext, $ENCRYPTION_KEY);

        $statusCode = (int) $response->transaction->status_code;

        if ($statusCode == 0) {
            $result = json_decode($this->AESCBCDecrypt($response->response->ciphertext, $encryptionKey));
        }
        else {
            $result = $response->transaction->status_desc;
        }

        return $result;
    }


    private function AESCBCEncrypt($plainText, $secretKey) {
        $blockSize = openssl_cipher_iv_length($this->AES_256_CBC);
        $bKey = hash('sha256', $secretKey, true);
        $iv = openssl_random_pseudo_bytes($blockSize);
        $encrypted = openssl_encrypt($plainText, $this->AES_256_CBC, $bKey, OPENSSL_RAW_DATA, $iv);
        $cipherText = $iv . $encrypted;
        return base64_encode($cipherText);
    }
    
    private function AESCBCDecrypt($cipherText, $secretKey) {
        $blockSize = openssl_cipher_iv_length($this->AES_256_CBC);
        $bKey = hash('sha256', $secretKey, true);
        $bCipherText = base64_decode($cipherText); 
        $iv = substr($bCipherText, 0, $blockSize);
        $bFinalCipherText = substr($bCipherText, $blockSize);
        $bPlaintext = openssl_decrypt($bFinalCipherText, $this->AES_256_CBC, $bKey, OPENSSL_RAW_DATA, $iv);
        return $bPlaintext;
    }
}
