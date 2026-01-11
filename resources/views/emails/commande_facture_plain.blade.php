@php
    $reference = $commande->invoice_number ?: ('CMD-'.$commande->id);
@endphp

Facture {{ $reference }}
Date: {{ $commande->date_commande?->format('Y-m-d') }}

Bonjour {{ $commande->client?->nom }},

Veuillez trouver en pièce jointe votre facture en PDF.

Total HT: {{ number_format($commande->total_ht, 2) }}
Total TTC: {{ number_format($commande->total_ttc, 2) }}

{{ config('app.name') }}
