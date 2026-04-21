<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan - {{ $penjualan->penjualan_kode }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 300px; margin: 0 auto; padding: 10px; }
        .header { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px; }
        .header h2 { font-size: 16px; font-weight: bold; }
        .info { margin-bottom: 8px; }
        .info table { width: 100%; }
        .items { border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 8px 0; margin: 8px 0; }
        .items table { width: 100%; }
        .items td { vertical-align: top; }
        .total { margin-top: 8px; }
        .total table { width: 100%; }
        .total .grand-total { font-weight: bold; font-size: 14px; border-top: 1px solid #000; padding-top: 4px; }
        .footer { text-align: center; margin-top: 10px; border-top: 1px dashed #000; padding-top: 8px; }
        @media print {
            body { width: auto; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>TOKO POS SEDERHANA</h2>
        <p>Jl. Contoh No. 1, Kota Anda</p>
        <p>Telp: 0812-3456-7890</p>
    </div>
 
    <div class="info">
        <table>
            <tr><td>No</td><td>: {{ $penjualan->penjualan_kode }}</td></tr>
            <tr><td>Tanggal</td><td>: {{ $penjualan->penjualan_tanggal->format('d/m/Y H:i') }}</td></tr>
            <tr><td>Kasir</td><td>: {{ $penjualan->user->nama }}</td></tr>
            <tr><td>Pembeli</td><td>: {{ $penjualan->pembeli ?? 'Umum' }}</td></tr>
        </table>
    </div>
 
    <div class="items">
        <table>
            @php $total = 0; @endphp
            @foreach($penjualan->details as $detail)
            @php
                $subtotal = $detail->harga * $detail->jumlah;
                $total += $subtotal;
            @endphp
            <tr>
                <td colspan="2">{{ $detail->barang->barang_nama }}</td>
            </tr>
            <tr>
                <td>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td style="text-align:right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    </div>
 
    <div class="total">
        <table>
            <tr class="grand-total">
                <td><strong>TOTAL</strong></td>
                <td style="text-align:right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        <p>Terima kasih telah berbelanja!</p>
        <p>Barang yang sudah dibeli</p>
        <p>tidak dapat dikembalikan.</p>
    </div>
 
    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.print()" style="padding:8px 20px; cursor:pointer;">🖨️ Cetak</button>
        <button onclick="window.close()" style="padding:8px 20px; cursor:pointer; margin-left:10px;">✕ Tutup</button>
    </div>
 
    <script>
        // Auto print saat halaman dibuka
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>