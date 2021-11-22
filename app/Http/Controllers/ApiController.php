<?php

namespace App\Http\Controllers;

use App\Models\Cekin;
use App\Models\Cekout;
use App\Models\Cuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $data = [
                'status' => "Berhasil Login",
                'data' => Auth::user(),
            ];
        } else {
            $data = [
                'status' => "Gagal Login",
                'data' => null,
            ];
        }
        return response()->json($data);
    }

    public function getUser(User $user)
    {
        return response()->json($user);
    }
    public function getCekinCekout(User $user)
    {
        // get cekin cekout user today
        $cekin = Cekin::where('user_id', $user->id)->where('tanggal', Carbon::today())->first();
        $cekout = Cekout::where('user_id', $user->id)->where('tanggal', Carbon::today())->first();
        $data = [
            'user' => $user,
            'cekin' => $cekin,
            'cekout' => $cekout,
        ];
        return response()->json($data);
    }

    public function cekin(Request $request)
    {
        // Cek apakah jam 7:30 - 08:30
        if (Carbon::now()->format("H:i") >= "07:30" && Carbon::now()->format("H:i") <= "23:30") {
            // cekek apakah user sudah cekin
            $cek = Cekin::where([['user_id', "=", $request->user_id], ["tanggal", "=", Carbon::now()->format("Y-m-d")]])->first();
            if ($cek) {
                $data = [
                    "status" => "gagal",
                    "keterangan" => "Kamu telah melakukan Check In hari ini",
                    "data" => null
                ];
            } else {
                Cekin::create([
                    "user_id" => $request->user_id,
                    "keterangan" => "Tepat Waktu",
                    "jam" => Carbon::now()->format("H:i:s"),
                    "tanggal" => Carbon::now()->format("Y-m-d"),
                    "latitude" => $request->latitude,
                    "longitude" => $request->longitude
                ]);
                $data = [
                    "status" => "berhasil",
                    "keterangan" => "Berhasil melakukan Check In",
                    "data" => [
                        "user_id" => $request->user_id,
                        "keterangan" => "On Time",
                        "tanggal" => Carbon::now()->format("Y-m-d"),
                        "latitude" => $request->latitude,
                        "longitude" => $request->longitude
                    ]
                ];
            }
        } else {
            $data = [
                "status" => "gagal",
                "keterangan" => "Kamu tidak bisa melakukan Check In saat ini",
                "data" => null
            ];
        }
        return response()->json($data);
    }

    public function cekout(Request $request)
    {
        // Cek apakah jam 16:30 - 17:30
        if (Carbon::now()->format("H:i") >= "08:30" && Carbon::now()->format("H:i") <= "23:30") {
            // cekek apakah user sudah cekout
            $cek = Cekout::where([['user_id', "=", $request->user_id], ["tanggal", "=", Carbon::now()->format("Y-m-d")]])->first();
            if ($cek) {
                $data = [
                    "status" => "gagal",
                    "keterangan" => "Kamu telah melakukan Check Out hari ini",
                    "data" => null
                ];
            } else {
                Cekout::create([
                    "user_id" => $request->user_id,
                    "keterangan" => "On Time",
                    "jam" => Carbon::now()->format("H:i:s"),
                    "tanggal" => Carbon::now()->format("Y-m-d"),
                    "latitude" => $request->latitude,
                    "longitude" => $request->longitude,
                    "aktivitas" => $request->aktivitas
                ]);
                $data = [
                    "status" => "berhasil",
                    "keterangan" => "Berhasil melakukan Check Out",
                    "data" => [
                        "user_id" => $request->user_id,
                        "keterangan" => "On Time",
                        "tanggal" => Carbon::now()->format("Y-m-d"),
                        "latitude" => $request->latitude,
                        "longitude" => $request->longitude
                    ]
                ];
            }
        } else {
            $data = [
                "status" => "gagal",
                "keterangan" => "Kamu tidak bisa melakukan Check Out saat ini",
                "data" => null
            ];
        }
        return response()->json($data);
    }

    public function cuti(Request $request)
    {
        // cek apakah sudah cuti
        $cek = Cuti::where([['user_id', "=", $request->user_id], ["tanggal", "=", $request->tanggal]])->first();
        if ($cek) {
            $data = [
                "status" => "gagal",
                "keterangan" => "Kamu telah melakukan Cuti pada tanggal tersebut",
                "data" => null
            ];
        } else {
            Cuti::create([
                "user_id" => $request->user_id,
                "keterangan" => $request->keterangan,
                "tanggal" => $request->tanggal,
                "jenis" => $request->jenis
            ]);
            Cekin::create([
                "user_id" => $request->user_id,
                "keterangan" => "Cuti",
                "jam" => "--:--",
                "tanggal" => $request->tanggal,
                "latitude" => null,
                "longitude" => null
            ]);
            Cekout::create([
                "user_id" => $request->user_id,
                "keterangan" => "Cuti",
                "jam" => "--:--",
                "tanggal" => $request->tanggal,
                "latitude" => null,
                "longitude" => null,
                "aktivitas" => $request->keterangan
            ]);
            $data = [
                "status" => "berhasil",
                "keterangan" => "Berhasil memasukkan data cuti",
                "data" => [
                    "user_id" => $request->user_id,
                    "keterangan" => "Cuti",
                    "tanggal" => $request->tanggal,
                ]
            ];
        }
        return response()->json($data);
    }

    public function update(Request $request)
    {
        User::find($request->user_id)->update([
            "alamat" => $request->alamat,
            "no_telp" => $request->no_telp,
        ]);
        $data = [
            "status" => "berhasil",
            "keterangan" => "Berhasil mengubah data",
        ];
        return response()->json($data);
    }
}
