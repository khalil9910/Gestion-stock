<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-mail {to?}', function () {
    $to = (string) ($this->argument('to') ?? config('mail.from.address'));

    Mail::raw('Test email from Gestion Stock', function ($message) use ($to) {
        $message->to($to)->subject('Test email');
    });

    $this->info('Email sent (or logged) to: '.$to);
})->purpose('Send a test email');
