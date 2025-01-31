<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function show($link)
    {
        $link = Link::where('unique_link', $link)->first();

        if (!$link || $link->expires_at < Carbon::now()) {
            return redirect('/')->withErrors(['link' => 'The link is invalid or has expired.']);
        }

        return view('link.show', compact('link'));
    }

    public function generateNewLink($link)
    {
        $link = Link::where('unique_link', $link)->firstOrFail();
        $link->unique_link = (string) Str::uuid();
        $link->expires_at = Carbon::now()->addDays(7);
        $link->save();

        return redirect()->route('link.show', $link->unique_link);
    }

    public function deactivate($link)
    {
        $link = Link::where('unique_link', $link)->firstOrFail();
        $link->expires_at = Carbon::now();
        $link->save();

        return redirect('/')->with('status', 'Link has been deactivated successfully.');
    }

    public function imFeelingLucky($link)
    {
        $link = Link::where('unique_link', $link)->firstOrFail();
        $randomNumber = rand(1, 1000);
        $result = $randomNumber % 2 == 0 ? 'Win' : 'Lose';
        $winAmount = 0;
        if ($result == 'Win') {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        // Save result to history
        History::create([
            'link_id' => $link->id,
            'random_number' => $randomNumber,
            'result' => $result,
            'win_amount' => $winAmount,
        ]);

        return view('link.lucky', compact('randomNumber', 'result', 'winAmount', 'link'));
    }

    public function history($link)
    {
        $link = Link::where('unique_link', $link)->firstOrFail();
        $history = History::where('link_id', $link->id)->latest()->take(3)->get();

        return view('link.history', compact('history', 'link'));
    }
}
