<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $Maildata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        //
        $this->Maildata = $data;
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return array
     */
    public function getMailData()
    {
        return $this->Maildata;
    }


    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return OrderShipped
     */
    public function build()
    {
        return $this->view('email.contact')->with('data', $this->getMailData());
    }
}
