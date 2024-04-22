<!DOCTYPE html>
<html>
    <head>
        <title> Kijang Mas Bandung </title>
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="min-h-screen flex justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
                        <div class="max-w-md w-full space-y-8">
                            {!! $data['messages'] !!}
                            <a href="{{ route('order_history_detail', $data['invoice_number']) }}" target="_blank" rel="noopener noreferrer">disini</a> untuk melihat pemesanan anda
                            <br>
                            <br>
                            <br>
                            <h3>Terima kasih, Salam Hormat </h3>
                            <h3>Kijang Mas</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
