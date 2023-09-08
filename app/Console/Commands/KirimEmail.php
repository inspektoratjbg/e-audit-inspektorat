<?php

namespace App\Console\Commands;

use App\KirimEmail as AppKirimEmail;
use App\Mail\SendEmailTest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:kirimemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email via schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // select from kirim email
        $data = AppKirimEmail::wherenull('mail_at')->limit(10)->get();
        foreach ($data as $rk) {
            // $email = new SendEmailTest();
            $body = ['body' => $rk->body,'subject'=>$rk->subject];
            Mail::to($rk->email_to)->send(new SendEmailTest($body));
            // Mail::to($to['email'])->send(new SendEmailTest($body_email));
            $update = AppKirimEmail::where('email_to', $rk->email_to)->where('subject', $rk->subject)
                ->where('body', $rk->body)
                ->where('created_at', $rk->created_at)
                ->where('updated_at', $rk->updated_at);
            $update->update(['mail_at' => Carbon::now()]);
        }
    }
}
