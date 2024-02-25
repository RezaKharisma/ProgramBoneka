<?php

namespace App\Exports;

use App\Models\BahanBaku;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BahanBakuExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.bahanBaku_EXCEL', [
            'data' => BahanBaku::all()
        ]);
    }
}
