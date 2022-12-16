<?php

namespace App\Jobs;

use App\Exports\JournalExport;
use App\Mail\ExportComplete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SendExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $brand;
    protected $store;

    public function __construct($brand, $store)
    {
        $this->brand = $brand;
        $this->store = $store;
    }

    public function handle()
    {
        $filename = "export-" . Str::random(20) . ".csv";

        Excel::store((new JournalExport())->forStore($this->store)->forBrand($this->brand), $filename);

        Mail::to(Auth::user()->email)->queue(new ExportComplete(Storage::url($filename)));
    }
}
