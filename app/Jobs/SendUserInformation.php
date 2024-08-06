<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\UserInformation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendUserInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $admins;
    
    /**
     * Create a new job instance.
     */
    public function __construct($admins)
    {
        $this->admins = $admins;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Generate PDF
        $users = User::whereHas('roles', function ($query) {
                        $query->where('code', '!=', 'admin');
                    })
                    ->with([
                        'phone',
                        'address'
                    ])
                    ->get();

        $pdf = Pdf::loadView('pdf.user-info', ['users' => $users]);
        $pdfPath = 'user-info-' . time() . '.pdf';
        $pdf->save(storage_path($pdfPath));

        // Send email
        foreach ($this->admins as $admin) {
            Mail::to($admin->email)->send(new UserInformation($admin->name, $pdfPath));
        }

        // Remove the generated PDF
        unlink(storage_path($pdfPath));
    }
}
