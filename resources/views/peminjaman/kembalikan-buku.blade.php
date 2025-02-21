<form id="request_form" action="{{ route('kembalikan_buku') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="idPinjaman" name="idPinjaman" value="{{ $dataPinjaman->id }}">
            <div class="form-group row mb-2">
                <div class="col">
                    <input id="transfer" name="transfer" class="form-control" type="text" value="Sudah Transfer" 
                    style="border: none; background: transparent; padding: 0; cursor: default;" hidden>
                    <p class="text-center">Apakah anda ingin mengembalikan Buku?</p>
                </div>
            </div>            
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="submit_btn">Ya !!!</button>
    </div>
</form>
<script>
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
                        $('#data-buku').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    if (xhr.status === 400 && res.message) {
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
</script>