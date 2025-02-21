@extends('app.main')
@section('content')


{{-- konten utama --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">                
            <div class="card-header text-white bg-dark">
                <div class="row">	
                    <div class="col-md-6">					
                        Daftar Buku
                    </div>
                    <div class="col-md-6 text-right">					
                        <button type="button" link="{{ route('tambah_buku') }}" token="{{ csrf_token() }}" class="btn btn-sm btn-light add_activity" title="Tambah Buku Baru">+ Tambah</button>
                    </div>
                </div>                               
            </div>                               
            <div class="card-body" id="list_input">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="form-body row">
                            <div class="col-md-3">
                                <label class="col-form-label mr-2">Status</label>
                                <select id="is_available" class="form-control select2bs4">
                                    <option value=""></option>
                                    <option value="1">Tersedia</option>
                                    <option value="0">Sedang Dipinjam</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label>&nbsp;</label><br />
                                <button type="button" id="btn-filter" class="btn btn-dark btn-sm">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-4 table-responsive">
                        <table class="table table-bordered table-sm table-striped table_row table-hover" id="data-buku" style="cursor:pointer" width="100%">
                            <thead>
                                <tr>
                                    <th class="all text-center" width="5%">No.</th>
                                    <th class="text-center" width="30%">Judul</th>
                                    <th class="text-center" width="20%">Author</th>
                                    <th class="text-center" width="10%">Tahun</th>
                                    <th class="text-center" width="15%">Status</th>
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
                url: '{{ route('data_buku') }}',
                data: function (d) {
                    d.is_available = $('#is_available').val();
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
                {   data: 'title', name: 'title',"orderable":false },
                {   data: 'author', name: 'author',"orderable":false },
                {   data: 'year', name: 'year',"orderable":false },
                {   data: 'is_available', name: 'is_available',"orderable":false },
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
            viewBook(data.id);
        });
        
        $('#btn-filter').click(function(){
            $('#data-buku').DataTable().ajax.reload();
        });
    }); 

    function viewBook(id)
    {
        let csrf_token = '{{ csrf_token() }}';
        $.ajax({
            url:"{{ route('edit_buku') }}",
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
                console.log('gagal load modal untuk edit:'+xhr);
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