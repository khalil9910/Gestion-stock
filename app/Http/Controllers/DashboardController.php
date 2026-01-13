<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use App\Models\SortieStock;
use App\Models\Stock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $ordersTotal = (int) Commande::query()->count();

        $monthStart = Carbon::now()->startOfMonth();
        $ordersMonthly = (int) Commande::query()->whereDate('date_commande', '>=', $monthStart->toDateString())->count();
        $revenueMonthlyTtc = (float) Commande::query()->whereDate('date_commande', '>=', $monthStart->toDateString())->sum('total_ttc');

        $last7Start = Carbon::now()->subDays(6)->startOfDay();
        $prev7Start = Carbon::now()->subDays(13)->startOfDay();

        $ordersLast7ByDay = Commande::query()
            ->whereDate('date_commande', '>=', $last7Start->toDateString())
            ->selectRaw("DATE(date_commande) as d")
            ->selectRaw('COUNT(*) as c')
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        $ordersPrev7Total = (int) Commande::query()
            ->whereDate('date_commande', '>=', $prev7Start->toDateString())
            ->whereDate('date_commande', '<', $last7Start->toDateString())
            ->count();

        $ordersLast7Total = (int) Commande::query()
            ->whereDate('date_commande', '>=', $last7Start->toDateString())
            ->count();

        $ordersTrendPct = $ordersPrev7Total > 0
            ? (($ordersLast7Total - $ordersPrev7Total) / $ordersPrev7Total) * 100
            : ($ordersLast7Total > 0 ? 100 : 0);

        $revenueLast7ByDay = Commande::query()
            ->whereDate('date_commande', '>=', $last7Start->toDateString())
            ->selectRaw("DATE(date_commande) as d")
            ->selectRaw('COALESCE(SUM(total_ttc), 0) as s')
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        $revenuePrev7Total = (float) Commande::query()
            ->whereDate('date_commande', '>=', $prev7Start->toDateString())
            ->whereDate('date_commande', '<', $last7Start->toDateString())
            ->sum('total_ttc');

        $revenueLast7Total = (float) Commande::query()
            ->whereDate('date_commande', '>=', $last7Start->toDateString())
            ->sum('total_ttc');

        $revenueTrendPct = $revenuePrev7Total > 0
            ? (($revenueLast7Total - $revenuePrev7Total) / $revenuePrev7Total) * 100
            : ($revenueLast7Total > 0 ? 100 : 0);

        $ordersSparkLabels = [];
        $ordersSparkSeries = [];
        $revenueSparkSeries = [];

        for ($i = 0; $i < 7; $i++) {
            $d = $last7Start->copy()->addDays($i)->toDateString();
            $ordersSparkLabels[] = Carbon::parse($d)->format('D');
            $ordersSparkSeries[] = (int) ($ordersLast7ByDay[$d]->c ?? 0);
            $revenueSparkSeries[] = (float) ($revenueLast7ByDay[$d]->s ?? 0);
        }

        $stockValue = (float) Stock::query()
            ->join('produits', 'stocks.produit_id', '=', 'produits.id')
            ->selectRaw('COALESCE(SUM(stocks.qte_reelle * produits.prix_achat_ht), 0) as total')
            ->value('total');

        $totalProfit = (float) SortieStock::query()
            ->join('produits', 'sorties_stock.produit_id', '=', 'produits.id')
            ->selectRaw('COALESCE(SUM((produits.prix_vente_ht - produits.prix_achat_ht) * sorties_stock.qte_sortie), 0) as total')
            ->value('total');

        $rupturesCount = (int) Stock::query()
            ->join('produits', 'stocks.produit_id', '=', 'produits.id')
            ->whereColumn('stocks.qte_reelle', '<=', 'produits.qte_min')
            ->count();

        $topVentes = SortieStock::query()
            ->select('produit_id', DB::raw('SUM(qte_sortie) as total'))
            ->groupBy('produit_id')
            ->orderByDesc('total')
            ->with('produit')
            ->limit(5)
            ->get();

        $topLabels = $topVentes->map(fn ($row) => $row->produit?->nom ?? ('Produit #'.$row->produit_id))->values();
        $topQuantities = $topVentes->map(fn ($row) => (int) $row->total)->values();

        $productsCount = (int) Produit::query()->count();

        $ordersMonthlyPct = $ordersTotal > 0 ? min(100, ($ordersMonthly / $ordersTotal) * 100) : 0;
        $outOfStockPct = $productsCount > 0 ? min(100, ($rupturesCount / $productsCount) * 100) : 0;

        $start = Carbon::now()->startOfMonth()->subMonths(11);

        $monthlySales = Commande::query()
            ->whereDate('date_commande', '>=', $start->toDateString())
            ->selectRaw("DATE_FORMAT(date_commande, '%Y-%m') as ym")
            ->selectRaw('COALESCE(SUM(total_ht), 0) as total_ht')
            ->selectRaw('COALESCE(SUM(total_ttc), 0) as total_ttc')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $monthlyProfit = CommandeDetail::query()
            ->join('commandes', 'commande_details.commande_id', '=', 'commandes.id')
            ->join('produits', 'commande_details.produit_id', '=', 'produits.id')
            ->whereDate('commandes.date_commande', '>=', $start->toDateString())
            ->selectRaw("DATE_FORMAT(commandes.date_commande, '%Y-%m') as ym")
            ->selectRaw('COALESCE(SUM((produits.prix_vente_ht - produits.prix_achat_ht) * commande_details.quantite), 0) as profit')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $monthlyLabels = [];
        $monthlySalesHt = [];
        $monthlySalesTtc = [];
        $monthlyProfitSeries = [];

        for ($i = 0; $i < 12; $i++) {
            $m = $start->copy()->addMonths($i);
            $ym = $m->format('Y-m');

            $monthlyLabels[] = $m->format('Y-m');
            $monthlySalesHt[] = (float) ($monthlySales[$ym]->total_ht ?? 0);
            $monthlySalesTtc[] = (float) ($monthlySales[$ym]->total_ttc ?? 0);
            $monthlyProfitSeries[] = (float) ($monthlyProfit[$ym]->profit ?? 0);
        }

        $radarCount = 6;
        $radarLabels = array_slice($monthlyLabels, -$radarCount);
        $radarSales = array_slice($monthlySalesHt, -$radarCount);
        $radarProfit = array_slice($monthlyProfitSeries, -$radarCount);

        return view('dashboard', compact(
            'ordersTotal',
            'ordersMonthly',
            'revenueMonthlyTtc',
            'ordersTrendPct',
            'revenueTrendPct',
            'ordersSparkLabels',
            'ordersSparkSeries',
            'revenueSparkSeries',
            'ordersMonthlyPct',
            'outOfStockPct',
            'radarLabels',
            'radarSales',
            'radarProfit',
            'stockValue',
            'totalProfit',
            'rupturesCount',
            'productsCount',
            'topLabels',
            'topQuantities',
            'monthlyLabels',
            'monthlySalesHt',
            'monthlySalesTtc',
            'monthlyProfitSeries'
        ));
    }
}
