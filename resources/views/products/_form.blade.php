@php $edit = isset($product); @endphp
<div class="card">
    <div class="grid2">
        <div>
            <label>Kode Produk</label>
            <input name="kode" value="{{ old('kode', $product->kode ?? '') }}" placeholder="Masukkan Kode Produk" required>
            @error('kode')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $k)<option value="{{ $k }}" @selected(old('kategori', $product->kategori ?? '') === $k)>{{ $k }}</option>@endforeach
            </select>
            @error('kategori')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="full">
            <label>Nama Produk</label>
            <input name="nama" value="{{ old('nama', $product->nama ?? '') }}" placeholder="Masukkan Nama Produk" required>
            @error('nama')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Harga Beli</label>
            <input type="number" min="0" name="harga_beli" value="{{ old('harga_beli', $product->harga_beli ?? 0) }}" required>
            @error('harga_beli')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Harga Jual</label>
            <input type="number" min="0" name="harga_jual" value="{{ old('harga_jual', $product->harga_jual ?? 0) }}" required>
            @error('harga_jual')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Jumlah Stok {{ $edit ? '(hanya berubah lewat penerimaan PO)' : 'Awal' }}</label>
            <input type="number" min="0" name="stok" value="{{ old('stok', $product->stok ?? 0) }}" @if($edit) readonly @endif required>
            @error('stok')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Stok Minimum</label>
            <input type="number" min="0" name="stok_minimum" value="{{ old('stok_minimum', $product->stok_minimum ?? 0) }}" required>
            @error('stok_minimum')<div class="err">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
