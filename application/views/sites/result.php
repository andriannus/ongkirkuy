<section class="hero is-info">
	<div class="hero-body">
		<div class="container">
			<h1 class="title">Hasil Perhitungan Ongkos Kirim <i class="fas fa-clipboard-check"></i></h1>
			<h2 class="subtitle">di OngkirKuy</h2>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="columns">
			<div class="column is-8 is-offset-2">
				<div id="found">
					<div class="card">
						<header class="card-header">
							<p class="card-header-title">Detail Pengiriman</p>
						</header>
						<div class="card-content">
							<div class="content">
								<p class="title">Asal</p>
								<p class="subtitle">
									<span id="origin-detail"></span>
								</p>
							</div>

							<div class="content">
								<p class="title">Tujuan</p>
								<p class="subtitle">
									<span id="destination-detail"></span>
								</p>
							</div>

							<div class="content">
								<p class="title">Berat Barang</p>
								<p class="subtitle">
									<span id="weight"></span>
								</p>
							</div>
						</div>
					</div>

					<hr>

					<div class="table-responsive">
						<table class="table is-fullwidth is-striped is-bordered">
							<thead>
								<tr>
									<th colspan="4" class="has-text-centered">
										<span class="name"></span>
									</th>
								</tr>
								<tr>
									<th width="25%">Layanan</th>
									<th width="35%">Deskripsi</th>
									<th width="20%">Biaya</th>
									<th width="20%">Estimasi</th>
								</tr>
							</thead>
							<tbody id="result">
							</tbody>
						</table>
					</div>
				</div>

				<p id="not-found" class="title">Data <u>kadaluwarsa</u> atau <u>tidak tersedia</u>. Silahkan cek kembali.</p>

				<hr>

				<a class="button is-link is-outlined" href="<?= base_url('site/index') ?>"><i class="fa fa-arrow-left"></i>&nbsp; Cek Kembali</a>
			</div>
		</div>
	</div>
</section>

<script>
	$('#not-found').hide()

	function resetCost () {
		localStorage.clear()
	}
	
	$(document).ready(() => {
		let data = localStorage.getItem('cost')
		
		if (data === null) {
			$('#found').hide()
			$('#not-found').show()

		} else {
			let parse = JSON.parse(data)
			let cost = parse.results[0]
			let origin = parse.origin_details
			let destination = parse.destination_details
			let weight = parse.query.weight

			if (cost.costs.length === 0) {
				$('#found').hide()
				$('#not-found').show()

			} else {
				let html = ''

				for (let i=0; i<cost.costs.length; i++) {
					html += '<tr>' +
								'<td>' + cost.costs[i].service + '</td>' +
								'<td>' + cost.costs[i].description + '</td>' +
								'<td> Rp. ' + numberFormat(cost.costs[i].cost[0].value) + '</td>' +
								'<td>' + (cost.costs[i].cost[0].etd ? deleteString(cost.costs[i].cost[0].etd) + ' hari' : '-') + ' </td>' +
							'</tr>'

					$('#result').html(html)
				}

				$('.name').html(parse.results[0].name)


				let originDetail = origin.type + ' ' + origin.city_name + ', ' + origin.province + ', ' + origin.postal_code
				$('#origin-detail').html(originDetail)

				let destinationDetail = destination.type + ' ' + destination.city_name + ', ' + destination.province + ', ' + destination.postal_code
				$('#destination-detail').html(destinationDetail)

				let weightDetail = weight + ' gram'
				$('#weight').html(weightDetail)

				resetCost()
			}

			function numberFormat (num) {
				return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			}

			function deleteString (string) {
				if (string.search('HARI') != -1) {
					return string.replace('HARI', '')
				} else {
					return string
				}
			}
		}
	})
</script>