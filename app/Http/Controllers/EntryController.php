<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * Mostrar lista de entradas del usuario
     */
    public function index()
    {
        $entries = Entry::where('user_id', auth()->id())
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($entry) {

                $value = $entry->mood_value;

                // 🎨 COLOR MINI VELAS
                $color = 'gray';
                if ($value > 0) $color = 'green';
                elseif ($value < 0) $color = 'red';

                return [
                    'id' => $entry->id,
                    'title' => $entry->title,
                    'content' => $entry->content,
                    'date' => $entry->date,
                    'mood_value' => $value,
                    'size' => abs($value),
                    'color' => $color,
                ];
            });

        return Inertia::render('Entries/Index', [

            /* =======================
             📦 DATOS PRINCIPALES
            ======================= */
            'entries' => $entries,

            /* =======================
             📊 CANDLESTICK (PRO)
            ======================= */
            'chartData' => $entries->map(function ($entry) {

                $value = $entry['mood_value'];

                // 🔥 ESCALA DINÁMICA REAL
                $range = max(0.5, abs($value) * 0.5);

                if ($value > 0) {
                    $open = $value - $range;
                    $close = $value;
                } elseif ($value < 0) {
                    $open = $value + $range;
                    $close = $value;
                } else {
                    // ⚪ neutro
                    $open = 0;
                    $close = 0;
                }

                $high = max($open, $close) + $range;
                $low  = min($open, $close) - $range;

                return [
                    'x' => $entry['date'],
                    'y' => [$open, $high, $low, $close]
                ];
            }),

            /* =======================
             🟩 CALENDARIO TIPO GITHUB
            ======================= */
            'calendarData' => $entries->map(function ($entry) {

                $value = $entry['mood_value'];

                // 🎨 ESCALA DE COLOR (tipo heatmap)
                if ($value >= 8) {
                    $color = '#166534'; // verde fuerte
                } elseif ($value >= 4) {
                    $color = '#16a34a';
                } elseif ($value > 0) {
                    $color = '#4ade80';
                } elseif ($value <= -8) {
                    $color = '#7f1d1d'; // rojo fuerte
                } elseif ($value <= -4) {
                    $color = '#dc2626';
                } elseif ($value < 0) {
                    $color = '#f87171';
                } else {
                    $color = '#374151'; // gris neutro
                }

                return [
                    'date' => $entry['date'],
                    'value' => $value,
                    'color' => $color,
                ];
            }),

        ]);
    }

    /**
     * Mostrar formulario para crear entrada
     */
    public function create()
    {
        return Inertia::render('Entries/Create');
    }

    /**
     * Guardar nueva entrada
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood_value' => 'required|integer|min:-10|max:10',
        ]);

        Entry::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'title' => $request->title,
            'content' => $request->content,
            'mood_value' => $request->mood_value,
        ]);

        return redirect('/entries');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Entries/Edit', [
            'entry' => $entry
        ]);
    }

    /**
     * Actualizar entrada
     */
    public function update(Request $request, Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mood_value' => 'required|integer|min:-10|max:10',
        ]);

        $entry->update([
            'date' => $request->date,
            'title' => $request->title,
            'content' => $request->content,
            'mood_value' => $request->mood_value,
        ]);

        return redirect('/entries');
    }

    /**
     * Eliminar entrada
     */
    public function destroy(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $entry->delete();

        return redirect('/entries');
    }
}