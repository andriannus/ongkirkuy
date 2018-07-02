<div id="app">
	<section class="hero is-info">
		<div class="hero-body">
			<div class="container wow slideInLeft" data-wow-duration="2s" data-wow-offset="0">
				<h1 class="title">Hasil Perhitungan Ongkos Kirim <i class="fas fa-clipboard-check"></i></h1>
				<h2 class="subtitle">di OngkirKuy</h2>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-8 is-offset-2">
					<div v-if="found">
						<div class="card wow zoomIn" data-wow-duration="2s" data-wow-offset="0">
							<header class="card-header">
								<p class="card-header-title">Detail Pengiriman</p>
							</header>
							<div class="card-content">
								<div class="content">
									<p class="title">Asal</p>
									<p class="subtitle">{{ originDetail }}</p>
								</div>

								<div class="content">
									<p class="title">Tujuan</p>
									<p class="subtitle">{{ destinationDetail }}</p>
								</div>

								<div class="content">
									<p class="title">Berat Barang</p>
									<p class="subtitle">{{ weightDetail }}</p>
								</div>
							</div>
						</div>

						<hr>

						<div class="table-responsive wow zoomIn" data-wow-duration="2s" data-wow-offset="0">
							<table class="table is-fullwidth is-striped is-bordered">
								<thead>
									<tr>
										<th colspan="4" class="has-text-centered">{{ courierName }}</th>
									</tr>
									<tr>
										<th width="25%">Layanan</th>
										<th width="35%">Deskripsi</th>
										<th width="20%">Biaya</th>
										<th width="20%">Estimasi</th>
									</tr>
								</thead>
								<tbody v-for="(cost, index) in costs">
									<tr>
										<td>{{ cost.service }}</td>
										<td>{{ cost.description }}</td>
										<td>Rp. {{ cost.cost[0].value | numberFormat }}</td>
										<td v-if="cost.cost[0].etd">{{ cost.cost[0].etd | deleteString }} hari</td>
										<td v-if="!cost.cost[0].etd">-</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<p v-if="!found" class="title wow zoomIn" data-wow-duration="2s" data-wow-delay="1s" data-wow-offset="0">
						Data <u>kadaluwarsa</u> atau <u>tidak tersedia</u>. Silahkan cek kembali.
					</p>

					<hr>

					<a class="button is-link is-outlined wow zoomIn" href="<?= base_url('site/index') ?>" data-wow-duration="2s" data-wow-delay="1s" data-wow-offset="0">
						<i class="fa fa-arrow-left"></i>&nbsp; Cek Kembali
					</a>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
const app = new Vue({
	el: '#app',

	data: () => ({
		costs: {},
		originDetail: '',
		destinationDetail: '',
		weightDetail: '',
		courierName: '',
		found: true
	}),

	created () {
		this.fetchData()
	},

	methods: {
		fetchData () {
			let data = localStorage.getItem('cost')
	
			if (data === null) {
				this.found = false

			} else {
				let parse = JSON.parse(data)
				let cost = parse.results[0]
				let origin = parse.origin_details
				let destination = parse.destination_details
				let weight = parse.query.weight

				if (cost.costs.length === 0) {
					this.found = false

				} else {
					this.costs = cost.costs

					this.originDetail = origin.type + ' ' + origin.city_name + ', ' + origin.province + ', ' + origin.postal_code
					this.destinationDetail = destination.type + ' ' + destination.city_name + ', ' + destination.province + ', ' + destination.postal_code
					this.weightDetail = weight + ' gram'
					this.courierName = parse.results[0].name

					this.resetCost()
				}
			}
		},

		resetCost () {
			localStorage.clear()
		}
	},

	filters: {
		numberFormat: (number) => number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
		deleteString: (string) => string.search('HARI') != -1 ? string.replace('HARI', '') : string
	}
})
</script>