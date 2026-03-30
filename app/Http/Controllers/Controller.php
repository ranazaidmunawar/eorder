<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function makeInvoice(
        $request,
        $key,
        $member,
        $password,
        $amount,
        $payment_method,
        $phone,
        $base_currency_symbol_position,
        $base_currency_symbol,
        $base_currency_text,
        $order_id,
        $package_title,
        $membership): string
    {
        $file_name = uniqid($key) . ".pdf";
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('pdf.membership',
            compact(
                'request',
                'member',
                'password',
                'amount',
                'payment_method',
                'phone',
                'base_currency_symbol_position',
                'base_currency_symbol',
                'base_currency_text',
                'order_id',
                'package_title',
                'membership'
            )
        );
        $output = $pdf->output();
        $directory = public_path('assets/front/invoices/');
        if (!file_exists($directory)) mkdir($directory, 0777, true);
        file_put_contents($directory . $file_name, $output);
        return $file_name;
    }
}
