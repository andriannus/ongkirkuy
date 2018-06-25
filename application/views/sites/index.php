<div id="app">
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
					<p class="title has-text-centered" v-if="loading">
						<i class="fas fa-spinner fa-spin"></i>
					</p>

					<div class="has-text-centered" v-if="!loading && limit">
						<p class="title">
							<i class="fas fa-frown"></i>
						</p>
						<p class="subtitle">
							Maaf, Cek Ongkir sudah mencapai limit harian. <br>
							Silahkan coba esok hari
						</p>
					</div>

					<div class="card" v-if="!loading && !limit">
						<div class="card-header">
							<p class="card-header-title">Cek Ongkir Disini</p>
						</div>
						
						<div class="card-content">
							<div class="content">
								<form>
									<div class="field">
										<label class="label">Asal&nbsp;<i class="fas fa-plane-departure"></i></label>
										<div class="control">
											<div class="select is-loading" v-if="loadingProvinceOrigin">
												<select>
													<option>Memuat Provinsi</option>
												</select>
											</div>
											<div class="select" v-if="!loadingProvinceOrigin">
												<select v-model="provinceOrigin" @change="getCity(provinceOrigin, null)">
													<option
														v-for="(province, index) in provinces"
														:value="province.province_id"
													>{{ province.province }}</option>
												</select>
											</div>
										</div>

										<div class="control" style="margin-top: 5px;">
											<div class="select is-loading" v-if="loadingCitiesOrigin">
												<select>
													<option>Memuat Kota/Kabupaten</option>
												</select>
											</div>
											<div class="select" v-if="!loadingCitiesOrigin">
												<select v-model="origin">
													<option v-for="(city, index) in citiesOrigin" :value="city.city_id">{{ city.type + ' ' + city.city_name }}</option>
												</select>
											</div>
										</div>
									</div>

									<hr>

									<div class="field">
										<label class="label">Tujuan&nbsp;<i class="fas fa-plane-arrival"></i></label>
										<div class="control">
											<div class="select is-loading" v-if="loadingProvinceDestination">
												<select>
													<option>Memuat Provinsi</option>
												</select>
											</div>
											<div class="select" v-if="!loadingProvinceDestination">
												<select v-model="provinceDestination" @change="getCity(null, provinceDestination)">
													<option
														v-for="(province, index) in provinces"
														:value="province.province_id"
													>{{ province.province }}</option>
												</select>
											</div>
										</div>

										<div class="control" style="margin-top: 5px;">
											<div class="select is-loading" v-if="loadingCitiesDestination">
												<select>
													<option>Memuat Kota/Kabupaten</option>
												</select>
											</div>
											<div class="select" v-if="!loadingCitiesDestination">
												<select v-model="destination">
													<option v-for="(city, index) in citiesDestination" :value="city.city_id">{{ city.type + ' ' + city.city_name }}</option>
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
														<select v-model="courier">
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
														<input class="input" v-model="weight" type="number" min="100" step="100"/>
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
								<button
									type="button"
									class="button
									is-link is-outlined"
									:disabled="!origin || !destination || !weight || loadingCitiesOrigin || loadingCitiesDestination"
									@click="postCost"
									v-if="!loadingPost"
								>Submit</button>
								<button type="button" class="button is-link is-loading" v-if="loadingPost">Submit</button>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
const app = new Vue({
	el: '#app',
	data: () => ({
		origin: '',
		destination: '',
		weight: 1000,
		courier: 'jne',
		provinceOrigin: '',
		provinceDestination: '',
		provinces: {},
		citiesOrigin: {},
		citiesDestination: {},
		loadingProvinceOrigin: true,
		loadingProvinceDestination: true,
		loadingCitiesOrigin: true,
		loadingCitiesDestination: true,
		loadingPost: false,
		loading: true,
		limit: false
	}),

	created () {
		this.getProvince(),
		this.resetCost()
	},

	methods: {
		getProvince () {
			this.loadingProvinceOrigin = true
			this.loadingProvinceDestination = true
			axios.get('<?= base_url() ?>' + 'curl/getprovince')
				.then(res => {
					if (res.data.rajaongkir.status.code === 400) {
						this.loading = false
						this.limit = true

					} else {
						this.provinces = res.data.rajaongkir.results
						this.provinceOrigin = this.provinces[0].province_id
						this.provinceDestination = this.provinces[0].province_id

						this.getCity(this.provinceOrigin, null)
						this.getCity(null, this.provinceDestination)
						this.loadingProvinceOrigin = false
						this.loadingProvinceDestination = false

						this.loading = false
					}
				})
				.catch(err => {
					this.loadingProvinceOrigin = false
					alert('Terjadi error. Silahkan coba kembali')
				})
		},

		getCity (province_id_origin, province_id_destination) {
			if (province_id_origin) {
				this.loadingCitiesOrigin = true
			}
			if (province_id_destination) {
				this.loadingCitiesDestination = true
			}

			axios.get('<?= base_url() ?>' + 'curl/getcity/' + (province_id_origin ? province_id_origin : province_id_destination))
				.then(res => {
					if (province_id_origin) {
						this.citiesOrigin = res.data.rajaongkir.results
						this.origin = this.citiesOrigin[0].city_id
						this.loadingCitiesOrigin = false
					}

					if (province_id_destination) {
						this.citiesDestination = res.data.rajaongkir.results
						this.destination = this.citiesDestination[0].city_id
						this.loadingCitiesDestination = false
					}
				})
				.catch(err => {
					console.log(err)
				})
		},

		postCost () {
			this.loadingPost = true
			let cost = 'origin=' + this.origin + '&destination=' + this.destination + '&weight=' + this.weight + '&courier=' + this.courier
			axios.post('<?= base_url() ?>' + 'curl/postcost', cost)
				.then(res => {
					console.log(res)
					localStorage.setItem('cost', JSON.stringify(res.data.rajaongkir))
					window.location.replace('<?= base_url() ?>' + 'site/result')
					this.loadingPost = false
				})
				.catch(err => {
					alert('Terjadi error. Silahkan coba kembali')
					this.loadingPost = false
				})
		},

		resetCost () {
			localStorage.clear()
		}
	}
})
</script>
