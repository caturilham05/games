<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use Hashids\Hashids;


class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        // Ambil pencarian dari input request
        $search = $request->input('title', ''); // Default jika tidak ada pencarian

        // Membuat variabel global $search yang bisa diakses di semua view
        view()->share('search', $search);
    }

    public function index(Request $request)
    {
        $games   = $request->input('title') ? Games::game_search($request->input('title')) : Games::game_list();
        $randoms = Games::game_list_populer();
        $data    = [
            'title'   => 'Dashboard',
            'games'   => $games,
            'randoms' => $randoms,
            'search'  => $request->input('title'),
            'total'   => $games->count(),
        ];
        return view('index', $data);
    }

    public function show($encodedId)
    {
        $hashids = new Hashids(env('APP_KEY'), 8);
        $id      = $hashids->decode($encodedId);

        $game = Games::game_detail($id);

        if (!$game) {
            abort(404, 'Game tidak ditemukan');
        }

        $game_detail = $game['game_detail_data']->first();
        if (!$game_detail) {
            abort(404, 'Game tidak ditemukan');
        }

        $game_detail = $game_detail->toArray();
        $data        = [
            'title'       => 'Detail',
            'game'        => $game,
            'game_detail' => $game_detail
        ];

        return view('detail', $data);
    }

    public function all()
    {
        $games = Games::game_list_all();
        $data  = [
            'title' => 'All',
            'games' => $games,
        ];

        return view('all', $data);
    }

    public function all_load($value='')
    {
        $games = Games::game_list_all();
        $data = [
            'games' => $games,
        ];
        return view('partials.all', $data);
    }

    public function search(Request $request)
    {
        $games = Games::game_search($request->input('title'));
        dd($games);
    }
}
