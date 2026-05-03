<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use App\Models\Tache;
use App\Models\Calendrier;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $userId = auth()->id();

        // Réunions du jour (max 3)
        $reunions = Reunion::whereDate('date_reunion', $today)
            ->orderBy('heure_debut')
            ->take(3)
            ->get();

        // Tâches du jour non complétées (max 5)
        $taches = Tache::where('user_id', $userId)
            ->where('completee', false)
            ->whereDate('date_echeance', $today)
            ->orderBy('created_at')
            ->take(5)
            ->get();

        // Événements du calendrier pour la semaine courante
        $debutSemaine = Carbon::now()->startOfWeek(); // lundi
        $finSemaine   = Carbon::now()->endOfWeek();   // dimanche

        $eventsCalendrier = Calendrier::where('user_id', $userId)
            ->where(function ($q) use ($debutSemaine, $finSemaine) {
                $q->whereBetween('date_debut', [$debutSemaine, $finSemaine])
                  ->orWhereBetween('date_fin',  [$debutSemaine, $finSemaine]);
            })
            ->orderBy('date_debut')
            ->get()
            ->map(function ($ev) {
                return [
                    'label'     => $ev->titre,
                    'dayOfWeek' => Carbon::parse($ev->date_debut)->dayOfWeek,
                    'hour'      => (int) Carbon::parse($ev->date_debut)->format('H'),
                    'type'      => 'event',
                ];
            });

        $eventsTaches = Tache::where('user_id', $userId)
            ->whereBetween('date_echeance', [$debutSemaine, $finSemaine])
            ->get()
            ->map(function ($t) {
                return [
                    'label'     => $t->titre,
                    'dayOfWeek' => Carbon::parse($t->date_echeance)->dayOfWeek,
                    'hour'      => 8,
                    'type'      => 'tache',
                ];
            });

        $evenements = $eventsCalendrier->concat($eventsTaches);

        return view('welcome', compact('reunions', 'taches', 'evenements'));
    }
}