@php
    $reference = $commande->invoice_number ?: ('CMD-'.$commande->id);
@endphp

<!doctype html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin:0; padding:0; background:#F8FAFC;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background:#F8FAFC;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:600px; max-width:600px;">
                <tr>
                    <td style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:16px; padding:22px;">
                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px; font-weight:700; color:#0F172A;">
                            Facture {{ $reference }}
                        </div>
                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#64748B; margin-top:4px;">
                            Date: {{ $commande->date_commande?->format('Y-m-d') }}
                        </div>

                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#0F172A; margin-top:14px;">
                            Bonjour {{ $commande->client?->nom }},
                        </div>

                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#0F172A; margin-top:10px;">
                            Veuillez trouver en pièce jointe votre facture en PDF.
                        </div>

                        <div style="margin-top:14px; padding:12px; border:1px solid #E2E8F0; border-radius:12px;">
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#0F172A;">
                                Total HT: <strong>{{ number_format($commande->total_ht, 2) }}</strong>
                            </div>
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#0F172A; margin-top:2px;">
                                Total TTC: <strong>{{ number_format($commande->total_ttc, 2) }}</strong>
                            </div>
                        </div>

                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#64748B; margin-top:16px;">
                            Vous pouvez aussi télécharger la facture depuis votre espace si nécessaire.
                        </div>

                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#64748B; margin-top:16px;">
                            {{ config('app.name') }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:14px 8px 0 8px;">
                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#64748B;">
                            © {{ date('Y') }} {{ config('app.name') }}
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
