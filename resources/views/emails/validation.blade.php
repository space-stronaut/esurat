<!DOCTYPE html>
<html>
<head>
    <title>Validasi Akun</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Terima kasih telah mendaftar di sistem persuratan kami.</p>
    
    <p>Status validasi akun Anda saat ini: <strong>{{ $status }}</strong>.</p>

    @if($status == 'Diterima')
        <p>Anda sekarang dapat login dan mulai menggunakan layanan pengajuan surat secara online.</p>
    @else
        <p>Mohon maaf, pendaftaran Anda ditolak. Pastikan foto KTP dan Selfie Anda jelas, serta NIK sesuai dengan data aslinya.</p>
    @endif

    <p>Salam hangat,<br>Admin Persuratan</p>
</body>
</html>