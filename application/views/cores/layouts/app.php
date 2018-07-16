<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<meta name="keywords" contnet="check, shipping, rajaongkir, API, PHP, CodeIgniter, JavaScript, Vue">
	<meta name="description" content="Check shipping rates with API from RajaOngkir">
	<meta name="author" content="Andriannus Parasian">

	<title><?= $title ?></title>
	<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/fav.png'); ?>"/>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<script src="<?= base_url('assets/js/wow.min.js'); ?>"></script>
	<script src="https://unpkg.com/vue@2.5.16/dist/vue.min.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

	<style>
		.table-responsive {
			overflow-x: auto;
		}
	</style>
</head>
<body>
	<?php $this->load->view('cores/elements/navigation') ?>
	
	<?php $this->load->view($page) ?>

	<script>
	wow = new WOW({}).init();
	</script>
</body>
</html>
