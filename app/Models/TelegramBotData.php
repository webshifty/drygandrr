<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TelegramBotData extends Model
{
    use HasFactory;
    protected $table = 'tg_users';

    public static function firstAddUser($id, $username = null)
    {
        $data = [
            'tg_id' => $id,
            'tg_username' => $username,
            'created_at' => Carbon::now()
        ];
        $user = DB::table('tg_users')->select('tg_id')->where('tg_id', $id)->first();

        if (empty($user)) {
            DB::table('tg_users')->insert($data);
        }
    }

    public static function addCountry($id, $country)
    {
        $data = [
            'country' => $country,
            'updated_at' => Carbon::now()
        ];
        $country = DB::table('tg_users')->where('tg_id', $id)->update($data);

        return $country;
    }
}
