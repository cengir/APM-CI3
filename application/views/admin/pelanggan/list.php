<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<div class="table-responsive">
				<table class="table table-border table-hover" id="MyTable">
					<thead>
						<tr style="text-align: center;">
							<th>No</th>
							<th>No. Kontrak</th>
							<th>No. KTP</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Email</th>
							<th>Tgl. Jatuh Tempo</th>
							<th>Kode Paket</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($data as $key): ?>
							<tr>
								<td style="text-align: center;"><?= $no++ ?></td>
								<td style="text-align: center;"><?= $key['no_kontrak'] ?></td>
								<td style="text-align: center;"><?= $key['no_ktp'] ?></td>
								<td style="text-align: center;"><?= $key['nama'] ?></td>
								<td style="text-align: center;"><?= $key['alamat'] ?></td>
								<td style="text-align: center;"><?= $key['email'] ?></td>
								<td style="text-align: center;"><?= tgl($key['tgl_tempo']) ?></td>
								<td style="text-align: center;">
									<a href="#" onclick="detailPaket('<?= $key['kode_paket'] ?>', '<?= $key['nama_mobil'] ?>', '<?= rp($key['harga_mobil']) ?>', '<?= $key['cicilan'] ?>', '<?= $key['bunga'] ?>', '<?= rp($key['dp']) ?>', '<?= rp($key['total_paket_kredit']) ?>', '<?= rp($key['cicilan_perbulan']) ?>')" class="badge badge-primary"><?= $key['kode_paket'] ?></a>
								</td>
								
								<td style="text-align: center;">
									<button onclick="loadDataModal(<?= $key['no_kontrak'] ?>)" class="btn btn-sm btn-xm btn-info">
										<i class="fa fa-info"></i> 
									</button>
									<button onclick="sendEmail(<?= $key['no_kontrak'] ?>)" class="btn btn-sm btn-xm btn-success">
										<i class="fa fa-send"></i> 
									</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalPaket">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Paket</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="col-lg-6">
      		<div class="form-group">
	      		<label>Kode Paket: </label>
	      		<input type="text" disabled="" class="form-control" id="kode_paket">
	      	</div>
	      	<div class="form-group">
	      		<label>Nama Mobil:</label>
	      		<input type="text" disabled="" class="form-control" id="nama_mobil">
	      	</div>
	      	<div class="form-group">
	      		<label>Harga Mobil:</label>
	      		<input type="text" disabled="" class="form-control" id="harga_mobil">
	      	</div>
	      	<div class="form-group">
	      		<label>Cicilan:</label>
	      		<input type="text" disabled="" class="form-control" id="cicilan">
	      	</div>
      	</div>
      	<div class="col-lg-6">
      		<div class="form-group">
	      		<label>Bunga:</label>
	      		<input type="text" disabled="" class="form-control" id="bunga">
	      	</div>
	      	<div class="form-group">
	      		<label>Uang Muka:</label>
	      		<input type="text" disabled="" class="form-control" id="dp">
	      	</div>
	      	<div class="form-group">
	      		<label>Total Paket Kredit</label>
	      		<input type="text" disabled="" class="form-control" id="total_paket_kredit">
	      	</div>
	      	<div class="form-group">
	      		<label>Cicilan Perbulan:</label>
	      		<input type="text" disabled="" class="form-control" id="cicilan_perbulan">
	      	</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalCicilan">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Info Cicilan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<table class="table table-border table-hover" id="MyTable2">
      		<thead>
      			<tr>
      				<th>Cicilan Ke</th>
      				<th>Tgl. Bayar</th>
      				<th>Harga Sisa Cicilan</th>
      				<th>Total Bayar</th>
      				<th>Status Bayar</th>
      			</tr>
      		</thead>
      		<tbody id="tableCicilan">
      			
      		</tbody>
      	</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="sendEmail">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<form method="post" action="<?php echo base_url('admin/post_send_notif') ?>">
	      <div class="modal-header">
	        <h4 class="modal-title">Kirim Notifikasi</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<textarea id="editor1" name="editor1"></textarea>
		      	<input type="hidden" name="no_kontrak" id="hidden_no_kontrak">
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
	function detailPaket(a, b, c, d, e, f, g, h){
		$('#modalPaket').modal('show');

		$('#kode_paket').val(a);
		$('#nama_mobil').val(b);
		$('#harga_mobil').val(c);
		$('#cicilan').val(d + '/bln');
		$('#bunga').val(e + '%');
		$('#dp').val(f);
		$('#total_paket_kredit').val(g);
		$('#cicilan_perbulan').val(h);
	}


	function loadDataModal(no_kontrak){
		$.ajax({
			url: '<?= base_url("admin/load_data_cicilan/") ?>' + no_kontrak,
			method: 'GET',
			dataType: 'JSON',
			success:(data) => {
				console.log(data);
				$('#modalCicilan').modal('show');

				var page = '';
				data.forEach((datas, index) => {
					
					page += '<tr>';

					var total = datas.harga_sisa_cicilan;

					page += `<td style="text-align:center">${index + 1}</td>`;
					page += `<td style="text-align:center">${datas.tgl_bayar === '0000-00-00' ? '-' : datas.tgl_bayar}</td>`;
					page += `<td style="text-align:center">${formatRupiah(total, 'Rp. ')}</td>`;
					page += `<td style="text-align:center">${formatRupiah(datas.total_bayar, 'Rp. ')}</td>`;
					page += `<td style="text-align:center">${datas.status_bayar === '0' ? '<span class="badge" style="background-color:red">Belum Bayar</span>' : '<span class="badge" style="background-color:#03fc49">Sudah Bayar</span>'}</td>`;

					page += '</tr>';
				})
				$('#tableCicilan').html(page);
			}
		})
	}

	function sendEmail(no_kontrak) {

		$.ajax({
			url: '<?php echo base_url("admin/send_notif/") ?>' + no_kontrak,
			method: 'GET',
			dataType: 'JSON',
			success: (data) => {
				var text = `
					<b>Kepada ${data.nama}</b> <br>
					${data.alamat} <br><br>
					Dengan Hormat, <br>
					Dengan surat ini kami memberitahukan bahwa pembayaran yang belum Anda bayar dengan nomer faktur <b>${data.no_kontrak}</b> sudah lewat jatuh tempo.  untuk pembayaran Kredit Mobil jatuh tempo pada tanggal <b>${data.tgl_tempo}</b>. Kami mohon Anda segera membayar dengan jumlah <b>${formatRupiah(data.cicilan_perbulan, 'Rp ')}</b>. 
					Hubungi kami jika Anda memiliki pertanyaan terkait dengan pembayarannya. Jika pembayaran telah dilakukan, mohon abaikan surat ini terima kasih.
					Hormat kami, <br><br>
					<b>Oki</b><br>
					Manajer Jogja Mobilindo Finance.

				`;
				$('#editor1').val(text);
				$('#hidden_no_kontrak').val(no_kontrak);
				$('#sendEmail').modal('show');
				CKEDITOR.replace( 'editor1' );
			}
		})
	}
</script>
