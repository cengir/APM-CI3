
<div class="row" style="margin-bottom: 20px">
	<div class="col-lg-12">
		<div class="panel panel-container">
			<div class="panel-body">
				<form method="post" id="formTambah" action="<?= base_url('admin/post_update_paket/' . $data['id']) ?>">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Kode Paket:</label>
							<input type="text" id="kode_paket" name="kode_paket" readonly="" class="form-control" value="<?= $data['kode_paket'] ?>">
						</div>
						<div class="form-group">
							<label>Nama Mobil:</label>
							<input type="text" id="nama_mobil" name="nama_mobil" class="form-control" value="<?= $data['nama_mobil'] ?>">
						</div>
						<div class="form-group">
							<label>Harga Mobile:</label>
							<input type="text" id="harga_mobil" name="harga_mobil" class="form-control" value="<?= $data['harga_mobil'] ?>">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group"> 
							<label>Jumlah Cicilan/bulan:</label>
							<select name="cicilan" id="cicilan" class="form-control">
								<option value="12" <?= ($data['cicilan'] === '12' ? 'selected' : false) ?>>12</option>
								<option value="24" <?= ($data['cicilan'] === '24' ? 'selected' : false) ?>>24</option>
								<option value="36" <?= ($data['cicilan'] === '36' ? 'selected' : false) ?>>36</option>
								<option value="48" <?= ($data['cicilan'] === '48' ? 'selected' : false) ?>>48</option>
							</select>
						</div>
						<div class="form-group">
							<label>Bunga Hutang Pokok:</label>
							<input type="text" maxlength="3" id="bunga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="bunga" class="form-control" value="<?= $data['bunga'] ?>">
						</div>
						<div class="form-group">
							<label>Uang Muka:</label>
							<input type="text" id="dp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="dp" class="form-control" value="<?= $data['dp'] ?>">
							<small id="dp_error" style="color: red"></small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<button class="btn btn-danger" id="hitung">HITUNG</button>
						</div>
					</div>
					<div class="col-lg-12">
						<hr>
						<h2>Total Perhitungan</h2>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Hutang Pokok:</label>
							<input type="text" id="hutang_pokok" disabled="" class="form-control">
						</div>
						<div class="form-group">
							<label>Total Bunga:</label>
							<input type="text" id="total_bunga" disabled="" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Harga Total Paket Kredit:</label>
							<input type="text" id="total_paket_kredit" readonly="" name="total_paket_kredit" class="form-control">
						</div>
						<div class="form-group">
							<label>Cicilan Perbulan: </label>
							<input type="text" id="cicilan_perbulan" readonly="" name="cicilan_perbulan" class="form-control">
						</div>

						<input type="submit" id="btnUpdate" class="btn btn-success btn-lg btn-block" value="UPDATE">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		$('#btnUpdate').hide();
		$('#harga_mobil').mask('000.000.000.000', {reverse: true});
		$('#dp').mask('000.000.000.000', {reverse: true});


		$('#formTambah').validate({
			rules: {
				nama_mobil: 'required',
				harga_mobil: 'required',
				bunga: 'required',
				dp: 'required'
			},
			messages: {
				nama_mobil: 'Nama mobil tidak boleh kosong',
				harga_mobil: 'Harga mobil tidak boleh kosong',
				bunga: 'Bunga tidak boleh kosong',
				dp: 'Uang muka tidak boleh kosong'
			},
			errorElement : 'em',
		})
	})

	function convertToRupiah(angka)
	{
		var rupiah = '';		
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
	}

	$('#hitung').on('click', (e) => {
		e.preventDefault();

		$('#hitung').html('HITUNG ULANG');
		$('#btnUpdate').show();

		var harga_mobil = $('#harga_mobil').val().replace('.', '').replace('.', '');
		var dp 			= $('#dp').val().replace('.', '').replace('.', '');
		var bunga 		= $('#bunga').val();
		var cicilan 	= $('#cicilan').val();

		var persen = (parseInt(harga_mobil) * 20) / 100;
		if(dp < persen){

			$('#dp_error').html('input uang muka minimal 20% dari harga mobil');
			setTimeout(function() { $('#dp_error').html('') }, 3000);
		}

		var hutang_pokok = parseInt(harga_mobil) - parseInt(dp);
		var total_bunga  = hutang_pokok * bunga * (cicilan / 12) / 100;

		console.log('totla bunga: ' + total_bunga);
		console.log('hutang pokok:' + hutang_pokok);

		var total_paket_kredit = hutang_pokok +  total_bunga;
		var cicilan_perbulan   = total_paket_kredit / (cicilan);
		
		total_paket_kredit 	= Math.floor(total_paket_kredit);
		cicilan_perbulan 	= Math.floor(cicilan_perbulan);

		console.log(cicilan / 12);

		$('#total_paket_kredit').val(convertToRupiah(total_paket_kredit));
		$('#cicilan_perbulan').val(convertToRupiah(cicilan_perbulan));
		$('#hutang_pokok').val(convertToRupiah(hutang_pokok));
		$('#total_bunga').val(convertToRupiah(total_bunga));

	})
</script>