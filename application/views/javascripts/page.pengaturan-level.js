$(() => 
{


	// initialize responsive datatable
	$.initBasicTable('#dt_basic')
	const $table 	= $('#dt_basic').DataTable()
	$table.columns( 0 )
    .order( 'asc' )
    .draw()





	// Add Row
	const addRow = (data) => 
	{
		let row = [
			data.nama,
			data.keterangan,
			data.status,
			'<div>'
				+'<button class="btn btn-primary btn-sm" onclick="Ubah('+data.id+')"><i class="fa fa-edit"></i> Ubah</button>'
				+'<button class="btn btn-danger btn-sm" onclick="Hapus('+data.id+')"><i class="fa fa-trash"></i> Hapus</button>'
			+'</div>'
		]
		
		let $node = $($table.row.add(row).draw().node())
		$node.attr('data-id', data.id)
	}

	// Edit Row
	const editRow = (id, data) => 
	{
		let row = $table.row('[data-id='+id+']').index()

		$($table.row(row).node()).attr('data-id',id)
		$table.cell(row, 0).data(data.nama)
		$table.cell(row, 1).data(data.keterangan)
		$table.cell(row, 2).data(data.status)
	}

	// Delete Row
	const deleteRow = (id) =>
	{
		$table.row('[data-id='+id+']').remove().draw()
	}





	// Fungsi simpan 
	$('#form').submit((ev) => 
	{
		ev.preventDefault()

		let id 			= $('#id').val()
		let nama 		= $('#nama').val()
		let keterangan 	= $('#keterangan').val()
		let status 		= $('#status').val()

		if(id == 0) {

			// Insert
			
			window.apiClient.pengaturanLevel.insert(nama, keterangan, status)
			.done((data) => 
			{
				$.doneMessage('Berhasil ditambahkan.','Pengaturan Level')
				addRow(data)

			})
			.fail(($xhr) => 
			{
				$.failMessage('Gagal ditambahkan.','Pengaturan Level')
			}).
			always(() => 
			{
				$('#myModal').modal('toggle')
			})
		}
		else {
			
			// Update
			
			window.apiClient.pengaturanLevel.update(id, nama, keterangan, status)
			.done((data) => 
			{
				$.doneMessage('Berhasil diubah.','Pengaturan Level')
				editRow(id, data)
				
			})
			.fail(($xhr) => 
			{
				$.failMessage('Gagal diubah.','Pengaturan Level')
			}).
			always(() => 
			{
				$('#myModal').modal('toggle')
			})
		}
	})

	// Fungsi Delete
	$('#OkCheck').click(() => 
	{
		
		let id 			= $("#idCheck").val()
		
		window.apiClient.pengaturanLevel.delete(id)
		.done((data) => 
		{
			$.doneMessage('Berhasil dihapus.','Pengaturan Level')
			deleteRow(id)
			
		})
		.fail(($xhr) => 
		{
			$.failMessage('Gagal dihapus.','Pengaturan Level')
		}).
		always(() => 
		{
			$('#ModalCheck').modal('toggle')
		})
	})

	// Clik Tambah
	$('#tambah').on('click', () =>
	{
		$('#myModalLabel').html('Tambah Level')
		$('#id').val('')
		$('#nama').val('')
		$('#keterangan').val('')
		$('#status').val('')

		$('#myModal').modal('toggle')
	})

})

// Click Hapus
const Hapus = (id) =>
{
	$("#idCheck").val(id)
	$("#LabelCheck").text('Form Hapus')
	$("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
	$('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (id) =>
{
	window.apiClient.pengaturanLevel.detail(id)
	.done((data) =>
	{

		$('#myModalLabel').html('Ubah Level')
		$('#id').val(data.id)
		$('#nama').val(data.nama)
		$('#keterangan').val(data.keterangan)
		$('#status').val(data.status)

		$('#myModal').modal('toggle')
	})
	.fail(($xhr) => 
	{
		$.failMessage('Gagal mendapatkan data.','Pengaturan Level')
	})
}