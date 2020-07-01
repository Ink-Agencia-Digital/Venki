<?php

namespace App\Traits;

use App\Mail\TransactionQrRoute;
use App\ResidentialComplex;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait EmailQrChecks
{
    private function queue_email($date)
    {
        $residentialComplexes = ResidentialComplex::whereHas('emails')->with("emails")->get();
        $start = $date->copy();
        $start->hour = 00;
        $start->minute = 00;
        $start->second = 00;
        $end = $date->copy();
        $end->hour = 23;
        $end->minute = 59;
        $end->second = 59;
        $residentialComplexes->each(function ($residentialComplex) use ($start, $end) {
            $checks =  $residentialComplex->employees()->whereHas('qr_checks.qr_checkpoint.qr_route.residential_complex', function ($query) use ($residentialComplex) {
                $query = $query->where("residential_complexes.id", $residentialComplex->id);
            });
            $date = Carbon::now()->toFormattedDateString();
            $checks = $checks->with(["qr_checks" => function ($query) use ($start, $end) {
                $query = $query->whereBetween('qr_checks.created_at', [$start, $end])->orderBy('created_at', 'asc')->limit(600);
            }, 'qr_checks.qr_checkpoint.qr_route.residential_complex', 'user', 'qr_checks.security_check'])->get();
            $view =  \View::make('pdf.qrchecks', compact(['checks', 'residentialComplex', 'date', 'start', 'end']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            Mail::to($residentialComplex->emails->pluck('email')->toArray())
                ->cc(["info@teranov.com.co"])
                ->send(new TransactionQrRoute($pdf));
        });
    }
}
