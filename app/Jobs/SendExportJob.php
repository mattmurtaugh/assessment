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
    protected $user;

    public function __construct($brand, $store, $user)
    {
        $this->brand = $brand;
        $this->store = $store;
        $this->user = $user;
    }

    public function handle()
    {
        $filename = "export-" . Str::random(20) . ".csv";

        Excel::store((new JournalExport())->forUser($this->user)->forStore($this->store)->forBrand($this->brand), $filename);

        Mail::to($this->user->email)->queue(new ExportComplete(Storage::url($filename)));
    }
}
