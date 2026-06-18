@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-4">
    Scan KTM Mahasiswa
</h1>

<p class="text-gray-600 mb-4">
    Arahkan kamera ke QR Code pada KTM mahasiswa.
</p>

<div class="bg-yellow-100 p-3 rounded mb-4">
    Dekatkan QR KTM ke kamera sekitar 10–15 cm,
    pastikan pencahayaan cukup dan QR terlihat jelas.
</div>

<div class="bg-white p-4 rounded shadow">

    <div id="reader" class="w-full max-w-md"></div>

</div>

<div id="result" class="mt-5"></div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let processing = false;

function onScanSuccess(decodedText)
{
    // Cegah scan berulang saat request masih diproses
    //alert("QR TERBACA");

    //console.log(decodedText);

    //fetch('/scan', { 

    //});
    
    //alert(decodedText);
    //if (processing)
    //{
    //    return;
   // }

    processing = true;

    fetch('/scan', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        body: JSON.stringify({
            nim: decodedText
        })

    })
    .then(response => response.json())
    .then(data => {

        if(data.success)
        {
            document.getElementById('result').innerHTML = `
                <div class="bg-green-100 border border-green-300 p-4 rounded">
                    <h3 class="font-bold text-green-700">
                        ✓ Presensi Berhasil
                    </h3>

                    <p class="mt-2">
                        Nama: ${data.name}
                    </p>

                    <p>
                        Event: ${data.event ?? '-'}
                    </p>
                </div>
            `;
        }
        else
        {
            document.getElementById('result').innerHTML = `
                <div class="bg-red-100 border border-red-300 p-4 rounded">
                    <h3 class="font-bold text-red-700">
                        ✕ Presensi Gagal
                    </h3>

                    <p class="mt-2">
                        ${data.message}
                    </p>
                </div>
            `;
        }

        // Aktifkan scanner lagi setelah 3 detik
        setTimeout(() => {
            processing = false;
        }, 3000);

    })
    .catch(error => {

        document.getElementById('result').innerHTML = `
            <div class="bg-red-100 border border-red-300 p-4 rounded">
                Terjadi kesalahan sistem
            </div>
        `;

        setTimeout(() => {
            processing = false;
        }, 3000);

        console.error(error);

    });
}

let html5QrcodeScanner =
    new Html5QrcodeScanner(
        "reader",
        {
            fps: 5,
            qrbox: 300
        }
    );
html5QrcodeScanner.render(
    onScanSuccess,
    (error) => {
        console.log(error);
    }
);

</script>

@endsection