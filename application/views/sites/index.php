<section class="hero is-info">
	<div class="hero-body">
		<div class="container">
			<h1 class="title">Selamat datang <i class="far fa-smile-beam"></i></h1>
			<h2 class="subtitle">di OngkirKuy</h2>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="columns">
			<div class="column is-6 is-offset-3">
				<div class="card">
					<div class="card-header">
						<p class="card-header-title">Cek Ongkir Disini</p>
					</div>
					
					<div class="card-content">
						<div class="content">
							<form method="post" action="<?= base_url('curl/postcost') ?>" id="form-ongkir">
								<div class="field">
									<label class="label">Asal&nbsp;<i class="fas fa-plane-departure"></i></label>
									<div class="control">
										<div class="select">
											<select name="province-origin" id="province-origin" disabled>
												<option>Provinsi</option>
											</select>
										</div>
									</div>

									<div class="control" style="margin-top: 5px;">
										<div class="select">
											<select name="origin" id="city-origin" disabled>
												<option>Kota/Kabupaten</option>
											</select>
										</div>
									</div>
								</div>

								<hr>

								<div class="field">
									<label class="label">Tujuan&nbsp;<i class="fas fa-plane-arrival"></i></label>
									<div class="control">
										<div class="select">
											<select name="province-destination" id="province-destination" disabled>
												<option>Provinsi</option>
											</select>
										</div>
									</div>

									<div class="control" style="margin-top: 5px;">
										<div class="select">
											<select name="destination" id="city-destination" disabled>
												<option>Kota/Kabupaten</option>
											</select>
										</div>
									</div>
								</div>

								<hr>

								<div class="field">
									<div class="columns">
										<div class="column">
											<label class="label">Pilih Jasa Pengiriman&nbsp;<i class="fas fa-check-circle"></i></label>
											<div class="control">
												<div class="select">
													<select name="courier">
														<option value="jne">JNE</option>
														<option value="tiki">TIKI</option>
														<option value="pos">POS Indonesia</option>
													</select>
												</div>
											</div>
										</div>

										<div class="column">
											<label class="label">Berat Barang&nbsp;<i class="fas fa-weight"></i></label>
											<div class="field has-addons">
												<p class="control">
													<input id="weight" class="input" name="weight" type="number" min="100" step="100" value="1000"/>
												</p>
												<p class="control">
													<a class="button is-static">gram</a>
												</p>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card-footer">
						<p class="card-footer-item">
							<button type="button" id="button-no-loading" class="button is-link is-outlined">Submit</button>
							<button type="button" id="button-is-loading" class="button is-link is-loading">Submit</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$('#button-is-loading').hide()

	$('#province-origin').change(() => {
		let province_id_origin = $('#province-origin').val()
		$('#city-origin').prop('disabled', true)
		checkStatus()
		getCity(province_id_origin, null)
	})

	$('#province-destination').change(() => {
		let province_id_destination = $('#province-destination').val()
		$('#city-destination').prop('disabled', true)
		checkStatus()
		getCity(null, province_id_destination)
	})

	$('#button-no-loading').click(() => {
		$('#button-no-loading').hide()
		$('#button-is-loading').show()

		if ($('#weight').val() === '') {
			alert('Berat barang harus diisi')

			$('#button-no-loading').show()
			$('#button-is-loading').hide()
		} else {
			postCost()
		}
	})

	checkStatus()
	getProvince()
	resetCost()

	function resetCost () {
		localStorage.clear()
	}

	function checkStatus () {
		if ($('#city-origin').is(':disabled') || $('#city-destination').is(':disabled') || $('#weight').val() === '') {
			$('#button-no-loading').prop('disabled', true)
		} else {
			$('#button-no-loading').prop('disabled', false)
		}
	}

	function getProvince () {
		$.ajax({
			type: 'get',
			url: '<?= base_url() ?>' + 'curl/getprovince',
			dataType: 'json',
			success: (res) => {
				let html = ''

				for (let i=0; i<res.rajaongkir.results.length; i++) {
					html += '<option value="' + res.rajaongkir.results[i].province_id + '">' +
								res.rajaongkir.results[i].province +
							'</option>'
				}

				$('#province-origin').html(html)
				$('#province-origin').prop('disabled', false)

				$('#province-destination').html(html)
				$('#province-destination').prop('disabled', false)

				getCity($('#province-origin').val(), null)
				getCity(null, $('#province-destination').val())
			},
			error: (err) => {
				alert('Terjadi error. Silahkan refresh halaman')
			}
		})
	}

	function getCity (province_id_origin, province_id_destination) {
		$.ajax({
			type: 'get',
			url: '<?= base_url() ?>' + 'curl/getcity/' + (province_id_origin ? province_id_origin : province_id_destination),
			dataType: 'json',
			success: (res) => {
				let html = ''

				for (let i=0; i<res.rajaongkir.results.length; i++) {
					html += '<option value="' + res.rajaongkir.results[i].city_id + '">' +
								res.rajaongkir.results[i].type + ' ' + res.rajaongkir.results[i].city_name
							'</option>'
				}

				if (province_id_origin) {
					$('#city-origin').html(html)
					$('#city-origin').prop('disabled', false)
					checkStatus()
				}

				if (province_id_destination) {
					$('#city-destination').html(html)
					$('#city-destination').prop('disabled', false)
					checkStatus()
				}

			},
			error: (err) => {
				console.log(err)
			}
		})
	}

	function postCost() {
		let data = $('#form-ongkir').serialize()
		let url = $('#form-ongkir').attr('action')

		$.ajax({
			type: 'post',
			url: url,
			data: data,
			dataType: 'json',
			success: (res) => {
				localStorage.setItem('cost', JSON.stringify(res.rajaongkir))

				$('#button-is-loading').hide();
				$('#button-no-loading').show();

				window.location.replace('<?= base_url() ?>' + 'site/result')
			},
			error: (err) => {
				alert('Terjadi error. Silahkan coba kembali')
				$('#button-is-loading').hide();
				$('#button-no-loading').show();
			}
		})
	}
</script>
