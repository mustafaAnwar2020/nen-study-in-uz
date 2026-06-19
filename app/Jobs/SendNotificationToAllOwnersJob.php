<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationToAllOwnersJob implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $owners;
    protected $data;

    public function __construct($owners, $data)
    {
        $this->owners = $owners;
        $this->data = $data;
    }

    public function handle()
    {
        foreach ($this->owners as $owner) {
            sendNotification($owner, $this->data, 'general_notification', true, 'Owner');
        }
    }
}
