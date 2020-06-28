<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<h2>Info Cicilan</h2>
			<hr>
			<table class="table table-bordered table-hover" id="MyTable">
				<thead>
					<tr>
						<th style="text-align: center;">No</th>
						<th style="text-align: center;">Tgl. Bayar</th>
						<th style="text-align: center;">Harga Sisa Cicilan</th>
						<th style="text-align: center;">Total Bayar</th>
						<th style="text-align: center;">Status Bayar</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($cicilan as $key): ?>
						<tr>
							<td style="text-align: center;"><?= $no++ ?></td>
							<td style="text-align: center;"><?= tgl($key['tgl_bayar']); ?></td>
							<td style="text-align: right;"><?= rp($key['harga_sisa_cicilan']); ?></td>
							<td style="text-align: right;"><?= rp($key['total_bayar']); ?></td>
							<td style="text-align: center;">
								<?php
									if($key['status_bayar'] === '0'){
										echo "<span class='badge' style='background-color:red'>Belum Bayar</span>";
									}else if($key['status_bayar'] === '1'){

										echo "<span class='badge' style='background-color:green'>Sudah Bayar</span>";
									}else{

										echo "<span class='badge' style='background-color:red'>Pembayaran Gagal</span>";
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
