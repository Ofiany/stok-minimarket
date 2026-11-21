@extends('layouts.app')
@section('title', 'Buat Purchase Order')
@section('content')
<a class="back" href="{{ route('po.index') }}">&larr; Kembali</a>
<h1 class="title">Buat Purchase Order</h1>
<form method="POST" action="{{ route('po.store') }}" id="po-form">
    @csrf
    <div class="card" style="max-width:900px">
        <h3>Supplier</h3>
        <div class="grid2">
            <div class="full">
                <label>Supplier</label>
                <select name="supplier_id" id="supplier" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($suppliers as $s)<option value="{{ $s->id }}" @selected(old('supplier_id') == $s->id)>{{ $s->nama }}</option>@endforeach
                </select>
                @error('supplier_id')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div><label>ID Supplier</label><input id="s-kode" readonly placeholder="Otomatis Terisi"></div>
            <div><label>No. Telepon</label><input id="s-telp" readonly placeholder="Otomatis Terisi"></div>
            <div class="full"><label>Alamat</label><input id="s-alamat" readonly placeholder="Otomatis Terisi"></div>
        </div>
    </div>

    <div class="card" style="max-width:900px">
        <h3>Barang PO</h3>
        <div class="grid2" style="margin-bottom:18px">
            <div><label>ID PO</label><input readonly placeholder="Otomatis terisi saat PO dibuat"></div>
            <div><label>Tanggal PO</label><input readonly value="{{ now()->format('d/m/Y') }}"></div>
        </div>
        <div id="rows"></div>
        @error('items')<div class="err">{{ $message }}</div>@enderror
        @foreach ($errors->get('items.*') as $msgs)<div class="err">{{ $msgs[0] }}</div>@endforeach
        <button type="button" class="btn light" id="add">+ Tambah Barang</button>
        <div class="total-box">Subtotal: <span id="total">Rp 0</span></div>
    </div>

    <div class="actions" style="max-width:900px">
        <button class="btn wide">BUAT</button>
        <a class="btn wide light" href="{{ route('po.index') }}">BATAL</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
const suppliers = @json($suppliers->keyBy('id'));
const products = @json($products);
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const rows = document.getElementById('rows');
let idx = 0;

document.getElementById('supplier').addEventListener('change', e => {
    const s = suppliers[e.target.value];
    document.getElementById('s-kode').value = s ? s.kode : '';
    document.getElementById('s-telp').value = s ? s.telepon : '';
    document.getElementById('s-alamat').value = s ? s.alamat : '';
});
document.getElementById('supplier').dispatchEvent(new Event('change'));

function addRow(pid = '', qty = 1) {
    const i = idx++;
    const el = document.createElement('div');
    el.className = 'item-row';
    el.innerHTML = `
        <div><label>Kode Produk</label><select name="items[${i}][product_id]" required>
            <option value="">Pilih Kode Produk</option>
            ${products.map(p => `<option value="${p.id}">${p.kode}</option>`).join('')}
        </select></div>
        <div><label>Nama Produk</label><input readonly class="nm" placeholder="Otomatis Terisi"></div>
        <div><label>Harga Beli</label><input readonly class="hb" placeholder="Otomatis Terisi"></div>
        <div><label>Jumlah</label><input type="number" min="1" name="items[${i}][jumlah]" value="${qty}" required></div>
        <div><label>Subtotal</label><input readonly class="st" placeholder="Otomatis Terisi"></div>
        <button type="button" class="rm" title="Hapus baris">&times;</button>`;
    rows.appendChild(el);
    const sel = el.querySelector('select'), q = el.querySelector('input[type=number]');
    const refresh = () => {
        const p = products.find(x => x.id == sel.value);
        el.querySelector('.nm').value = p ? p.nama : '';
        el.querySelector('.hb').value = p ? rp(p.harga_beli) : '';
        el.querySelector('.st').value = p ? rp(p.harga_beli * (q.value || 0)) : '';
        el.dataset.sub = p ? p.harga_beli * (q.value || 0) : 0;
        total();
    };
    sel.addEventListener('change', refresh); q.addEventListener('input', refresh);
    el.querySelector('.rm').addEventListener('click', () => { el.remove(); total(); });
    if (pid) { sel.value = pid; refresh(); }
}
function total() {
    let t = 0; rows.querySelectorAll('.item-row').forEach(r => t += Number(r.dataset.sub || 0));
    document.getElementById('total').textContent = rp(t);
}
document.getElementById('add').addEventListener('click', () => addRow());
const old = @json(old('items', []));
if (Object.keys(old).length) Object.values(old).forEach(o => addRow(o.product_id, o.jumlah)); else addRow();
</script>
@endpush
