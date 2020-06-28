<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<div class="form-group">
				<label>Nama Rekening</label>
				<input type="text" disabled="" value="<?= $data['nama_rekening'] ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>No. Rekening</label>
				<input type="text" disabled="" value="<?= $data['no_rekening'] ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah Bayar</label>
				<input type="text" disabled="" value="<?= rp($data['jumlah_bayar']) ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Foto Resi</label> <br>
				<img src="<?= base_url('foto_resi/'.$data['foto_resi']) ?>" style="width: 350px; height: 300px">
			</div>
			<?php 
				if ($data['status'] === '0') {
					?>
						<div class="form-group">
							<a class="btn btn-danger" onclick="tolakModal('<?= $data['no_kontrak'] ?>')">TOLAK</a>
							<a href="<?= base_url('admin/confirm_pembayaran/' . $data['pembayaran_id']) ?>" class="btn btn-success">SETUJU</a>
						</div>
					<?php
				}else{
					?>
						<div class="form-group">
							<a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-primary">KEMBALI</a>
						</div>
					<?php
				}
			?>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalTolak">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<form method="post" action="<?php echo base_url('admin/post_tolak_pembayaran') ?>">
	      <div class="modal-header">
	        <h4 class="modal-title">Tolak Pembayaran</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<textarea id="editor1" name="editor1"></textarea>
		      	<input type="hidden" name="pembayaran_id" value="<?= $data['pembayaran_id'] ?>">
		      	<input type="hidden" name="email_user" id="email_user">
	      </div>
	      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary" >Kirim</button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<script>
	function tolakModal(no_kontrak) {

		$.ajax({
			url: '<?php echo base_url("admin/get_user/") ?>' + no_kontrak,
			method: 'GET',
			dataType: 'JSON',
			success: (data) => {
				var text = `
					<b>Kepada Yth. ${data.nama}</b> <br><br>
					Pembayaran kredit mobil dengan nomer kontrak ${no_kontrak} di tolak . Dengan alasan __________________. Harap Mengirim data yang valid berdasarkan jumlah tagihan anda . Demikian pemberitahuan yang kami sampaikan,Terima kasih atas kerja samanya.<br><br>
					Oki <br>
					Manager Jogja Mobilindo Finance

				`;
				$('#editor1').val(text);
				$('#email_user').val(data.email);
				$('#modalTolak').modal('show');
				console.log(data);
				CKEDITOR.replace( 'editor1' );
			}
		})
	}
</script>