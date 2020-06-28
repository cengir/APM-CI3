<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<table class="table table-bordered table-hover" id="MyTable">
				<thead>
					<tr>
						<th style="text-align: center;">No</th>
						<th style="text-align: center;">Nama Rekening</th>
						<th style="text-align: center;">No. Rekening</th>
						<th style="text-align: center;">Jumlah Bayar</th>
						<th style="text-align: center;">Denda</th>
						<th style="text-align: center;">Tgl. Bayar</th>
						<th style="text-align: center;">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($pembayaran as $key): ?>
						<tr>
							<td style="text-align: center;"><?php echo $no++ ?></td>
							<td style="text-align: left;"><?php echo $key['nama_rekening'] ?></td>
							<td style="text-align: left;"><?php echo $key['no_rekening'] ?></td>
							<td style="text-align: right;"><?php echo rp($key['jumlah_bayar']) ?></td>
							<td style="text-align: center;"><?php echo $key['denda'] ?> Hari</td>
							<td style="text-align: center;"><?php echo tgl($key['tgl_bayar']) ?></td>
							<td style="text-align: center;">
								<?php 
									if ($key['status'] === '0') {
										echo "<span class='badge' style='background-color:yellow;color:#333'>Pending</span>";
									}else if($key['status'] === '1'){
										echo "<span class='badge' style='background-color:green'>Sukses</span>";
									}else{
										echo "<span class='badge' style='background-color:red'>Gagal</span>";
									}
								?>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>