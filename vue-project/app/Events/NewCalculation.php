<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCalculationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $calculation;

    public function __construct($calculation)
    {
        $this->calculation = $calculation;
    }
}
