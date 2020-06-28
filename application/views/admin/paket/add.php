<?php 
	$no = '';
	if($id == null){
		$no = '1';
	}else{
		$no = $id['id'] + 1;
	}
?>
<div class="row" style="margin-bottom: 20px">
	<div class="col-lg-12">
		<div class="panel panel-container">
			<div class="panel-body">
				<form method="post" id="formTambah" action="<?= base_url('admin/post_add_paket') ?>">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Kode Paket:</label>
							<input type="text" id="kode_paket" name="kode_paket" readonly="" class="form-control" value="Pkt-<?= $no ?>">
						</div>
						<div class="form-group">
							<label>Nama Mobil:</label>
							<input type="text" id="nama_mobil" name="nama_mobil" class="form-control">
						</div>
						<div class="form-group">
							<label>Harga Mobile:</label>
							<input type="text" id="harga_mobil" name="harga_mobil" class="form-control">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Jumlah Cicilan/bulan:</label>
							<select name="cicilan" id="cicilan" class="form-control"  style="width: 20%">
								<option value="12">12</option>
								<option value="24">24</option>
								<option value="36">36</option>
								<option value="48">48</option>
							</select>
						</div>

						<div class="form-group">
							<label>Bunga Hutang Pokok:</label>
							<input type="text" maxlength="3" id="bunga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="bunga" class="form-control"  style="width: 15%">
						</div>
						<div class="form-group">
							<label>Uang Muka:</label>
							<input type="text" id="dp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="dp" class="form-control">
							<small id="dp_error" style="color: red"></small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<button class="btn btn-danger" id="hitung">HITUNG</button>
						</div>
					</div>
					<div id="hitungcicilan">
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

							<input type="submit" class="btn btn-info btn-block" id="simpan" value="SIMPAN">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#simpan').hide();
	$(document).ready(function(){
		
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
		$('#simpan').show();

		var harga_mobil = $('#harga_mobil').val().replace('.', '').replace('.', '');
		var dp 			= $('#dp').val().replace('.', '').replace('.', '');
		var bunga 		= $('#bunga').val();
		var cicilan 	= $('#cicilan').val();

		var persen = (parseInt(harga_mobil) * 20) / 100;
		if(dp < persen){

			$('#dp_error').html('input uang muka minimal 20% dari harga mobil');
			setTimeout(function() { $('#dp_error').html('') }, 3000);
			$('#hitungcicilan').hide();
		}
		else{
			$('#hitungcicilan').show();	
		}

		console.log('persen' + persen);

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