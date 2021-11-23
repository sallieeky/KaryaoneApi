<?php

namespace App\Console\Commands;

use App\Models\Cekin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckinLate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'late:checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Terlambat checkin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::all();
        foreach ($user as $us) {
            $cek = Cekin::where([['user_id', $us->id], ['tanggal', '=', Carbon::now()->format('Y-m-d')]])->first();
            if (!$cek) {
                Cekin::create([
                    "user_id" => $us->user_id,
                    "keterangan" => "Terlambat",
                    "jam" => "--:--",
                    "tanggal" => Carbon::now()->format('Y-m-d'),
                    "latitude" => null,
                    "longitude" => null
                ]);
            }
        }

        echo "Berhasil merekam kehadiran checkin";
    }
}
