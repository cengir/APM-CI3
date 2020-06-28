<?php 
	

	$tgl1 = $users['tgl_tempo'];
	
	
	$sisa = $users['cicilan'] - $total_cicilan + 1;

	date_default_timezone_set('Asia/Jakarta');

	$now = date('Y-m-d');
	$denda = 0;
	$selisih = strtotime($tgl1) -  strtotime($now);
	$hari = $selisih/(60*60*24);

	if($hari < 0 ){
		$a = ($users['cicilan_perbulan'] * 0.3) / 100;
		$denda = round($a *  abs($hari));
	}

	
?>
<div class="row">
	<div class="col-lg-12">
		<?php if ($bayar > 0): ?>
			<div class="alert alert-danger">
				Pembayaran Menunggu Proses Konfirmasi Admin, Silahkan selalu Cek E-mail anda.
			</div>
		<?php endif ?>
		<div class="panel panel-body" style="margin-bottom: 50px">
			<form enctype="multipart/form-data" method="post" id="formBayar" action="<?= base_url("users/post_bayar_cicilan") ?>">
				<div class="col-lg-6">
					<div class="form-group">
						<label>No. Kontrak: </label>
						<input type="text" readonly="" name="no_kontrak" class="form-control" value="<?= $users['no_kontrak'] ?>">
					</div>
					<div class="form-group">
						<label>Tgl. Bayar:</label>
						<input type="text" readonly="" class="form-control" value="<?= tgl(date('Y-m-d')) ?>">
						<input type="hidden" name="tgl_bayar" value="<?php echo date('Y-m-d') ?>">
					</div>
					<div class="form-group">
						<label>Tgl. Jatuh Tempo:</label>
						<input type="text" readonly="" class="form-control" value="<?= tgl($tgl1) ?>">
						<input type="hidden" value="<?php echo $tgl1 ?>" name="tgl_jatuh_tempo">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Cicilan Ke:</label>
							<input type="text" readonly="" name="no_kontrak" class="form-control" value="<?= $total_cicilan===0 ? 1 : $total_cicilan ?>">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Sisa Cicilan:</label>
							<input type="text" readonly="" name="sisa" class="form-control" value="<?= $sisa ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Hari - Jt. Tempo</label>
							<input type="text" readonly="" name="denda" class="form-control" value="<?php echo abs($hari) ?>">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Denda Cicilan</label>
							<input type="text" readonly="" class="form-control" value="<?= rp($denda) ?>">
							<!-- <input type="hidden" name="denda" value="<?php echo $denda; ?>"> -->
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Cicilan / bln</label>
							<input type="text" readonly="" class="form-control" value="<?= rp($users['cicilan_perbulan']) ?>">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Total Bayar:</label>
							<input type="text" readonly="" class="form-control" value="<?php echo rp(round($users['cicilan_perbulan']) + $denda) ?>">
						</div>
					</div>
					<div class="form-group">
						<?php if ($bayar < 1): ?>
							<center>
								<label>.</label>
								<button id="lanjut" class="btn btn-primary btn-block btn-lg" style="width: 90%;">LANJUT PEMBAYARAN</button>
							</center>
						<?php endif ?>
					</div>
				</div>
				<div class="col-lg-12" style="background-color: #ababab; padding: 5px; border-radius: 10px; color: white">
					<h4 style="color: white">Rumus Denda: </h4>

					* Total cicilan Perbulan * 0,3 / 100  <br>
					* Rp. (nilai Denda Cicilan) * hari lewat jatuh tempo
				</div>
				
				<div id="lanjutan">
					<div class="col-lg-12">
						
						<h3>LANJUT PEMBAYARAN</h3>
						<hr>					
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Nama Rekening:</label>
							<input type="text" name="nama_rekening" class="form-control" id="nama_rekening">
						</div>
						<div class="form-group">
							<label>No. Rekening:</label>
							<input type="text" maxlength="16" name="no_rekening" class="form-control" id="no_rekening">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Jumlah Bayar: </label>
							<input type="text" name="jumlah_bayar" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" id="jumlah_bayar">
						</div>
						<div class="form-group">
							<label>Foto Resi:</label>
							<input type="file" name="foto_resi" class="form-control" id="foto_resi">
						</div>
					</div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success btn-block btn-lg">
							KIRIM PEMBAYARAN
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('#lanjutan').hide();
	$('#lanjut').on('click', (e) => {
		e.preventDefault();

		$('#lanjutan').fadeIn();
	});

	$(document).ready(function(){
		$('#jumlah_bayar').mask('000.000.000.000', {reverse: true});
		$('#formBayar').validate({
			rules: {
				nama_rekening: "required",
				no_rekening: "required",
				jumlah_bayar: "required",
				foto_resi: "required",
			},
			messages: {
				nama_rekening: 'Nama Rekening tidak boleh kosong',
				no_rekening: "No Rekening tidak boleh kosong",
				jumlah_bayar: 'Jumlah Bayar tidak boleh kosong',
				foto_resi: "Foto resi tidak boleh kosong"
			},
			errorElement : 'em',
		})
	})
</script>