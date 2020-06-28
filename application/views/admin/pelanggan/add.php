<?php 
	$no = '';
	if($id == null){
		$no = date('Ymd'). '1';
	}else{
		$no = date('Ymd').($id['id']+1);
	}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-container">
			<div class="panel-body">
				<form method="post" id="formTambah" action="<?= base_url('admin/post_add_pelanggan') ?>">
					<div class="col-lg-6">
						<div class="form-group">
							<label>No. Kontrak:</label>
							<input type="text" name="no_kontrak" disabled="" id="no_kontrak" class="form-control" value="<?= $no; ?>">
						</div>
						<div class="form-group">
							<label>No. KTP:</label>
							<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="16" name="no_ktp" id="no_ktp" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Nama Lengkap:</label>
							<input type="text" name="nama" id="nama" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Alamat: </label>
							<textarea name="alamat" id="alamat" class="form-control"></textarea>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Email: </label>
							<input type="email" name="email" id="email" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Pilih Paket:</label>
							<button class="btn btn-primary btn-block" onclick="searchPaket()">pilih paket</button>
							<input type="hidden" id="paket_id" name="paket_id"><br>
							<input type="text" readonly="" id="kode_paket" class="form-control" value="KODE PAKET">
						</div>
						<div class="form-group">
							<label>Tanggal Jatuh Tempo: </label>
							<input type="date" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-control" value="">
						</div>
						<div class="form-group">
							<button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Tambah</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="pilihPaket">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Pilih Paket</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<table class="table table-bordered table-hover">
	      		<thead>
	      			<tr>
	      				<th>Pilih</th>
	      				<th>Kode Paket</th>
	      				<th>Nama Mobil</th>
	      				<th>Harga Mobil</th>
	      				<th>Cicilan</th>
	      				<th>Bunga</th>
	      				<th>DP</th>
	      				<th>Cicialan / bulan</th>
	      			</tr>
	      		</thead>
	      		<tbody>
	      			<?php foreach ($paket as $key): ?>
	      				<tr>
	      					<td>
	      						<button class="btn btn-sm btn-success" onclick="pilih('<?= $key['id'] ?>', '<?= $key['kode_paket'] ?>')"><i class="fa fa-plus"></i></button>
	      					</td>
	      					<td><?= $key['kode_paket'] ?></td>
	      					<td><?= $key['nama_mobil'] ?></td>
	      					<td><?= rp($key['harga_mobil']) ?></td>
	      					<td><?= $key['cicilan']."/bln" ?></td>
	      					<td><?= $key['bunga']."%" ?></td>
	      					<td><?= rp($key['dp']) ?></td>
	      					<td><?= rp($key['cicilan_perbulan']) ?></td>
	      				</tr>
	      			<?php endforeach ?>
	      		</tbody>
	      	</table>
	      </div>
	      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
    </div>
  </div>
</div>

<script>

	function searchPaket() {
		$('#pilihPaket').modal('show');
	}

	function pilih(id, kode_paket) {

		console.log(id);
		$('#kode_paket').val(kode_paket);
		$('#paket_id').val(id);
		$('#pilihPaket').modal('close');
	}

	$(document).ready(function(){
		<?php 
			if ($this->session->flashdata('msg')) {
				echo "swal('".$this->session->flashdata('title')."', '".$this->session->flashdata('msg')."', '".($this->session->flashdata('error') ? 'error' : 'success')."')";
			}
		?>


		$('#formTambah').validate({
			rules: {
				no_ktp: {
					minlength: 16,
					required: true,
					number: true
				},
				nama: 'required',
				alamat: 'required',
				email: {
					required: true,
					email: true,
				},
				paket: 'required',
				tgl_jatuh_tempo: 'required'
			},
			messages: {
				no_ktp: {
					minlength: 'No.KTP harus 16 digit angka',
					required: 'No.KTP tidak boleh Kosong'
				},
				nama: 'Nama tidak boleh kosong',
				alamat: 'Alamat tidak boleh kosong',
				email: {
					required: 'Email tidak boleh kosong',
					email: 'Format harus E-mail'
				},
				paket: 'Nama tidak boleh Kosong',
				tgl_jatuh_tempo: 'Tanggal Jatuh tempo tidak boleh Kosong'
			},
			errorElement : 'em',
		})
	})
</script>