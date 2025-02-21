<form id="request_form" action="{{ route('pinjam_buku') }}" method="POST">
    @csrf
    <input type="hidden" name="book_id" value="{{$dataBuku->id}}">
    <div class="row">
        <div class="col-4">
            <img src="{{ asset('images/cover/' . $dataBuku->cover) }}" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="{{$dataBuku->cover}}">                
        </div>
        <div class="col-8">
            <div class="d-flex flex-column mb-3">
                <div class=""><span class="font-weight-bold">Judul :</span> {{$dataBuku->title}}</div>
                <div class=""><span class="font-weight-bold">Pengarang :</span> {{$dataBuku->author}}</div>
                <div class=""><span class="font-weight-bold">Kategori :</span> {{$dataBuku->genre}}</div>
                <div class=""><span class="font-weight-bold">Tahun Terbit :</span> {{$dataBuku->year}}</div>
                <div class=""><span class="font-weight-bold">Status Buku :</span> 
                    @if($dataBuku->is_available == 1)
                        <span class="badge badge-success">Tersedia</span>
                    @else
                        <span class="badge badge-danger">Sedang Dipinjam</span>
                    @endif                
                </div>
                <div class=""><span class="font-weight-bold">Sinopsis :</span> 
                <br><p class="text-justify">{{$dataBuku->synopsis}}</p> 
                </div>
            </div>
            <div class="d-flex justify-content-end mb-3">
                @if($dataBuku->is_available == 1)
                    <button type="submit" class="btn btn-primary" id="submit_btn">Pinjam</button>
                @endif
            </div>
        </div>
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
                        $("#modal_large").modal('hide');
                        // location.reload();
                        window.location.href = "{{ route('perpus.daftar_peminjaman') }}";
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