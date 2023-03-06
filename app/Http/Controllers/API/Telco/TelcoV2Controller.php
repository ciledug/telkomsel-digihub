<?php

namespace App\Http\Controllers\API\Telco;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TelcoV2Controller extends Controller
{
    private $API_URL = 'https://api.digitalcore.telkomsel.com/digihub/v1/apiwrapper';
    private $API_KEY = 'qarf9g47db996y5fc9jg7b9f';
    private $SECRET_KEY = 'NzvmY';
    private $PARTNER_ID = 'dalnet';
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
        //
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
        //
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

    function sendRequest(Request $request)
    {
        // dd($request);
        // $validator = Validator::make($request->input(), [
        //     'transaction_id' => 'required|string|min:11|max:30',
        //     'channel' => "required|string", 
        //     'msisdn' => 'required|numeric|min:11|max:15',
        //     'nik' => 'required|numeric|min:16|max:16',
        //     'client_id' => 'required|string',
        // ]);

        $validator = Validator::make($request->input(), [
            'transaction_id' => 'required|string|min:5|max:30',
            'client_id' => 'required|string',
            'product_id' => 'required|string',
            'consent' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->RESPONSE['message'] = $validator->errors();
        }
        else {
            $requestMessage = $this->createRequestMessage($request, $this->PARTNER_ID);

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
                    )
                )
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);
            $curlResult = '';
            
            curl_close($curl);
            
            if ($err) {
                $curlResult = $err;
                $this->RESPONSE['message'] = $curlResult;
            }
            else {
                $this->RESPONSE['code'] = 200;
                $this->RESPONSE['message'] = 'OK';
                $this->RESPONSE['count'] = 1;
                $this->RESPONSE['data']['api_response'] = json_decode($response);
            }
        }

        return response()->json($this->RESPONSE);
    }

    function createRequestMessage(Request $request, $partnerId)
    {
        $POSTED_DATA_ARRAY = array(
            'transaction' => array(
                'transaction_id' => $request->transaction_id,
                'partner_id' => $partnerId,
                'client_id' => $request->client_id,
                'product_id' => $request->product_id,
                'consent_reference' => $request->consent,
              ),
              'request' => array(
                'ciphertext' => $request->message,
              ),
        );

        // dd($POSTED_DATA_ARRAY);
        return $POSTED_DATA_ARRAY;
    }

    function createSignature($apiKey, $secretKey) {
        return hash('sha256', $apiKey . $secretKey . time());
    }
}
