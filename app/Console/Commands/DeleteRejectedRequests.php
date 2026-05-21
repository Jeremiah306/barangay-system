<?php
namespace App\Console\Commands;

use App\Models\CertificateRequest;
use App\Models\Concern;
use Illuminate\Console\Command;

class DeleteRejectedRequests extends Command
{
    protected $signature   = 'delete:rejected';
    protected $description = 'Auto-delete rejected requests after 2 days';

    public function handle()
    {
        // Delete rejected certificate requests older than 2 days
        $certs = CertificateRequest::where('status', 'Rejected')
            ->where('updated_at', '<=', now()->subDays(2))
            ->delete();

        // Delete rejected concerns older than 2 days
        $concerns = Concern::where('status', 'Rejected')
            ->where('updated_at', '<=', now()->subDays(2))
            ->delete();

        $this->info("Deleted $certs certificate requests and $concerns concerns.");
    }
}