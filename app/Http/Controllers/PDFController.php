<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;


class PDFController extends Controller
{
    public function view(Request $request, $id)
    {
        $data = Resume::findOrFail($id);
        return view("pdf.view", ['data' => $data]);
    }

    public function view_pdf()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output();
    }
}


