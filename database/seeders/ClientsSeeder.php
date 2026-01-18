<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $client1 = Client::withTrashed()->updateOrCreate(
            ['email' => 'khalil.mosslih2@gmail.com'],
            [
                'nom' => 'Khalil Mosslih',
                'adresse' => 'Casablanca, Maroc',
                'telephone' => '0600000001',
                'type_client' => 'Solvable',
            ]
        );

        if ($client1->trashed()) {
            $client1->restore();
        }

        $client2 = Client::withTrashed()->updateOrCreate(
            ['email' => 'nadazirari123@gmail.com'],
            [
                'nom' => 'Nadia Adazirari',
                'adresse' => 'Rabat, Maroc',
                'telephone' => '0600000002',
                'type_client' => 'Solvable',
            ]
        );

        if ($client2->trashed()) {
            $client2->restore();
        }

        $client3 = Client::withTrashed()->updateOrCreate(
            ['email' => 'douaahasnaoui7@gmail.com'],
            [
                'nom' => 'Douaa Hasnaoui',
                'adresse' => 'Marrakech, Maroc',
                'telephone' => '0600000003',
                'type_client' => 'Non solvable',
            ]
        );

        if ($client3->trashed()) {
            $client3->restore();
        }
    }
}
