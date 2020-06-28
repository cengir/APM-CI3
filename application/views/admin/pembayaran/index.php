<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<div class="table-responsive">
				<table class="table table-border table-hover" id="MyTable">
					<thead style="background-color: #333; color: #fff">
						<tr>
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">No. Kontrak</th>
							<th style="text-align: center;">No. KTP</th>
							<th style="text-align: center;">Nama</th>
							<th style="text-align: center;">Status</th>
							<th style="text-align: center;">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($data as $key): ?>
							<tr>
								<td style="text-align: center;"><?= $no++ ?></td>
								<td style="text-align: center;"><?= $key['no_kontrak'] ?></td>
								<td style="text-align: center;"><?= $key['no_ktp'] ?></td>
								<td style="text-align: center;"><?= $key['nama'] ?></td>
								<td style="text-align: center;">
									<?php 
										if($key['status'] == 0){
											echo '<span class="badge" style="background-color:red">Belum Konfirmasi</span>';
										}else{
											echo '<span class="badge" style="background-color:#11f74f">Telah TerKonfirmasi</span>';
										}
									?>
								</td>
								
								<td style="text-align: center;">
									<a href="<?php echo base_url('admin/detail_pembayaran/'.$key['pembayaran_id']) ?>" class="btn btn-sm btn-xm btn-info">
										<i class="fa fa-info"></i> Detail 
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