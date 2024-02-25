<?php

namespace App\Exports;

use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengeluaranBahanBakuExport implements FromView
{
    public $option;

    public $data;

    public $total;

    public function __construct($request = null)
    {
        $this->data = $request['data'];
        $this->total = $request['total'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.laporanBahanBaku_EXCEL', [
            'data' => $this->data,
            'total' => $this->total
        ]);
    }
}
