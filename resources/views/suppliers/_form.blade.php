<div class="card">
    <div class="grid2">
        <div>
            <label>ID Supplier</label>
            <input name="kode" value="{{ old('kode', $supplier->kode ?? '') }}" placeholder="Masukkan ID Supplier" required>
            @error('kode')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>No. Telepon</label>
            <input name="telepon" value="{{ old('telepon', $supplier->telepon ?? '') }}" placeholder="Masukkan No. Telepon" required>
            @error('telepon')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="full">
            <label>Nama Supplier</label>
            <input name="nama" value="{{ old('nama', $supplier->nama ?? '') }}" placeholder="Masukkan Nama Supplier" required>
            @error('nama')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="full">
            <label>Alamat</label>
            <input name="alamat" value="{{ old('alamat', $supplier->alamat ?? '') }}" placeholder="Masukkan Alamat" required>
            @error('alamat')<div class="err">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
