<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\Game_detail;

class Games extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'games';
    protected $fillable = [
        'id_origin',
        'title',
        'thumbnail',
        'short_description',
        'game_url',
        'genre',
        'platform',
        'publisher',
        'developer',
        'release_date',
        'freetogame_profile_url',
    ];

    protected $casts = ['release_date' => 'datetime'];

    public static function games_curl($uri)
    {
        $host    = env('RAPIDAPIGAMES');
        $key     = env('RAPIDAPIKEY');
        $url     = sprintf('https://%s/%s', $host, $uri);
        $headers = [sprintf('X-RapidAPI-Host:%s', $host), sprintf('X-RapidAPI-Key:%s', $key)];
        $curl    = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => ''
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        }

        return json_decode($response, 1);
    }

    public function sync_games()
    {
        $data = self::games_curl('api/games');

        // Siapkan data untuk upsert
        $games_data = [];
        foreach ($data as $game_data) {
            $release_date = $game_data['release_date'];
            if (!$release_date || !self::is_valid_date($release_date)) {
                $release_date = null; // Set ke null jika tanggal tidak valid
            }

            $games_data[] = [
                'id_origin'              => $game_data['id'],
                'title'                  => $game_data['title'],
                'thumbnail'              => $game_data['thumbnail'],
                'short_description'      => $game_data['short_description'],
                'game_url'               => $game_data['game_url'],
                'genre'                  => $game_data['genre'],
                'platform'               => $game_data['platform'],
                'publisher'              => $game_data['publisher'],
                'developer'              => $game_data['developer'],
                'release_date'           => $release_date,
                'freetogame_profile_url' => $game_data['freetogame_profile_url'],
            ];
        }

        $existing_games = self::get()->keyBy('id_origin');
        $is_data_change = false;
        $diff_data      = [];
        foreach ($games_data as $game_data) {
            $existing_game = $existing_games[$game_data['id_origin']] ?? null;

            if (!$existing_game || $existing_game->toArray()['id_origin'] != $game_data['id_origin']) {
                $is_data_change = true;
                $diff_data[]    = $existing_game;
                break;
            }
        }

        if (!$is_data_change) {
            return 'Data sudah sesuai dengan API';
        }

        self::truncate();

        self::upsert(
            $games_data,
            ['id_origin'],
            [
                'title',
                'thumbnail',
                'short_description',
                'game_url',
                'genre',
                'platform',
                'publisher',
                'developer',
                'release_date',
                'freetogame_profile_url',
            ]
        );

        return $data;
    }

    public static function game_detail_sync(Model $record)
    {
        $data       = self::games_curl('api/game?id='.$record->id_origin);
        $data_add[] = [
            'id_origin'                   => $data['id'],
            'status'                      => $data['status'],
            'description'                 => $data['description'],
            'minimum_system_requirements' => json_encode($data['minimum_system_requirements'] ?? ''),
            'screenshots'                 => json_encode($data['screenshots'] ?? ''),
        ];

        Game_detail::where('id_origin', $record->id)->delete();
        $id = Game_detail::upsert(
            $data_add,
            ['id_origin'],
            [
                'status',
                'description',
                'minimum_system_requirements',
                'screenshots',
            ]
        );

        return ['success' => 'Detail berhasil ditambahkan'];
    }

    public function game_detail_data()
    {
        return $this->hasMany(Game_detail::class, 'id_origin', 'id_origin');
    }

    public static function game_list()
    {
        // return self::orderBy('release_date', 'desc')->limit(8)->get();
        return self::whereHas('game_detail_data', function ($query) {
                    $query->whereNotNull('id_origin'); // Hanya game yang punya id_origin
                })
                ->orderBy('release_date', 'desc')
                ->limit(8)
                ->get();
    }

    public static function game_list_populer()
    {
        // return self::inRandomOrder()->limit(8)->get();
        return self::whereHas('game_detail_data', function ($query) {
                $query->whereNotNull('id_origin'); // Hanya game yang punya id_origin
            })
            ->inRandomOrder()
            ->limit(8)
            ->get();
    }

    public static function game_detail($id)
    {
        return self::with('game_detail_data') // Ambil data game beserta game_detail
                    ->where('id_origin', $id) // Filter berdasarkan id_origin
                    ->firstOrFail(); // Ambil satu data, error kalau tidak ada
    }

    public static function game_list_all()
    {
        return self::whereHas('game_detail_data', function ($query) {
                    $query->whereNotNull('id_origin'); // Hanya game yang punya id_origin
                })
                ->orderBy('release_date', 'desc')
                ->paginate(8);
    }

    protected static function is_valid_date($date)
    {
        if (empty($date)) {
            return false;
        }

        // Cek format tanggal (YYYY-MM-DD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            // Pisahkan tahun, bulan, dan hari
            [$year, $month, $day] = explode('-', $date);

            // Periksa apakah tanggal valid
            return checkdate($month, $day, $year);
        }

        return false;
    }

    public static function game_search($title)
    {
        return self::where('title', 'LIKE', "%{$title}%")->get();
    }
}
