<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->nomor_invoice }}</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace; /* Font monospace ala struk */
            background-color: #f3f4f6; /* Abu-abu di layar agar kertas terlihat */
            display: flex;
            justify-content: center;
            padding-top: 20px;
            width: 30%;
            margin: 0 auto;
        }

        /* Kontainer Utama Struk */
        .struk-wrapper {
            background-color: #fff;
            width: 75mm; /* Lebar ideal untuk printer 80mm, ubah ke 58mm jika printer kecil */
            padding: 15px 10px;
            margin-bottom: 50px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Elemen Header */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h2 {
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 0.8rem;
            color: #333;
        }

        /* Garis Putus-putus */
        .dashed-line {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }

        /* Informasi Transaksi */
        .info-table {
            width: 100%;
            font-size: 0.8rem;
        }
        .info-table td {
            padding-bottom: 3px;
        }
        
        /* Tabel Item */
        .items-table {
            width: 100%;
            font-size: 0.8rem;
            border-collapse: collapse;
        }
        .items-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .items-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        /* Utility Classes */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 0.75rem;
            margin-top: 20px;
            color: #555;
        }

        /* PENTING: Styling khusus saat Print */
        @media print {
            body {
                background-color: #fff;
                display: block; /* Hapus flex saat print */
                padding: 0;
            }
            .struk-wrapper {
                width: 100%; /* Memenuhi lebar kertas printer */
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            /* Sembunyikan elemen browser default (opsional, tergantung browser) */
            @page {
                margin: 0; /* Hapus margin default printer */
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="struk-wrapper">
        
        {{-- Header Toko --}}
        <div class="header">
            {{-- Nama Outlet --}}
            <h2>{{ $transaction->outlet->nama_outlet ?? config('app.name') }}</h2>
            
            {{-- Alamat Outlet --}}
            <p>{{ $transaction->outlet->alamat ?? '-' }}</p>
            
            {{-- <p>Telp: {{ $transaction->outlet->no_telp ?? '-' }}</p> --}}
        </div>

        <div class="dashed-line"></div>

        {{-- Info Nota --}}
        <table class="info-table">
            <tr>
                <td>No. Inv</td>
                <td>: {{ $transaction->nomor_invoice }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: {{ $transaction->user->nama_lengkap ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $transaction->customer->nama_pelanggan }}</td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        {{-- Tabel Item --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%">Menu</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th class="text-right" style="width: 40%; background-color: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->nama_produk }} <br>
                        <span style="font-size: 0.7rem; color: #666;">@ {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                    </td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td class="text-right">
                        {{-- Pastikan menggunakan subtotal_harga, jika 0 berarti data lama --}}
                        {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="dashed-line"></div>

        {{-- Total & Pembayaran --}}
        <table class="info-table">
            <tr class="font-bold" style="font-size: 0.9rem;">
                <td>TOTAL TAGIHAN</td>
                <td class="text-right">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 5px 0;"></td> {{-- Spacer --}}
            </tr>
            <tr>
                <td>Tunai / Bayar</td>
                <td class="text-right">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="text-right">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Metode Bayar</td>
                <td class="text-right" style="text-transform: uppercase;">{{ $transaction->paymentMethod->nama_metode ?? '-' }}</td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        {{-- Footer --}}
        <div class="footer">
            <p>Terima Kasih atas kunjungan Anda!</p>
            <p>Barang yang dibeli tidak dapat dikembalikan.</p>
            <p style="margin-top: 5px;">*** LUNAS ***</p>
        </div>
    </div>

</body>
</html>