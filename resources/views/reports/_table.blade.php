@if ($report->tipe === 'barang_masuk')
<table>
    <thead><tr><th>Tgl Diterima</th><th>ID PO</th><th>Supplier</th><th>Kode</th><th>Produk</th><th>Dipesan</th><th>Diterima</th><th>Kondisi</th><th>Harga Beli</th></tr></thead>
    <tbody>
    @foreach ($report->data['rows'] as $r)
        <tr><td>{{ $r['tanggal'] }}</td><td>{{ $r['po'] }}</td><td>{{ $r['supplier'] }}</td><td>{{ $r['kode'] }}</td><td>{{ $r['nama'] }}</td>
            <td>{{ $r['dipesan'] }}</td><td>{{ $r['diterima'] }}</td><td>{{ $r['kondisi'] }}</td><td>{{ \App\Support\Fmt::rp($r['harga_beli']) }}</td></tr>
    @endforeach
    </tbody>
</table>
@else
<table>
    <thead><tr><th>Kode</th><th>Produk</th><th>Kategori</th><th>Stok Saat Laporan</th><th>Masuk pada Periode</th><th>Status</th></tr></thead>
    <tbody>
    @foreach ($report->data['rows'] as $r)
        <tr><td>{{ $r['kode'] }}</td><td>{{ $r['nama'] }}</td><td>{{ $r['kategori'] }}</td><td>{{ $r['stok'] }}</td><td>{{ $r['masuk'] }}</td><td>{{ $r['status'] }}</td></tr>
    @endforeach
    </tbody>
</table>
@endif
