<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game_detail extends Model
{
    use HasFactory;
    protected $table    = 'game_detail';
    protected $fillable = [
        'game_id',
        'status',
        'description',
        'minimum_system_requirements',
        'screenshots',
    ];

    protected $casts = [
        'minimum_system_requirements' => 'array',
        'screenshots'                 => 'array',
    ];

    public function game_detail()
    {
        return $this->hasOne(Games::class, 'id', 'id_origin');
    }

    public static function game_detail_sync(Model $record)
    {
        dd($record);
    }
}
