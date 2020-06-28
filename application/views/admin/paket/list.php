<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<div class="table-responsive">
				<table class="table table-border table-hover" id="MyTable">
					<thead>
						<tr style="text-align: center;">
							<th>No</th>
							<th>Kode Pkt</th>
							<th>Nama Mobil</th>
							<th>Harga Mobil</th>
							<th>Cicilan</th>
							<th>Bunga</th>
							<th>DP</th>
							<th>Ttl. Pkt. Kredit</th>
							<th>Cicilan / bulan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($data as $key): ?>
							<tr>
								<td style="text-align: center;"><?= $no++ ?></td>
								<td style="text-align: center;"><?= $key['kode_paket'] ?></td>
								<td style="text-align: left;"><?= $key['nama_mobil'] ?></td>
								<td style="text-align: right;"><?= rp($key['harga_mobil']) ?></td>
								<td style="text-align: center;"><?= $key['cicilan'] ?></td>
								<td style="text-align: center;"><?= $key['bunga'] ?>%</td>
								<td style="text-align: right;"><?= rp($key['dp']) ?></td>
								<td style="text-align: right;"><?= rp($key['total_paket_kredit']) ?></td>
								<td style="text-align: right;"><?= rp($key['cicilan_perbulan']) ?></td>
								<td style="text-align: center;">
									<a href="<?= base_url('admin/edit_paket/' . $key['id']) ?>" class="btn btn-sm btn-xm btn-warning">
										<i class="fa fa-edit"></i>
									</a>
									<a onclick="return confirm('Apakah anda ingin menghapus ?')" href="<?= base_url('admin/delete_paket/' . $key['id']) ?>" class="btn btn-sm btn-xm btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>