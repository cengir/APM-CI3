		
	</div>	<!--/.main-->
	<script src="<?= base_url('assets/mask.js') ?>"></script>
	<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
	<script src="<?= base_url('assets/') ?>js/chart.min.js"></script>
	<script src="<?= base_url('assets/') ?>js/chart-data.js"></script>
	<script src="<?= base_url('assets/') ?>js/easypiechart.js"></script>
	<script src="<?= base_url('assets/') ?>js/easypiechart-data.js"></script>
	<script src="<?= base_url('assets/') ?>js/bootstrap-datepicker.js"></script>
	<script src="<?= base_url('assets/') ?>js/custom.js"></script>


	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

	<script>

		$('#MyTable').DataTable({
			dom: 'Bfrtip',
	        buttons: [
	            { extend: 'pdf', className: 'btn btn-danger', text: 'Export To PDF' },
	            { extend: 'excel', className: 'btn buttons', text: 'Export To Excel' },
	        ]
		});
		$('#MyTable2').DataTable({
			dom: 'Bfrtip',
	        buttons: [
	            { extend: 'pdf', className: 'btn btn-danger', text: 'Export To PDF' },
	            { extend: 'excel', className: 'btn buttons', text: 'Export To Excel' },
	        ]
		});

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
		
		<?php 
			if ($this->session->flashdata('msg')) {
				echo "swal('".$this->session->flashdata('title')."', '".$this->session->flashdata('msg')."', '".($this->session->flashdata('error') ? 'error' : 'success')."')";
			}
		?>
		
		window.onload = function () {
			var chart1 = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(chart1).Line(lineChartData, {
				responsive: true,
				scaleLineColor: "rgba(0,0,0,.2)",
				scaleGridLineColor: "rgba(0,0,0,.05)",
				scaleFontColor: "#c5c7cc"
			});
		};
	</script>
		
</body>
</html>