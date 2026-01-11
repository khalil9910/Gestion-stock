<?php

namespace App\Mail;

use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommandeFactureMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Commande $commande)
    {
    }

    public function envelope(): Envelope
    {
        $reference = $this->commande->invoice_number ?: ('CMD-'.$this->commande->id);

        return new Envelope(
            subject: 'Votre facture '.$reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.commande_facture',
            text: 'emails.commande_facture_plain',
            with: [
                'commande' => $this->commande,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $commande = $this->commande;

        $filename = ($commande->invoice_number ?: ('commande-'.$commande->id)).'.pdf';

        return [
            Attachment::fromData(function () use ($commande) {
                $commande->loadMissing(['client', 'details.produit']);

                return Pdf::loadView('ventes.commandes.facture_pdf', compact('commande'))
                    ->output();
            }, $filename)->withMime('application/pdf'),
        ];
    }
}
