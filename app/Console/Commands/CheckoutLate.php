<?php

namespace App\Console\Commands;

use App\Models\Cekin;
use App\Models\Cekout;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckoutLate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'late:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Terlambat checkout';

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
            $cek = Cekout::where([['user_id', $us->id], ['tanggal', '=', Carbon::now()->format('Y-m-d')]])->first();
            if (!$cek) {
                Cekout::create([
                    "user_id" => $us->user_id,
                    "keterangan" => "Terlambat",
                    "jam" => "--:--",
                    "tanggal" => Carbon::now()->format('Y-m-d'),
                    "latitude" => null,
                    "longitude" => null,
                    "aktivitas" => "Terlambat melakukan check out"
                ]);
            }
        }

        echo "Berhasil merekam kehadiran checkout";
    }
}
