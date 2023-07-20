<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRequestMail extends Mailable
{
    use Queueable, SerializesModels;


    public $title;
    public $body;
    public $products;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1,$data2,$data3,$data4)
    {
        //
        $this->title = $data1;
        $this->body = $data2;
        $this->products = $data3;
        $this->type = $data4;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Send Request Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    public function build()
    {
        if($this->type == 4){
            return $this->view('request')->subject('BOM Request');
        }
        if($this->type == 2){
            return $this->view('request')->subject('BOM Purchase Order');
        }
    }
}
