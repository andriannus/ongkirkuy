<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public $app = 'cores/layouts/app';

	public function index()
	{
		$data = [
			'title' => 'Selamat datang di OngkirKuy',
			'page' => 'sites/index'
		];

		$this->load->view($this->app, $data);
	}

	public function result()
	{
		$data = [
			'title' => 'Hasil Perhitungan Ongkos Kirim - OngkirKuy',
			'page' => 'sites/result'
		];

		$this->load->view($this->app, $data);
	}
}
