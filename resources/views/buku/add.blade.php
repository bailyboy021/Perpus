<div class="row">
	<div class="col-md-12">	
        <form id="request_form" action="{{ $model->exists ? route('update_buku', $model->id) : route('simpan_buku') }}" method="POST">
            @csrf
			<input type="hidden" id="idBuku" name="idBuku" value="{{ $model->exists? $model->id : '0'}}">		
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="title" class="control-label">Judul</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="title" id="title" class="form-control" placeholder="Judul Buku" value="{{ $model->title }}">
				</div>
			</div>
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="author" class="control-label">Pengarang</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="author" id="author" class="form-control" placeholder="Pengarang Buku" value="{{ $model->author }}">
				</div>
			</div>
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="year" class="control-label">Tahun Terbit</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="year" id="year" class="form-control" placeholder="Tahun Terbit" value="{{ $model->year }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="4">
				</div>
			</div>
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="genre" class="control-label">Genre</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="genre" id="genre" class="form-control" placeholder="Genre" value="{{ $model->genre }}">
				</div>
			</div>
			<div class="form-group row mb-2">
                <div class="col-md-4">
                    <label for="synopsis" class="control-label">Sinopsis</label>
				</div>
				<div class="col-md-8">
                    <textarea name="synopsis" id="synopsis" class="form-control" rows="5">{{ $model->synopsis }}</textarea>
				</div>
			</div>
            <div class="form-group row mb-2">
                <div class="col-md-4">
                    <label for="cover" class="control-label">Cover</label>
                </div>
                <div class="col-md-8">
                    <input type="file" id="cover" name="cover" class="form-control" data-max-file-size="50M">
                </div>
            </div>
			<div class="text-right d-flex justify-content-end">
				@if($model->exists)                
                    <button type="submit" class="btn btn-primary btn-sm mr-2" id="updated_btn">SAVE</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="btn_delete({{ $model->id }});">DELETE</button>
                
                @else
					<button type="submit" class="btn btn-primary btn-sm" id="submit_btn">CREATE</button>
				@endif
			</div>
        </form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#request_form').on('submit', function(e) {
        e.preventDefault();

        let form = $('#request_form'),
            url = form.attr('action');

        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');

        $.ajax({
            url: url,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(returnData) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    timer: 2000,
                    allowOutsideClick: false
                }).then(function() {
                    $("#modal_add").modal('hide');
                    $('#data-buku').DataTable().ajax.reload(); // Reload DataTable
                });
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.error, function(key, value) {
                        $('#' + key).closest('.form-control').addClass('is-invalid');
                    });
                }

                if (xhr.status === 415 && res.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.message, // Menampilkan pesan error dari response
                    });
                } else {
                    console.log(res);
                }
            }
        });
    });
});

function btn_delete(id)
{
	let csrf_token = '{{ csrf_token() }}';
    Swal.fire({
        icon: 'warning',
        title: 'Apakah anda yakin ingin menghapus data Buku ini ?',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value)
        {
            $.ajax({
                url:"{{ route('hapus_buku') }}",
                data: {id:id, '_token' : csrf_token},
                method : 'delete',
                success: function(msg){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus.',
                        timer: 2000
                    }).then(function() {
                        $("#modal_add").modal('hide');
                        $('#data-buku').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    console.log('Gagal Hapus Data Buku: ', xhr);
                }
            });
        }
    });
}
</script>