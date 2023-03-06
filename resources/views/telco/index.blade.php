@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<style>
  span#container-api-request-title {
    all: revert;
  }

  span#container-api-response-title {
    all: revert;
  }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Request Data</h5>

            <form id="form-request" class="row g-3 needs-validation" method="POST" action="{{ route('telco.send') }}">
              <div class="col-lg-6">
                <div class="col-md-12 input-product-id">
                  <div class="form-floating">
                    <select class="form-select" id="input-product-id" name="input_product_id" aria-label="State" required>
                      <option value=""></option>
                      <option value="idver">Location Scoring</option>
                      <option value="ktpscore">KTP Match</option>
                      <option value="recycle">Recycle Number</option>
                      <option value="roaming2">Active Roaming</option>
                      <option value="lastloc2">Last Location</option>
                      <option value="loyalist">Interest</option>
                      <option value="telcoses">Telco SES</option>
                      <option value="substat2">Active Status</option>
                      <option value="numberswitching2">1 IMEI Multiple Number</option>
                      <option value="forwarding2">Call Forwarding Status</option>
                      <option value="simswap">SIM Swap</option>
                      <option value="tscore">Telco Score BIN 25</option>
                    </select>
                    <label for="input-product-id">Product API</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-transaction-id">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields" id="input-transaction-id" name="input_transaction_id" placeholder="Transaction ID" value="{{ old('input_transaction_id') }}" required>
                    <label for="input-transaction-id">Transaction ID</label>
                  </div>
                </div>
  
                <div class="col-md-12 mt-3 input-client-id">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields" id="input-client-id" name="input_client_id" placeholder="Client ID" value="{{ old('input_client_id') }}" required>
                    <label for="input-client-id">Client ID</label>
                  </div>
                </div>
  
                <div class="col-md-12 mt-3 input-consent">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields" id="input-consent" name="input_consent" placeholder="Consent" value="{{ old('input_consent') }}" required>
                    <label for="input-consent">Consent</label>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-6">
                <div class="col-md-12 mb-3">
                  <div class="form-floating">
                    <textarea class="form-control" id="container-request-ciphered-text" name="input_ciphered_text" style="height:200px;" placeholder="Ciphered text" required>{{ old('input_ciphered_text') }}</textarea>
                    <label for="container-request-ciphered-text" class="form-label">Ciphered Text</label>
                  </div>
                </div>
                
                <!--
                <div class="col-md-12 input-rows input-msisdn">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-msisdn" name="input-msisdn" min="1000000000000" max="6289999999999" placeholder="62xxxxxxxxxxx">
                    <label for="input-msisdn">MSISDN / Key (628xxxxxxxxxxx)</label>
                  </div>
                </div>
                -->
                
                <!-- location scoring -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-location-scoring">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">Address Type</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-home-work" id="radio-home-work-yes" value="1">
                        <label class="form-check-label" for="radio-home-work-yes">Home</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-home-work" id="radio-home-work-no" value="0">
                        <label class="form-check-label" for="radio-home-work-no">Work</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">Address Info</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-geolocation" value="geolocation">
                        <label class="form-check-label" for="radio-address-info-geolocation">Geolocation</label>
                      </div>
                      
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-address" value="address">
                        <label class="form-check-label" for="radio-address-info-address">Address</label>
                      </div>
                      
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-address-info" id="radio-address-info-zipcode" value="zipcode">
                        <label class="form-check-label" for="radio-address-info-zipcode">ZIP Code</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                
                <div class="row">
                  <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="input-latitude" name="input-latitude" placeholder="-6.247895">
                      <label for="input-latitude">Latitude</label>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mt-3 input-rows input-location-scoring row-address-info row-address-info-geolocation">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="input-longitude" name="input-longitude" placeholder="106.821312">
                      <label for="input-longitude">Longitude</label>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-address">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="input-address" name="input-address" style="height:100px;"></textarea>
                    <label for="input-address">Address</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-location-scoring row-address-info row-address-info-zipcode">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="input-zip-code" name="input-zip-code" min="10000" max="99999" maxlength="5" placeholder="ZIP Code">
                    <label for="input-zip-code">ZIP Code</label>
                  </div>
                </div>
                -->
                

                <!-- ktp match -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-ktp-match">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="input-nik" name="input-nik" min="1000000000000000" max="9999999999999999" maxlength="16" placeholder="NIK">
                    <label for="input-nik">Nomor Induk Kependudukan (NIK)</label>
                  </div>
                </div>
                -->
                
                
                <!-- last location -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-last-location">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-param" name="input-param" maxlength="30" placeholder="Param (name of city to check)">
                    <label for="input-param">Param (name of city to check)</label>
                  </div>
                </div>
                -->
                
                
                <!-- telco ses -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-interest input-telco-ses">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-partner-name" name="input-partner-name" maxlength="30" placeholder="Partner Name">
                    <label for="input-partner-name">Partner Name</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-telco-ses">
                  <div class="form-floating">
                    <input type="text" class="form-control input-fields" id="input-consent-id" name="input-consent-id" maxlength="30" placeholder="Consent ID">
                    <label for="input-consent-id" class="col-form-label">Consent ID</label>
                  </div>
                </div>
                -->
                
                
                <!-- 1-imei-multiple-number -->
                <!--
                <div class="col-md-12 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-imei" name="input-imei" min="6280000000000" max="999999999999999" value="350742139251246" placeholder="62xxxxxxxxxxx">
                    <label for="input-imei">IMEI / Key</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="input-param-1-imei-multiple-number" name="input-param-1-imei-multiple-number" maxlength="30" placeholder="Param (number of previous days to check)">
                    <label for="input-param-1-imei-multiple-number">Param (number of previous days to check from today)</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-min" name="input-min" min="0" max="9" maxlength="1" placeholder="Min (count of min. phone numbers to check)">
                    <label for="input-min" class="col-form-label">Min (count of min. phone numbers to check)</label>
                  </div>
                </div>
                
                <div class="col-md-12 mt-3 input-rows input-one-imei-multiple-number">
                  <div class="form-floating">
                    <input type="number" class="form-control input-fields" id="input-max" name="input-max" min="0" max="9" placeholder="Max (count of max. phone numbers to check)">
                    <label for="input-max" class="col-form-label">Max (count of max. phone numbers to check)</label>
                  </div>
                </div>
                -->
                
                
                <!-- telco score bin 25 -->
                <!--
                <div class="col-md-12 mt-3 input-rows input-telco-score-bin-25">
                  <fieldset class="row">
                    <legend class="col-form-label col-sm-3 pt-0">SRD Flag</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-srd-flag" id="radio-srd-flag-yes" value="1">
                        <label class="form-check-label" for="radio-srd-flag-yes">Yes</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio-srd-flag" id="radio-srd-flag-no" value="0">
                        <label class="form-check-label" for="radio-srd-flag-no">No</label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                -->
              </div>
              
              <hr class="mt-4">
              
              <div class="text-center">
                <button type="submit" id="btn-submit-request" class="btn btn-primary">Submit</button>
                <input type="hidden" id="selected-product" name="selected-product" value="">
                <input type="hidden" id="selected-address-info" name="selected-address-info" value="">
                {{ csrf_field() }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Sent Request for <span id="container-api-request-title"></span></h5>
            <form class="row g-3" id="form-input" name="form-input">
              <div class="col-12">
                <label for="container-request-raw-data" class="form-label">Raw Data</label>
                <textarea class="form-control" id="container-request-raw-data" style="height:200px;"></textarea>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Respond for <span id="container-api-response-title"></span></h5>
            
            <form class="row g-3">
              <div class="col-12">
                <label for="container-respond-raw-data" class="form-label">Raw Data</label>
                <textarea class="form-control" id="container-respond-raw-data" style="height:200px;"></textarea>
              </div>
              
              <div class="col-12">
                <label for="container-respond-deciphered-ciphertext" class="form-label">Deciphered Cipher Text</label>
                <textarea class="form-control" id="container-respond-deciphered-ciphertext" style="height:100px;"></textarea>
              </div>
            </form>
          
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@push('javascript')
<script type="text/javascript">
  var tempApiRequest = [];
  var tempApiResponses = [];
  var selectedProduct = $('#selected-product').val().toLowerCase();
  
  function prepareProductsDropDown() {
    $('#input-product-id').change(function(e) {
      $('#selected-product').val(($(this).val()));
      selectedProduct = $('#selected-product').val().toLowerCase();
      updateForm();
    });
  };
  
  function updateForm() {
    $('.input-rows').hide();
    $('.input-msisdn').show();
    
    var title = '';
    var apiRequest = '';
    var apiResponse = '';
    var decipheredText = '';
    
    switch(selectedProduct) {
      case 'idver': $('.input-location-scoring').show(); title = 'Location Scoring'; break;
      case 'ktpscore': $('.input-ktp-match').show(); title = 'KTP Match'; break;
      case 'recycle': $('.input-recycle-number').show(); title = 'Recycle Number'; break;
      case 'roaming2': $('.input-active-roaming').show(); title = 'Active Roaming'; break;
      case 'lastloc2': $('.input-last-location').show(); title = 'Last Location'; break;
      case 'loyalist': $('.input-interest').show(); title = 'Interest'; break;
      case 'telcoses': $('.input-telco-ses').show(); title = 'TelcoSES'; break;
      case 'substat2': title = 'Active Status'; break;
      case 'numberswitching2': $('.input-msisdn').hide(); $('.input-one-imei-multiple-number').show(); title = '1 IMEI Multiple Number'; break;
      case 'forwarding2': title = 'Call Forwarding Status'; break;
      case 'simswap': title = 'SIM Swap'; break;
      case 'tscore': $('.input-telco-score-bin-25').show(); title = 'Telco Score BIN 25'; break;
    }
    
    var existingRequest = tempApiRequest[selectedProduct];
    var existingResponse = tempApiResponses[selectedProduct];
    
    if (existingRequest !== undefined) {
      apiRequest = existingRequest.request;
    }
    
    if (existingResponse !== undefined) {
      apiResponse = existingResponse.api_response;
      
      if (parseInt(apiResponse.transaction.status_code, 10) === 0) {
        decipheredText = existingResponse.result;
      }
    }
    
    $('#container-api-request-title').text(title);
		$('#container-api-response-title').text(title);
		$('#container-request-raw-data').val(JSON.stringify(apiRequest));
    $('#container-respond-raw-data').val(JSON.stringify(apiResponse));
    $('#container-respond-deciphered-ciphertext').val(JSON.stringify(decipheredText));
  };
  
  function prepareAddressType() {
    $("input[name='radio-products']").click(function(e) {
      $('#selected-product').val(($(this).val()));
      selectedProduct = $('#selected-product').val().toLowerCase();
      updateForm();
    });
  };
  
  function prepareAddressInfo() {
    $('input[name="radio-address-info"]').click(function(e) {
      var addressInfo = $('#selected-address-info').val($(this).val());
      
      $('.row-address-info').hide();
      
      switch(addressInfo.val()) {
        case 'geolocation': $('.row-address-info-geolocation').show(); break;
        case 'address': $('.row-address-info-address').show(); break;
        case 'zipcode': $('.row-address-info-zipcode').show(); break;
        default: break;
      }
    });
  };
  
  function prepareSubmitButton() {
    $('#btn-submit').click(function(e) {
      e.preventDefault();
      
      var theForm = $('form')[0];
      var formData = new FormData(theForm);
      formData.append('_token', '{{ csrf_token() }}');
      formData.submit();

      // submitData(formData);
    });
  };
  
  function submitData(formData) {
    $('#btn-submit').prop('disabled', true);
    $('#container-request-raw-data').empty();
		$('#container-respond-raw-data').empty();
    $('#container-respond-deciphered-ciphertext').empty();
    
    $.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      url: '{{ route('telco.send') }}',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {
        console.log(response);
        
        if (response.api_response !== undefined) {
          var statusCode = parseInt(response.api_response.transaction.status_code, 10);
          if (statusCode == 0) {
            $('#container-respond-deciphered-ciphertext').val(JSON.stringify(response.result));
          }
          
          $('#container-request-raw-data').val(JSON.stringify(response.request));
				  $('#container-respond-raw-data').val(JSON.stringify(response.api_response));
				  
				  tempApiRequest[selectedProduct] = response;
          tempApiResponses[selectedProduct] = response;
        }
      },
      error: function(error) {
        console.log('error: ' + error.responseText);
        $('#container-respond-raw-data').val(JSON.stringify(error.responseText));
      }
    })
    .always(function() {
      $('#btn-submit').prop('disabled', false);
    });
  };
  
  $(document).ready(function() {
    prepareProductsDropDown();
    prepareAddressType();
    prepareAddressInfo();
    // prepareSubmitButton();
    
    $('.input-rows').hide();

    $('#form-request').submit(function() {
      $('#btn-submit-request').addClass('disabled');
    });
  });
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')