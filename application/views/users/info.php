<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<table class="table">
				<tr>
					<td>No Kontrak</td>
					<td>: <?= $user['no_kontrak'] ?></td>
				</tr>
				<tr>
					<td>No KTP</td>
					<td>: <?= $user['no_ktp'] ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>: <?= $user['nama'] ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>: <?= $user['alamat'] ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>: <?= $user['email'] ?></td>
				</tr>
				<tr>
					<td>Tgl. Tempo</td>
					<td>: <?= $user['tgl_tempo'] ?></td>
				</tr>
				<tr>
					<td>Nama Mobil</td>
					<td>: <?= $user['nama_mobil'] ?></td>
				</tr>
				<tr>
					<td>Total Kredit</td>
					<td>: <?= rp($user['total_paket_kredit']) ?></td>
				</tr>
				<tr>
					<td>Jumlah cicilan</td>
					<td>: <?= $user['cicilan'] ?></td>
				</tr>
				<tr>
					<td>Sisa Cicilan</td>
					<td>: <?= $user['cicilan'] - $sisa ?></td>
				</tr>
				<?php 
					// $a = $user['cicilan'] - $sisa;
					// $b = $user['cicilan_perbulan'] * $a;
					$b = $user['cicilan_perbulan'];
				?>
				<tr>
					<td>Nilai Cicilan / bulan</td>
					<td>: <?= rp(round($b)); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>