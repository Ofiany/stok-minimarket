<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8">
<style>
 body{font-family:DejaVu Sans,sans-serif;font-size:11px;color:#111}
 h2{margin:0 0 4px} .meta{margin-bottom:14px;color:#444}
 table{width:100%;border-collapse:collapse} th,td{border:1px solid #333;padding:5px 6px;text-align:left} th{background:#ddd}
</style></head><body>
<h2>Laporan {{ $report->tipeLabel() }} - Minimarket</h2>
<div class="meta">{{ $report->kode }} &middot; Periode: {{ $report->periodeLabel() }} &middot; Dibuat: {{ $report->created_at->format('d/m/Y H:i') }}</div>
@include('reports._table')
</body></html>
