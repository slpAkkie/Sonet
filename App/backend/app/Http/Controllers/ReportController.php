<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade AS PDFFacade;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getPDF(Request $request)
    {
        /** @var PDF $pdf */
        $pdf = PDFFacade::loadView('sonet.report');

        return $pdf->download('report.pdf');
    }
}
