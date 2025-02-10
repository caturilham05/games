<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use Hashids\Hashids;


class HomeController extends Controller
{
    public function index()
    {
        $games   = Games::game_list();
        $randoms = Games::game_list_populer();
        $data    = [
            'title'   => 'Dashboard',
            'games'   => $games,
            'randoms' => $randoms
        ];
        return view('index', $data);
    }

    public function show($encodedId)
    {
        $hashids = new Hashids(env('APP_KEY'), 8);
        $id      = $hashids->decode($encodedId);

        // Ambil detail game dari model
        $game        = Games::game_detail($id);
        $game_detail = $game['game_detail_data']->first()->toArray();

        if (!$game) {
            abort(404, 'Game tidak ditemukan');
        }

        $data = [
            'title'       => 'Detail',
            'game'        => $game,
            'game_detail' => $game_detail
        ];

        return view('detail', $data);
    }

    public function all()
    {
        $games = Games::game_list_all();
        $data = [
            'title' => 'All',
            'games' => $games
        ];

        return view('all', $data);
    }
}
