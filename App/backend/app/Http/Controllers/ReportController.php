<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDFFacade;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function userReport(): Response
    {
        /** @var PDF $domPDF */
        $domPDF = PDFFacade::loadView('sonet.userReport', ['user' => Auth::user()]);
        return $domPDF->download('userReport.pdf');
    }

    public function notesReport(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var PDF $domPDF */
        $domPDF = PDFFacade::loadView('sonet.notesReport', ['user' => $user]);
        return $domPDF->download('notesReport.pdf');
    }

    public function commentsReport(): Response
    {
        /** @var PDF $domPDF */
        $domPDF = PDFFacade::loadView('sonet.commentsReport', ['user' => Auth::user()]);
        return $domPDF->download('commentsReport.pdf');
    }

    public function categoriesReport(): Response
    {
        /** @var PDF $domPDF */
        $domPDF = PDFFacade::loadView('sonet.categoriesReport', ['user' => Auth::user()]);
        return $domPDF->download('categoriesReport.pdf');
    }

    public function foldersReport(): Response
    {
        /** @var PDF $domPDF */
        $domPDF = PDFFacade::loadView('sonet.foldersReport', ['user' => Auth::user()]);
        return $domPDF->download('foldersReport.pdf');
    }
}
