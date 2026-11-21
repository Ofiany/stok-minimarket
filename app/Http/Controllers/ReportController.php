<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrderItem;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'semua');
        [$dari, $sampai] = Report::rentang($periode);

        $reports = Report::query()
            ->when($dari, fn ($q) => $q->whereBetween('created_at', [$dari, $sampai]))
            ->when($request->q, function ($q, $kata) {
                $tipe = collect(Report::TIPE)->filter(fn ($l) => stripos($l, $kata) !== false)->keys()->all();
                $q->where(fn ($w) => $w->where('kode', 'like', "%{$kata}%")->orWhereIn('tipe', $tipe));
            })
            ->latest('id')->paginate(10)->withQueryString();

        return view('reports.index', compact('reports', 'periode'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $in = $request->validate([
            'periode' => ['required', Rule::in(array_keys(Report::PERIODE))],
            'tipe' => ['required', Rule::in(array_keys(Report::TIPE))],
        ]);

        $data = $in['tipe'] === 'barang_masuk'
            ? $this->dataBarangMasuk($in['periode'])
            : $this->dataStok($in['periode']);

        if (count($data['rows']) === 0) {
            return back()->withInput()->with('error', 'Data tidak ada untuk periode dan tipe laporan yang dipilih.');
        }

        $urut = Report::whereDate('created_at', today())->count() + 1;
        $report = Report::create([
            'kode' => 'LAP-' . now()->format('Ymd') . '-' . str_pad($urut, 3, '0', STR_PAD_LEFT),
            'periode' => $in['periode'],
            'tipe' => $in['tipe'],
            'user_id' => $request->user()->id,
            'data' => $data,
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil dibuat.');
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function pdf(Report $report)
    {
        return Pdf::loadView('reports.pdf', compact('report'))
            ->setPaper('a4', $report->tipe === 'barang_masuk' ? 'landscape' : 'portrait')
            ->download($report->kode . '.pdf');
    }

    private function dataBarangMasuk(string $periode): array
    {
        [$dari, $sampai] = Report::rentang($periode);

        $rows = PurchaseOrderItem::with(['purchaseOrder.supplier', 'product'])
            ->whereNotNull('kondisi')
            ->whereHas('purchaseOrder', fn ($q) => $q
                ->where('status', 'diterima')
                ->when($dari, fn ($q) => $q->whereBetween('tanggal_terima', [$dari, $sampai])))
            ->get()
            ->sortBy(fn ($i) => $i->purchaseOrder->tanggal_terima)
            ->map(fn ($i) => [
                'tanggal' => $i->purchaseOrder->tanggal_terima->format('d/m/Y H:i'),
                'po' => $i->purchaseOrder->kode,
                'supplier' => $i->purchaseOrder->supplier->nama,
                'kode' => $i->product->kode,
                'nama' => $i->product->nama,
                'dipesan' => $i->jumlah,
                'diterima' => $i->jumlah_diterima,
                'kondisi' => ucfirst($i->kondisi),
                'harga_beli' => $i->harga_beli,
            ])->values()->all();

        return ['rows' => $rows];
    }

    private function dataStok(string $periode): array
    {
        [$dari, $sampai] = Report::rentang($periode);

        $masuk = PurchaseOrderItem::query()
            ->where('kondisi', 'baik')
            ->whereHas('purchaseOrder', fn ($q) => $q
                ->where('status', 'diterima')
                ->when($dari, fn ($q) => $q->whereBetween('tanggal_terima', [$dari, $sampai])))
            ->selectRaw('product_id, SUM(jumlah_diterima) as total')
            ->groupBy('product_id')->pluck('total', 'product_id');

        $rows = Product::orderBy('nama')->get()->map(fn ($p) => [
            'kode' => $p->kode,
            'nama' => $p->nama,
            'kategori' => $p->kategori,
            'stok' => $p->stok,
            'masuk' => (int) ($masuk[$p->id] ?? 0),
            'status' => $p->isMenipis() ? 'Menipis' : 'Aman',
        ])->all();

        return ['rows' => $rows];
    }
}
