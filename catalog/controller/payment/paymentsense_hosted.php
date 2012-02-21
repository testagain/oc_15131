<?php
class ControllerPaymentPaymentSenseHosted extends Controller {
	protected function index() {
    	$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['action'] = 'https://mms.paymentsensegateway.com/Pages/PublicPages/PaymentForm.aspx';
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		// Get Address Data (Payment)
		$address = array();
		if (method_exists($this->customer, 'getAddress')) { // v1.3.2 Normal Checkout
        	$address = $this->customer->getAddress($this->session->data['payment_address_id']);
        	$address['zone_code'] = $address['code'];
		} else {
        	if (isset($this->session->data['payment_address_id']) && $this->session->data['payment_address_id']) { // v1.3.4+ Normal checkout
        		$this->load->model('account/address');
        		$address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
			} else { //v1.3.4+ Guest checkout
				$address = $this->session->data['guest'];
			}
		}
		if (!isset($order_info['iso_code_2'])) {
			$order_info['iso_code_2']	= (isset($address['iso_code_2'])) ? $address['iso_code_2'] : '';
		}
		if (!isset($order_info['zone_code'])) {
			$order_info['zone_code']	= (isset($address['code'])) ? $address['code'] : (isset($address['zone_code'])) ? $address['zone_code'] : '';
		}
		//
		
		$suppcurr = array(
			'USD' => '840',
			'EUR' => '978',
			'CAD' => '124',
			'JPY' => '392',
			'GBP' => '826',
			'AUD' => '036',
		);
		
		$country_codes = array(
			'Afghanistan'=>'4',
			'Albania'=>'8',
			'Algeria'=>'12',
			'American Samoa'=>'16',
			'Andorra'=>'20',
			'Angola'=>'24',
			'Anguilla'=>'660',
			'Antarctica'=>'',
			'Antigua and Barbuda'=>'28',
			'Argentina'=>'32',
			'Armenia'=>'51',
			'Aruba'=>'533',
			'Australia'=>'36',
			'Austria'=>'40',
			'Azerbaijan'=>'31',
			'Bahamas'=>'44',
			'Bahrain'=>'48',
			'Bangladesh'=>'50',
			'Barbados'=>'52',
			'Belarus'=>'112',
			'Belgium'=>'56',
			'Belize'=>'84',
			'Benin'=>'204',
			'Bermuda'=>'60',
			'Bhutan'=>'64',
			'Bolivia'=>'68',
			'Bosnia and Herzegowina'=>'70',
			'Botswana'=>'72',
			'Brazil'=>'76',
			'Brunei Darussalam'=>'96',
			'Bulgaria'=>'100',
			'Burkina Faso'=>'854',
			'Burundi'=>'108',
			'Cambodia'=>'116',
			'Cameroon'=>'120',
			'Canada'=>'124',
			'Cape Verde'=>'132',
			'Cayman Islands'=>'136',
			'Central African Republic'=>'140',
			'Chad'=>'148',
			'Chile'=>'152',
			'China'=>'156',
			'Colombia'=>'170',
			'Comoros'=>'174',
			'Congo'=>'178',
			'Cook Islands'=>'180',
			'Costa Rica'=>'184',
			'Cote D\'Ivoire'=>'188',
			'Croatia'=>'384',
			'Cuba'=>'191',
			'Cyprus'=>'192',
			'Czech Republic'=>'196',
			'Democratic Republic of Congo'=>'203',
			'Denmark'=>'208',
			'Djibouti'=>'262',
			'Dominica'=>'212',
			'Dominican Republic'=>'214',
			'Ecuador'=>'218',
			'Egypt'=>'818',
			'El Salvador'=>'222',
			'Equatorial Guinea'=>'226',
			'Eritrea'=>'232',
			'Estonia'=>'233',
			'Ethiopia'=>'231',
			'Falkland Islands (Malvinas)'=>'238',
			'Faroe Islands'=>'234',
			'Fiji'=>'242',
			'Finland'=>'246',
			'France'=>'250',
			'French Guiana'=>'254',
			'French Polynesia'=>'258',
			'French Southern Territories'=>'',
			'Gabon'=>'266',
			'Gambia'=>'270',
			'Georgia'=>'268',
			'Germany'=>'276',
			'Ghana'=>'288',
			'Gibraltar'=>'292',
			'Greece'=>'300',
			'Greenland'=>'304',
			'Grenada'=>'308',
			'Guadeloupe'=>'312',
			'Guam'=>'316',
			'Guatemala'=>'320',
			'Guinea'=>'324',
			'Guinea-bissau'=>'624',
			'Guyana'=>'328',
			'Haiti'=>'332',
			'Honduras'=>'340',
			'Hong Kong'=>'344',
			'Hungary'=>'348',
			'Iceland'=>'352',
			'India'=>'356',
			'Indonesia'=>'360',
			'Iran (Islamic Republic of)'=>'364',
			'Iraq'=>'368',
			'Ireland'=>'372',
			'Israel'=>'376',
			'Italy'=>'380',
			'Jamaica'=>'388',
			'Japan'=>'392',
			'Jordan'=>'400',
			'Kazakhstan'=>'398',
			'Kenya'=>'404',
			'Kiribati'=>'296',
			'Korea, Republic of'=>'410',
			'Kuwait'=>'414',
			'Kyrgyzstan'=>'417',
			'Lao People\'s Democratic Republic'=>'418',
			'Latvia'=>'428',
			'Lebanon'=>'422',
			'Lesotho'=>'426',
			'Liberia'=>'430',
			'Libyan Arab Jamahiriya'=>'434',
			'Liechtenstein'=>'438',
			'Lithuania'=>'440',
			'Luxembourg'=>'442',
			'Macau'=>'446',
			'Macedonia'=>'807',
			'Madagascar'=>'450',
			'Malawi'=>'454',
			'Malaysia'=>'458',
			'Maldives'=>'462',
			'Mali'=>'466',
			'Malta'=>'470',
			'Marshall Islands'=>'584',
			'Martinique'=>'474',
			'Mauritania'=>'478',
			'Mauritius'=>'480',
			'Mexico'=>'484',
			'Micronesia, Federated States of'=>'583',
			'Moldova, Republic of'=>'498',
			'Monaco'=>'492',
			'Mongolia'=>'496',
			'Montserrat'=>'500',
			'Morocco'=>'504',
			'Mozambique'=>'508',
			'Myanmar'=>'104',
			'Namibia'=>'516',
			'Nauru'=>'520',
			'Nepal'=>'524',
			'Netherlands'=>'528',
			'Netherlands Antilles'=>'530',
			'New Caledonia'=>'540',
			'New Zealand'=>'554',
			'Nicaragua'=>'558',
			'Niger'=>'562',
			'Nigeria'=>'566',
			'Niue'=>'570',
			'Norfolk Island'=>'574',
			'Northern Mariana Islands'=>'580',
			'Norway'=>'578',
			'Oman'=>'512',
			'Pakistan'=>'586',
			'Palau'=>'585',
			'Panama'=>'591',
			'Papua New Guinea'=>'598',
			'Paraguay'=>'600',
			'Peru'=>'604',
			'Philippines'=>'608',
			'Pitcairn'=>'612',
			'Poland'=>'616',
			'Portugal'=>'620',
			'Puerto Rico'=>'630',
			'Qatar'=>'634',
			'Reunion'=>'638',
			'Romania'=>'642',
			'Russian Federation'=>'643',
			'Rwanda'=>'646',
			'Saint Kitts and Nevis'=>'659',
			'Saint Lucia'=>'662',
			'Saint Vincent and the Grenadines'=>'670',
			'Samoa'=>'882',
			'San Marino'=>'674',
			'Sao Tome and Principe'=>'678',
			'Saudi Arabia'=>'682',
			'Senegal'=>'686',
			'Seychelles'=>'690',
			'Sierra Leone'=>'694',
			'Singapore'=>'702',
			'Slovak Republic'=>'703',
			'Slovenia'=>'705',
			'Solomon Islands'=>'90',
			'Somalia'=>'706',
			'South Africa'=>'710',
			'Spain'=>'724',
			'Sri Lanka'=>'144',
			'Sudan'=>'736',
			'Suriname'=>'740',
			'Svalbard and Jan Mayen Islands'=>'744',
			'Swaziland'=>'748',
			'Sweden'=>'752',
			'Switzerland'=>'756',
			'Syrian Arab Republic'=>'760',
			'Taiwan'=>'158',
			'Tajikistan'=>'762',
			'Tanzania, United Republic of'=>'834',
			'Thailand'=>'764',
			'Togo'=>'768',
			'Tokelau'=>'772',
			'Tonga'=>'776',
			'Trinidad and Tobago'=>'780',
			'Tunisia'=>'788',
			'Turkey'=>'792',
			'Turkmenistan'=>'795',
			'Turks and Caicos Islands'=>'796',
			'Tuvalu'=>'798',
			'Uganda'=>'800',
			'Ukraine'=>'804',
			'United Arab Emirates'=>'784',
			'United Kingdom'=>'826',
			'United States'=>'840',
			'Uruguay'=>'858',
			'Uzbekistan'=>'860',
			'Vanuatu'=>'548',
			'Vatican City State (Holy See)'=>'336',
			'Venezuela'=>'862',
			'Viet Nam'=>'704',
			'Virgin Islands (British)'=>'92',
			'Virgin Islands (U.S.)'=>'850',
			'Wallis and Futuna Islands'=>'876',
			'Western Sahara'=>'732',
			'Yemen'=>'887',
			'Zambia'=>'894',
			'Zimbabwe'=>'716'
			);

		
		if (in_array($order_info['currency_code'], array_keys($suppcurr)) && $this->currency->has($order_info['currency_code'])) {
			$currency = $order_info['currency_code'];
		} else {
			$currency = 'GBP';
		}
		
		if (in_array($order_info['payment_country'], array_keys($country_codes))) {
			$order_country = $country_codes[$order_info['payment_country']];
		} else {
			$order_country = '';
		}
		
		$amount = str_replace(array(',','.'), '',$this->currency->format($order_info['total'], $currency, FALSE, FALSE));
	
		$this->data['fields'] = array();
		$this->data['fields']['MerchantID'] = $this->config->get('paymentsense_hosted_mid');
		$this->data['fields']['Password'] = $this->config->get('paymentsense_hosted_pass');
		$this->data['fields']['Amount'] = $amount;
		$this->data['fields']['CurrencyCode'] = $suppcurr[$currency];
		$this->data['fields']['OrderID'] = $this->session->data['order_id'];
		$this->data['fields']['TransactionType'] = ($this->config->get('paymentsense_hosted_type')) ? 'SALE' : 'PREAUTH';
		$this->data['fields']['TransactionDateTime'] = (date("Y-m-d H:i:s O"));
		$this->data['fields']['CallbackURL'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=payment/paymentsense_hosted/callback');
		$this->data['fields']['OrderDescription'] = (($this->config->get('config_name')) ? $this->config->get('config_name') : $this->config->get('config_store'));
		$this->data['fields']['CustomerName'] = $order_info['payment_firstname'] . " " . $order_info['payment_lastname'];
		$this->data['fields']['Address1'] = $order_info['payment_address_1'];
		$this->data['fields']['Address2'] = $order_info['payment_address_2'];
		$this->data['fields']['Address3'] = '';
		$this->data['fields']['Address4'] = '';
		$this->data['fields']['City'] = $order_info['payment_city'];
		$this->data['fields']['State'] = $order_info['payment_zone'];
		$this->data['fields']['PostCode'] = $order_info['payment_postcode'];
		$this->data['fields']['CountryCode'] = $order_country;
				
		$this->data['fields']['CV2Mandatory'] = $this->config->get('paymentsense_hosted_cv2_mand');
		$this->data['fields']['Address1Mandatory'] = $this->config->get('paymentsense_hosted_address1_mand');
		$this->data['fields']['CityMandatory'] = $this->config->get('paymentsense_hosted_city_mand');
		$this->data['fields']['PostCodeMandatory'] = $this->config->get('paymentsense_hosted_postcode_mand');
		$this->data['fields']['StateMandatory'] = $this->config->get('paymentsense_hosted_state_mand');
		$this->data['fields']['CountryMandatory'] = $this->config->get('paymentsense_hosted_country_mand');
		
		$this->data['fields']['ResultDeliveryMethod'] = 'SERVER';
		$this->data['fields']['ServerResultURL'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=payment/paymentsense_hosted/postback');
		$this->data['fields']['PaymentFormDisplaysResult'] = 'FALSE';
		$this->data['fields']['ServerResultURLCookieVariables'] = '';
		$this->data['fields']['ServerResultURLFormVariables'] = '';
		$this->data['fields']['ServerResultURLQueryStringVariables'] = '';
		
		// Generate sha1 Hash		
		$sha1code = "PreSharedKey=".$this->config->get('paymentsense_hosted_key');
		foreach ($this->data['fields'] as $k => $v) {
			$sha1code .= "&" . $k . "=" . str_replace('&amp;', '&', $v);
		}
		$sha1code = sha1($sha1code);
		
		$this->data['fields']['HashDigest'] = $sha1code;
		
		unset($this->data['fields']['Password']);
		
		$this->data['back'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=checkout/payment');
		$this->id       = 'payment';
		//$this->template = $this->config->get('config_template') . 'payment/paymentsense_hosted.tpl';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paymentsense_hosted.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/paymentsense_hosted.tpl';
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/paymentsense_hosted.tpl')) {
            $this->template = $this->config->get('config_template') . '/payment/paymentsense_hosted.tpl';
        } else {
            $this->template = 'default/template/payment/paymentsense_hosted.tpl';
        }
		
		$this->render();		
	}
	
	public function confirm() {
		return;
	}
		
	public function postback() {
		$this->language->load('payment/paymentsense_hosted');
		$this->load->model('checkout/order');
		
		// PaymentSense Online Example Code
		// SERVER Postback Method - Handle Hosted Payment Form Response.
		
		// Platform:  PHP Example Code
		// Created:   24th Aug 2011
		// Updated:   24th Aug 2011
		// Version:   1.5.1.1
		// Created By:PaymentSense 
        // This code is provided on an "as is" basis. It is the responsibility of the developer to test its implementation.
		
		// The developer should amend this code in order to update the merchants website order system.
		// *PLEASE LOOK FOR "You should put your code that does any post transaction tasks".
		
		// The merchants system should store the status of the payment.
		// When the customer returns to the merchants website via the callback URL the status can then be sort so the correct response to the customer is displayed.
		// This page should echo a repsonse form the gateway to inform the gateway the message was delivered correctly.
		// Anything other than a "0" echoed in the response code for this page with envoke the gateway to send an email to the merchant with the error. The customer will then not return to the merchants website.
		// "0" simply means that the message was delivered correctly and is NOT an echo of the payment "StatusCode".
				
		// String together other strings using a "," as a seperator.
		function addStringToStringList($szExistingStringList, $szStringToAdd)
		{
			$szReturnString = "";
			$szCommaString = "";

			if (strlen($szStringToAdd) == 0)
			{
				$szReturnString = $szExistingStringList;
			}
			else
			{
				if (strlen($szExistingStringList) != 0)
				{
					$szCommaString = ", ";
				}
				$szReturnString = $szExistingStringList.$szCommaString.$szStringToAdd;
			}

			return ($szReturnString);
		}
		
		$szHashDigest = "";
		$szOutputMessage = "";
		$boErrorOccurred = false;
		$nStatusCode = 30;
		$szMessage = "";
		$nPreviousStatusCode = 0;
		$szPreviousMessage = "";
		$szCrossReference = "";
		$nAmount = 0;
		$nCurrencyCode = 0;
		$szOrderID = "";
		$szTransactionType= "";
		$szTransactionDateTime = "";
		$szOrderDescription = "";
		$szCustomerName = "";
		$szAddress1 = "";
		$szAddress2 = "";
		$szAddress3 = "";
		$szAddress4 = "";
		$szCity = "";
		$szState = "";
		$szPostCode = "";
		$nCountryCode = "";

		try
			{
				// hash digest
				if (isset($this->request->post["HashDigest"]))
				{
					$szHashDigest = $this->request->post["HashDigest"];
				}

				// transaction status code
				if (!isset($this->request->post["StatusCode"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [StatusCode] not received");
					$boErrorOccurred = true;
				}
				else
				{
					if ($this->request->post["StatusCode"] == "")
					{
						$nStatusCode = null;

					}
					else
					{
						$nStatusCode = intval($this->request->post["StatusCode"]);
					}
				}
				// transaction message
				if (!isset($this->request->post["Message"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Message] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szMessage = $this->request->post["Message"];
				}
				// status code of original transaction if this transaction was deemed a duplicate
				if (!isset($this->request->post["PreviousStatusCode"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PreviousStatusCode] not received");
					$boErrorOccurred = true;
				}
				else
				{
					if ($this->request->post["PreviousStatusCode"] == "")
					{
						$nPreviousStatusCode = null;
					}
					else
					{
						$nPreviousStatusCode = intval($this->request->post["PreviousStatusCode"]);
					}
				}
				// status code of original transaction if this transaction was deemed a duplicate
				if (!isset($this->request->post["PreviousMessage"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PreviousMessage] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szPreviousMessage = $this->request->post["PreviousMessage"];
				}
				// cross reference of transaction
				if (!isset($this->request->post["CrossReference"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CrossReference] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szCrossReference = $this->request->post["CrossReference"];
				}
				// amount (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["Amount"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Amount] not received");
					$boErrorOccurred = true;
				}
				else
				{
					if ($this->request->post["Amount"] == null)
					{
						$nAmount = null;
					}
					else
					{
						$nAmount = intval($this->request->post["Amount"]);
					}
				}
				// currency code (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["CurrencyCode"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CurrencyCode] not received");
					$boErrorOccurred = true;
				}
				else
				{
					if ($this->request->post["CurrencyCode"] == null)
					{
						$nCurrencyCode = null;
					}
					else
					{
						$nCurrencyCode = intval($this->request->post["CurrencyCode"]);
					}
				}
				// order ID (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["OrderID"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [OrderID] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szOrderID = $this->request->post["OrderID"];
				}
				// transaction type (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["TransactionType"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [TransactionType] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szTransactionType = $this->request->post["TransactionType"];
				}
				// transaction date/time (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["TransactionDateTime"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [TransactionDateTime] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szTransactionDateTime = $this->request->post["TransactionDateTime"];
				}
				// order description (same as value passed into payment form - echoed back out by payment form)
				if (!isset($this->request->post["OrderDescription"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [OrderDescription] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szOrderDescription = $this->request->post["OrderDescription"];
				}
				// customer name (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["CustomerName"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CustomerName] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szCustomerName = $this->request->post["CustomerName"];
				}
				// address1 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["Address1"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address1] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szAddress1 = $this->request->post["Address1"];
				}
				// address2 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["Address2"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address2] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szAddress2 = $this->request->post["Address2"];
				}
				// address3 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["Address3"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address3] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szAddress3 = $this->request->post["Address3"];
				}
				// address4 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["Address4"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address4] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szAddress4 = $this->request->post["Address4"];
				}
				// city (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["City"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [City] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szCity = $this->request->post["City"];
				}
				// state (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["State"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [State] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szState = $this->request->post["State"];
				}
				// post code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["PostCode"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PostCode] not received");
					$boErrorOccurred = true;
				}
				else
				{
					$szPostCode = $this->request->post["PostCode"];
				}
				// country code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
				if (!isset($this->request->post["CountryCode"]))
				{
					$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CountryCode] not received");
					$boErrorOccurred = true;
				}
				else
				{
					if ($this->request->post["CountryCode"] == "")
					{
						$nCountryCode = null;
					}
					else
					{
						$nCountryCode = intval($this->request->post["CountryCode"]);
					}
				}
			}
		catch (Exception $e)
		{
			$boErrorOccurred = true;
			$szOutputMessage = "Error";
			if (isset($this->request->post["Message"]))
			{
				$szOutputMessage = $this->request->post["Message"];
			}
		}
	
	// The nOutputProcessedOK should return 0 except if there has been an error talking to the gateway or updating the website order system.
	// Any other process status shown to the gateway will prompt the gateway to send an email to the merchant stating the error.
	// The customer will also be shown a message on the hosted payment form detailing the error and will not return to the merchants website.
	$nOutputProcessedOK = 0;
	
	if (is_null($nStatusCode))
	{
		$nOutputProcessedOK = 30;		
	}
	
	if ($boErrorOccurred == true)
	{
		$nOutputProcessedOK = 30;
	}
	
	// Check the passed HashDigest against our own to check the values passed are legitimate.
	if(isset($this->request->post["HashDigest"])) {
		$PostHash = $this->request->post["HashDigest"];
				
		$hashcode="PreSharedKey=" . $this->config->get('paymentsense_hosted_key');
		$hashcode=$hashcode . '&MerchantID=' . $this->request->post["MerchantID"];
		$hashcode=$hashcode . '&Password=' . $this->config->get('paymentsense_hosted_pass');
		$hashcode=$hashcode . '&StatusCode=' . $this->request->post["StatusCode"];
		$hashcode=$hashcode . '&Message=' . $this->request->post["Message"];
		$hashcode=$hashcode . '&PreviousStatusCode=' . $this->request->post["PreviousStatusCode"];
		$hashcode=$hashcode . '&PreviousMessage=' . $this->request->post["PreviousMessage"];
		$hashcode=$hashcode . '&CrossReference=' . $this->request->post["CrossReference"];
		$hashcode=$hashcode . '&Amount=' . $this->request->post["Amount"];
		$hashcode=$hashcode . '&CurrencyCode=' . $this->request->post["CurrencyCode"];
		$hashcode=$hashcode . '&OrderID=' . $this->request->post["OrderID"];
		$hashcode=$hashcode . '&TransactionType=' . $this->request->post["TransactionType"];
		$hashcode=$hashcode . '&TransactionDateTime=' . $this->request->post["TransactionDateTime"];
		$hashcode=$hashcode . '&OrderDescription=' . $this->request->post["OrderDescription"];
		$hashcode=$hashcode . '&CustomerName=' . $this->request->post["CustomerName"];
		$hashcode=$hashcode . '&Address1=' . $this->request->post["Address1"];
		$hashcode=$hashcode . '&Address2=' . $this->request->post["Address2"];
		$hashcode=$hashcode . '&Address3=' . $this->request->post["Address3"];
		$hashcode=$hashcode . '&Address4=' . $this->request->post["Address4"];
		$hashcode=$hashcode . '&City=' . $this->request->post["City"];
		$hashcode=$hashcode . '&State=' . $this->request->post["State"];
		$hashcode=$hashcode . '&PostCode=' . $this->request->post["PostCode"];
		$hashcode=$hashcode . '&CountryCode=' . $this->request->post["CountryCode"];
		$hashcode = sha1($hashcode);
		
		if ($hashcode != $PostHash) {
			$nOutputProcessedOK = 30; 
			$szOutputMessage = "Hashes did not match";
		}
	} else {
		$nOutputProcessedOK = 30;
		$szOutputMessage = "HashDigest is missing";
	}
	// *********************************************************************************************************
	// You should put your code that does any post transaction tasks
	// (e.g. updates the order object, sends the customer an email etc) in this section
	// *********************************************************************************************************
	if ($nOutputProcessedOK != 30)
		{	
			$nOutputProcessedOK = 0;
			$szOutputMessage = $szMessage;
			try
			{
				switch ($nStatusCode)
				{
					// transaction authorised
					case 0:
						$transauthorised = true;
						break;
					// card referred (treat as decline)
					case 4:
						$transauthorised = false;
						break;
					// transaction declined
					case 5:
						$transauthorised = false;
						break;
					// duplicate transaction
					case 20:
						// need to look at the previous status code to see if the
						// transaction was successful
						if ($nPreviousStatusCode == 0)
						{
							// transaction authorised
							$transauthorised = true;
						}
						else
						{
							// transaction not authorised
							$transauthorised = false;
						}
						break;
					// error occurred
					case 30:
						$transauthorised = false;
						break;
					default:
						$transauthorised = false;
						break;
				}
			
				if ($transauthorised == true) {
					// put code here to update/store the order with the a successful transaction result
					$this->model_checkout_order->confirm($szOrderID, $this->config->get('paymentsense_hosted_order_status_id'), $szMessage  . " || Cross Reference: ". $szCrossReference);
					$this->db->query("INSERT INTO paymentsense SET cs_order_id = ". $szOrderID .", cs_trans_date = now(), cs_trans_gbp = ". $nAmount .", cs_message = '". $szMessage ."', cs_cross_ref = '".$szCrossReference."'");
					$nOutputProcessedOK = 0;
					$szOutputMessage = "";	
				} else {
					// put code here to update/store the order with the a failed transaction result
					$this->db->query("INSERT INTO paymentsense SET cs_order_id = ". $szOrderID .", cs_trans_date = now(), cs_trans_gbp = ". $nAmount .", cs_message = '". $szMessage ."', cs_cross_ref = '".$szCrossReference."'");
					$nOutputProcessedOK = 0;
					$szOutputMessage = "";
				}
			}
			catch (Exception $e)
			{
				$nOutputProcessedOK = 30;
				$szOutputMessage = "Error updating website system, please ask the developer to check code";
			}
        }

	if ($nOutputProcessedOK != 0 && $szOutputMessage == "")
	{
		$szOutputMessage = "Unknown error";
	}
		
	// output the status code and message letting the payment form
	// know whether the transaction result was processed successfully
	echo("StatusCode=".$nOutputProcessedOK."&Message=".$szOutputMessage);	
				
	}
		
	public function callback() {
		$this->language->load('payment/paymentsense_hosted');
		$this->load->model('checkout/order');
		
		$this->data['charset'] = $this->language->get('charset');
		$this->data['language'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
	
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
		
		$this->data['text_response'] = $this->language->get('text_response');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success'));
		$this->data['text_failure'] = $this->language->get('text_failure');
		$this->data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart'));
		
		// Debug
		if ($this->config->get('paymentsense_hosted_debug')) {
			if (isset($_POST)) {
				$p_msg = "DEBUG POST VARS:\n"; foreach($_POST as $k=>$v) { $p_msg .= $k."=".$v."\n"; }
			}
			if (isset($_GET)) {
				$g_msg = "DEBUG GET VARS:\n"; foreach($_GET as $k=>$v) { $g_msg .= $k."=".$v."\n"; }
			}
			$msg = ($p_msg . "\r\n" . $g_msg);
			mail($this->config->get('config_email'), 'paymentsense_hosted_debug', $msg);
			if (is_writable(getcwd())) {
				file_put_contents('paymentsense_hosted_debug.txt', $msg);
			}
		}
		
		$order_id = $this->request->get['OrderID'];
		$order_info = $this->model_checkout_order->getOrder($order_id);		
		
		// If there is no order info then fail.
		if (!$order_info) {
			$this->session->data['error'] = $this->language->get('error_no_order');
			$this->redirect((isset($this->session->data['guest'])) ? $this->url->link('checkout/guest_step_3', '', 'SSL') : $this->url->link('checkout/confirm', '', 'SSL')); 			
		}
		
		if ($order_info['order_status_id'] == $this->config->get('paymentsense_hosted_order_status_id')) {			
			$this->redirect($this->url->link('checkout/success', '', 'SSL'));			
		} else {
			$status_query = $this->db->query("SELECT * FROM paymentsense WHERE cs_order_id = ".$order_id);
			
			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);
	
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('button_checkout'),
				'href'      => $this->url->link('checkout/checkout', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);
			
			foreach ($status_query->rows as $status) {
				$errormessage = $status['cs_message'];
			}
			
			$this->data['heading_title'] = $this->language->get('text_payment_failed_title');
			$this->data['text_message'] = $this->language->get('text_payment_failed') . '<p><b>' . $errormessage . '</b></p><p>Please try your payment again.</p>';
			//$this->url->link('information/contact')
			$this->data['button_continue'] = $this->language->get('button_checkout');
			$this->data['continue'] = $this->url->link('checkout/checkout');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
			} else {
				$this->template = 'default/template/common/success.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
			
			$this->response->setOutput($this->render());
			
			//$this->redirect((isset($this->session->data['guest'])) ? $this->url->link('checkout/guest_step_3', '', 'SSL') : $this->url->link('checkout/confirm', '', 'SSL'));
		}
				
	}
}
?>