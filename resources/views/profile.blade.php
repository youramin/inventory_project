@extends('layouts.app')

@section('title', 'Profil')

@section('contents')
<hr />


<form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('profile.update') }}">
    @csrf
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Pengaturan Profil</h4>
                </div>
                <div class="row" id="res"></div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Nama</label>
                        <input type="text" name="name" class="form-control" placeholder="first name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Email</label>
                        <input type="text" name="email" disabled class="form-control" value="{{ auth()->user()->email }}" placeholder="Email">
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <button id="btn" class="btn btn-primary profile-button" type="button">Simpan Profil</button>
                </div>
            </div>
        </div>
    </div>   
</form>

<!-- SweetAlert2 Script -->
<script>
    document.getElementById('btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default button behavior

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Ingin Menyimpan Perubahan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Tidak, Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('profile_setup_frm').submit();
            }
        });
    });
</script>
@if(Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ Session::get('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
@endsection
