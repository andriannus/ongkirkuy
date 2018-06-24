<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl extends CI_Controller {

	public $curl;

	public function __construct()
	{
		parent::__construct();
		$this->curl = curl_init();
	}

	public function getProvince()
	{
		curl_setopt_array($this->curl, [
			CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"key: 7d66ae06d7ea32154c0c977bc9d1636e"
			],
		]);

		$response = curl_exec($this->curl);
		$err = curl_error($this->curl);

		curl_close($this->curl);

		if ($err) {
			echo "cURL Error #: " . $err;
		} else {
			echo $response;
		}
	}

	public function getCity($province)
	{
		if (isset($province)) {
			curl_setopt_array($this->curl, [
				CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$province,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => [
					"key: 7d66ae06d7ea32154c0c977bc9d1636e"
				],
			]);

		} else {
			curl_setopt_array($this->curl, [
				CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => [
					"key: 7d66ae06d7ea32154c0c977bc9d1636e"
				],
			]);
		}

		$response = curl_exec($this->curl);
		$err = curl_error($this->curl);

		curl_close($this->curl);

		if ($err) {
			echo "cURL Error #: " . $err;
		} else {
			echo $response;
		}
	}

	public function postCost()
	{
		$o = $this->input->post('origin');
		$d = $this->input->post('destination');
		$w = $this->input->post('weight');
		$c = $this->input->post('courier');

		curl_setopt_array($this->curl, [
			CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=".$o."&destination=".$d."&weight=".$w."&courier=".$c,
			CURLOPT_HTTPHEADER => [
				"content-type: application/x-www-form-urlencoded",
				"key: 7d66ae06d7ea32154c0c977bc9d1636e"
			],
		]);

		$response = curl_exec($this->curl);
		$err = curl_error($this->curl);

		curl_close($this->curl);

		if ($err) {
			echo "cURL Error #: " . $err;
		} else {
			echo $response;
		}
	}
}
