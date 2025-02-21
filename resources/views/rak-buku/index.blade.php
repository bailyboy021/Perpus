@extends('app.main')
@section('content')


{{-- konten utama --}}
<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ route('perpus') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap justify-content-start">
            @foreach ($buku as $bk)
            <div class="card mx-2" style="width: 18rem;">
                <img src="{{ asset('images/cover/' . $bk->cover) }}" class="card-img-top img-fluid" style="height: 300px; object-fit: cover;" alt="{{$bk->cover}}">
                <div class="card-body">
                    <h5 class="card-title">{{$bk->title}}</h5>
                    <p class="card-text mt-5">{{$bk->author}} | {{$bk->year}}</p>
                    <a href="#" class="btn btn-primary btn-detail" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modal_add"
                        title="{{ $bk->title }}" 
                        bookId="{{ $bk->id }}">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach            
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center">  {{-- Container untuk memposisikan pagination --}}
    <ul class="pagination">  {{-- Gunakan class pagination dari AdminLTE --}}

        {{-- Tombol Previous --}}
        <li class="page-item {{ $buku->previousPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $buku->previousPageUrl() ?? '#' }}" aria-label="Previous">
                &laquo;
            </a>
        </li>

        {{-- Nomor Halaman --}}
        @foreach($buku->getUrlRange(1, $buku->lastPage()) as $page => $url)
            <li class="page-item {{ $buku->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Tombol Next --}}
        <li class="page-item {{ $buku->nextPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $buku->nextPageUrl() ?? '#' }}" aria-label="Next">
                &raquo;
            </a>
        </li>

    </ul>
</div>
<script>
    $(document).ready(function() {
        let csrf_token = '{{ csrf_token() }}';

        $('.btn-detail').click(function(e){
            e.preventDefault();
            let me= $(this),
            url = me.attr('href'),
            title = me.attr('title');
            id = me.attr('bookId');
            $('#title_large').text(title);

            $.ajax({
                url:"{{ route('perpus.detail_buku') }}",
                method : 'post',
                dataType : 'json',
                data: {
                    'id' : id,
                    '_token' : csrf_token            
                },
                success: function(msg){
                    $('#body_large').html(msg.body);
                    $('#title_large').text(msg.title);
                },
                beforeSend: function(msg)
                {
                    $('#body_large').html("<div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div></div>");
                },
                error: function (xhr, error, thrown)
                {
                    console.log('gagal load modal untuk detail buku : '+xhr)
                }
            });

            $("#modal_large").modal({
                show: true,
                keyboard: false
            });

            $('#modal_large').on('hidden.bs.modal', function () {
                $('#body_large').html('');
                $('#title_large').html('');
            });  
        });

    });    
    
</script>

@endsection