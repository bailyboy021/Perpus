@extends('app.main')
@section('content')


{{-- konten utama --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">                
            <div class="card-header text-white bg-dark">
                <div class="row">	
                    <div class="col-md-6">					
                        Daftar User
                    </div>
                    <div class="col-md-6 text-right">					
                        <button type="button" link="{{ route('tambah_user') }}" token="{{ csrf_token() }}" class="btn btn-sm btn-light add_activity" title="Tambah User Baru">+ Tambah</button>
                    </div>
                </div>                               
            </div>                               
            <div class="card-body" id="list_input">
                <div class="row">
                    <div class="mt-4 table-responsive">
                        <table class="table table-bordered table-sm table-striped table_row table-hover" id="data-user" style="cursor:pointer" width="100%">
                            <thead>
                                <tr>
                                    <th class="all text-center" width="5%">No.</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th>
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

        let user = $('#data-user').DataTable({
            
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: 
            {
                url: '{{ route('data_user') }}',
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
                {   data: 'name', name: 'name',"orderable":false },
                {   data: 'email', name: 'email',"orderable":false },
                {   data: 'role_name', name: 'role_name',"orderable":false },
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

        $('#data-user tbody').on('click', 'tr', function () {
            let data = user.row( this ).data();
            viewUser(data.id);
        });
        
        $('#btn-filter').click(function(){
            $('#data-user').DataTable().ajax.reload();
        });
    }); 

    function viewUser(id)
    {
        let csrf_token = '{{ csrf_token() }}';
        $.ajax({
            url:"{{ route('edit_user') }}",
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