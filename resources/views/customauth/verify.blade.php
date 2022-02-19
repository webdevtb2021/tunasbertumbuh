

<div class="container">
     <div class="row justify-content-center">
         <div class="col-md-8">
             <div class="card">
                 <div class="card-header">
                    <h1>Tunas Bertumbuh</h1>
                 </div>
                   <div class="card-body">
                    Halo ! Website Tunas Bertumbuh mendeteksi bahwa anda ingin mengubah password dari akun anda. Untuk itu, anda bisa mengklik link dibawah untuk melakukan proses penggantian dari password anda.
                    @if (session('resent'))
                         <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <a class="btn btn-outline-success" href="{{ request()->getSchemeAndHttpHost() }}/reset-password/{{$token}}">Klik disini</a>.
                </div>
            </div>
        </div>
    </div>
</div>
