<div class="row">
	<div class="col-md-12">	
        <form id="request_form" action="{{ $model->exists ? route('update_user', $model->id) : route('simpan_user') }}" method="POST">
            @csrf
			<input type="hidden" id="idUser" name="idUser" value="{{ $model->exists? $model->id : '0'}}">		
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="nama" class="control-label">Nama</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" value="{{ $model->name }}">
				</div>
			</div>
			<div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="email" class="control-label">Email</label>
				</div>
				<div class="col-md-8">
					<input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $model->email }}">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label for="password" class="control-label">Password</label>
				</div>
				<div class="col-md-8">
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" value="">
				</div>
			</div>
			<div class="form-group row mb-2">
                <div class="col-md-4">
                    <label for="role" class="control-label">Role</label>
                </div>
                <div class="col-md-8">
                    <select id="role" name="role" class="form-control select2bs4">
                        <option value=""></option>
                        <option value="1" @if($model->role_id == 1) selected @endif>Super Admin</option>
                        <option value="2" @if($model->role_id == 2) selected @endif>Admin</option>
                        <option value="3" @if($model->role_id == 3) selected @endif>User</option>
                    </select>
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
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        allowClear: true,
        // width: 'resolve',
        placeholder: 'Pilih...',
    });

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
                    $('#data-user').DataTable().ajax.reload(); // Reload DataTable
                });
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.error, function(key, value) {
                        $('#' + key).closest('.form-control').addClass('is-invalid');
                    });
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
        title: 'Apakah anda yakin ingin menghapus data User ini ?',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value)
        {
            $.ajax({
                url:"{{ route('hapus_user') }}",
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
                        $('#data-user').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    console.log('Gagal Hapus Data User: ', xhr);
                }
            });
        }
    });
}
</script>