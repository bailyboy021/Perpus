@extends('app.main')
@section('content')


{{-- konten utama --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">                
            <div class="card-header text-white bg-dark">
                <div class="row">	
                    <div class="col-6">					
                        Daftar Buku Pinjaman
                    </div>
                </div>                               
            </div>                               
            <div class="card-body" id="list_input">
                @if(Auth::user()->role_id=="1" || Auth::user()->role_id=="2")
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="form-body row">
                            <div class="col-md-3">
                                <label class="col-form-label mr-2">Status</label>
                                <select id="statusPinjaman" class="form-control select2bs4">
                                    <option value=""></option>
                                    <option value="Sedang Dipinjam">Sedang Dipinjam</option>
                                    <option value="Sudah Dikembalikan">Sudah Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label>&nbsp;</label><br />
                                <button type="button" id="btn-filter" class="btn btn-dark btn-sm">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="mt-4 table-responsive">
                        <table class="table table-bordered table-sm table-striped table_row table-hover" id="data-buku" style="cursor:pointer" width="100%">
                            <thead>
                                <tr>
                                    <th class="all text-center align-middle" width="5%">No.</th>
                                    <th class="text-center align-middle" width="20%">Nama Peminjam</th>
                                    <th class="text-center align-middle" width="30%">Nama Buku</th>
                                    <th class="text-center align-middle" width="15%">Tanggal Pinjam</th>
                                    <th class="text-center align-middle" width="15%">Batas Pengembalian</th>
                                    <th class="text-center align-middle" width="15%">Tanggal Pengembalian</th>
                                    <th class="text-center align-middle" width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            allowClear: true,
            // width: 'resolve',
            placeholder: 'Pilih...',
        });

        const csrf_token = '{{ csrf_token() }}';

        let buku = $('#data-buku').DataTable({
            
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: 
            {
                url: '{{ route('perpus.data_peminjaman') }}',
                data: function (d) {
                    d.statusPinjaman = $('#statusPinjaman').val();
                    d._token = csrf_token;
                },
                method: 'post',
                error: function (xhr, error, thrown) {
                    console.error("Error detail:", xhr, error, thrown);
                }		
            },
            columns: [
                {   data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    } 
                },
                {   data: 'name', name: 'name',"orderable":false },
                {   data: 'title', name: 'title',"orderable":false },
                {   data: 'borrowed_at', name: 'borrowed_at',"orderable":false },
                {   data: 'due_date', name: 'due_date',"orderable":false },
                {   data: 'returned_at', name: 'returned_at',"orderable":false },
                {   data: 'status', name: 'status',"orderable":false },
            ],
            columnDefs: [{ 
                    "targets": [ 0, 1 ],
                    "orderable": false, 
                },
            ],
                    
            order: [],
            
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                "search" : "Search : ",
                "searchPlaceholder" : "Type to search"
            }
        });

        $('#data-buku tbody').on('click', 'tr', function () {
            let data = buku.row( this ).data();
            let authUserId = "{{ auth()->user()->id }}"
            let role = "{{ auth()->user()->role_id }}"
            if (authUserId == data.user_id || role == 1) {
                viewPinjaman(data.id);
            }
        });
        
        $('#btn-filter').click(function(){
            $('#data-buku').DataTable().ajax.reload();
        });
    }); 

    function viewPinjaman(id)
    {
        let csrf_token = '{{ csrf_token() }}';
        $.ajax({
            url:"{{ route('perpus.detail_peminjaman') }}",
            method : 'post',
            dataType : 'json',
            data: {
                'id' : id,
                '_token' : csrf_token            
            },
            success: function(msg){
                $('#content_body').html(msg.body);
                $('#content_title').text(msg.title);
            },
            beforeSend: function(msg)
            {
                $('#content_body').html("<div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div></div>");
            },
            error: function (xhr, error, thrown)
            {
                console.log('gagal load modal untuk mengembalikan buku:',xhr);
            }
        });   
        
        $("#modal_add").modal({
            show: true,
            keyboard: false
        });

        $('#modal_add').on('hidden.bs.modal', function () {
            $('#content_body').html('');
            $('#content_title').html('');
        }); 
    }
</script>

@endsection