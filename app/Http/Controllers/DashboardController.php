<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;


class DashboardController extends Controller
{
    //Bon là on va faire un peu de stats. Je vais faire un léger mouuument sur pour voir les ventes sur une période donnée mais pas plus de toute façon les c'est un projet fictif 
    public function index(){

        //Nombre de prod actif
     $totalProduitsActif = Product::where('is_active' , 1)->count();
        
        //Prod en alerte stock
       $produitsAlerte = Product::whereColumn('quantity','<=','alert_threshold')->count();

        //vente du jour
        $ventesJour = Sale::whereDate('created_at',today())->count();

        //CA du mois 
        $caMois = Sale::whereMonth('created_at',now()->month)->sum('total_amount');

        // Dernière ventes 
       $dernieresVentes = Sale::with('user')->latest()->take(5)->get();

        // Vente de la semaine en diagramme en baton
        $ventesParJour = Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')->where('created_at','>=',now()->subDays(7))->groupBy('date')->orderBy('date')->get();

        //vente par moyen de paiement camenmbert
        $ventesParPaiement= Sale::selectRaw('payment_method, COUNT(*) as total')->groupBy('payment_method')->get();

        // Dernier mouvement de stock
        $derniersMovements = StockMovement::with('product','user')->latest()->take(5)->get();
        
        return view('dashboard.index', compact('totalProduitsActif','produitsAlerte','ventesJour','caMois','dernieresVentes','derniersMovements','ventesParJour','ventesParPaiement'));
    }
}
