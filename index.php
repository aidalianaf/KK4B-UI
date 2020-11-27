<?php 
	//koneksi database
	$server = "localhost";
	$user = "id15521901_aidalianaf";
	$pass = "qG7{?2lP_1s_IO<_";
	$database = "id15521901_datasiswaaida";

	global $koneksi;
	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));


	//jika tombol save di klik
	if (isset($_POST['bsave'])) 
	{
		//pengujian data akan diedit atau disimpan
		if($_GET['hal'] == "edit")
		{
			//data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
												nim = '$_POST[tnim]',
												nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
												prodi = '$_POST[tprodi]'
											WHERE id_mhs = '$_GET[id]'
											 ");
			if($edit)
			{
				echo "<script>
						alert('Edit Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Edit Data Failed');
						document.location='index.php'
					 </script>";
			}
		}
		else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
											  VALUES ('$_POST[tnim]', 
											  		 '$_POST[tnama]', 
											  		 '$_POST[talamat]', 
											  		 '$_POST[tprodi]')
											 ");
			if($simpan)
			{
				echo "<script>
						alert('Save Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Save Data Failed');
						document.location='index.php'
					 </script>";
			}
		}
		
	}

	//pengujian jika tombol edit atau delete di klik
	if(isset($_GET['hal']))
	{
		//pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan ditampung ke variable
				$vnim = $data['nim'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];				
				$vprodi = $data['prodi'];
			}
		}
		else if($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Delete Data Success');
						document.location='index.php'
					 </script>";
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD DATA AIDA</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">

	<font color="black" style="font-family: Monserrat">
		<h1 class="text-center">Daftar Nama Siswa SMK TELKOM 2020/2021</h1>
		<h2 class="text-center">Aida Liana (XI RPL 5)</h2>
	</font>

	<!-- AWAL CARD FORM -->
	<div class="card mt-5">
	  <div class="card-header bg-success text-white">
	    Data Siswa
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<lable>ID Murid</lable>
	    		<input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Masukkan ID number" required="">
	    	</div>
	    	<div class="form-group">
	    		<lable>Nama Murid</lable>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama" required="">
	    	</div>
	    	<div class="form-group">
	    		<lable>Alamat Murid</lable>
	    		<textarea class="form-control" name="talamat"  placeholder="Masukkan Alamat"><?=@$valamat?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<lable>Jurusan Murid</lable>
	    		<select class="form-control" name="tprodi">
	    			<option value="<?=@$vprodi?>"><?=@$vprodi?></option>
	    			<option value="TKJ">TKJ (TEKNIK KOMPUTER JARINGAN)</option>
	    			<option value="TJA">TJA (TEKNIK JARINGAN AKSES)</option>
	    			<option value="MULTIMEDIA">MULTIMEDIA</option>
	    			<option value="RPL">RPL (REKAYASA PERANGKAT LUNAK)</option>
	    			<option value="TEKNIK MESIN">TEKNIK MESIN</option>
	    			<option value="ELETRO">ELETRO</option>
	    			<option value="GAMING">GAMING</option>
	    			<option value="KEDOKTERAN">KEDOKTERAN</option>
	    			<option value=">TKJ">TKJ (TEKNIK KOMPUTER JARINGAN)</option>
	    			<option value="TKRO (TEKNIK KENDARAAN RINGAN OTOMOTIF)">TKRO (TEKNIK KENDARAAN RINGAN OTOMOTIF)</option>
	    		</select>
	    	</div>

			<button type="submit" class="btn btn-warning text-white" name="bsave">Kirim</button>
			<button type="reset" class="btn btn-success" name="breset">Set Ulang Form</button>

	    </form>
	  </div>
	</div>
	<!-- AKHIR CARD FORM -->

		<!-- AWAL CARD TABEL -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white font-18pt">
	    List Nama Murid
	  </div>
	  <div class="card-body">
	   
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No</th>
	  			<th>ID MURID</th>
	  			<th>Nama Murid</th>
	  			<th>Alamat Murid</th>
	  			<th>Jurusan Murid</th>
	  			<th>Perintah</th>
	  		</tr>
	  		<?php
	  			$no = 1; 
	  			$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
	  			while ($data = mysqli_fetch_array($tampil)) :
	  		 ?>
	  		<tr>
	  			<td><?=$no++;?></td>
	  			<td><?=$data['nim'];?></td>
	  			<td><?=$data['nama'];?></td>
	  			<td><?=$data['alamat'];?></td>
	  			<td><?=$data['prodi'];?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-success">Edit</a>
	  				<a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?') " class="btn btn-warning">Hapus</a>
	  			</td>

	  		</tr>
	  	<?php endwhile; //penutup perulangan while?>
	  	</table>

	  </div>
	</div>
	<!-- AKHIR CARD TABEL -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>



	<script type="text/javascript">
		$(document).ready(function(){
			$(".bg-loader").hide();
		})
	</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>