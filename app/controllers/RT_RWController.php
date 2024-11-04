<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\RT_RWModel;
use app\models\UserModel;

class RT_RWController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->masyarakat  = new MasyarakatModel();
        $this->model->users  = new UserModel();
    }
    public  function indexRW()
    {


        $data = $this->model->masyarakat
            ->select("masyarakat.nik,nama_lengkap,alamat,rw,rt")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("role", "=", "rw")->get();
        $masyarakat = $this->model->masyarakat
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("role", "=", "masyarakat")
            ->get();
        $params["data"] = (object)[
            "title" => "RW",
            "description" => "Kelola Data ketua RW dengan mudah",
            "masyarakat" => $masyarakat,
            "data" => $data
        ];

        return $this->view("admin/rt-rw/rw", $params);
    }
    public  function ajaxMasyarakat($nik)
    {
        $data = $this->model->masyarakat
            ->select("nik,nama_lengkap,alamat,rw,rt")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("nik", "=", $nik)
            ->first();
        return response($data, 200);
    }
    public  function ajaxRw($nik)
    {
        $data = $this->model->masyarakat
            ->select("masyarakat.nik,nama_lengkap,alamat,rw,rt")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("role", "=", "rw")
            ->where("masyarakat.nik", "=", $nik)
            ->first();
        return response($data, 200);
    }


    public  function storeRW()
    {
        try {

            $nik = request("nik");
            $rw = request("rw");
            $user = $this->model->users->where("nik", "=", $nik)->first();
            if (!$user) {
                return redirect()->with("error", "Data user belum melakukan aktivasi. Harap lakukan aktivasi terlebih dahulu untuk mendaftarkan ketua RW")->back();
            }

            $rwExist =  $this->model->masyarakat
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->join("users", "masyarakat.nik", "users.nik")
                ->where("role", "=", "rw")
                ->where("rw", "=", $rw)
                ->get();

            if ($rwExist) {
                return redirect()->with("error", "RW $rw sudah memiliki Ketua RW terdaftar. Harap periksa data dan coba lagi.")->back();
            }
            $this->model->users->update($user->id, [
                "role" => "rw"
            ]);
            return redirect()->with("success", "Berhasil menambahkan ketua RW $rw")->back();
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException($th);
        }
    }
    public  function updateRW($nik)
    {
        try {

            $rw = request("rw");
            $user = $this->model->users->where("nik", "=", $nik)->first();
            if (!$user) {
                return redirect()->with("error", "Data user belum melakukan aktivasi. Harap lakukan aktivasi terlebih dahulu untuk mendaftarkan ketua RW")->back();
            }

            $rwExist =  $this->model->masyarakat
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->join("users", "masyarakat.nik", "users.nik")
                ->where("role", "=", "rw")
                ->where("rw", "=", $rw)
                ->where("masyarakat.nik", "<>", $nik)
                ->get();

            if ($rwExist) {
                return redirect()->with("error", "RW $rw sudah memiliki Ketua RW terdaftar. Harap periksa data dan coba lagi.")->back();
            }
            $this->model->users->update($user->id, [
                "role" => "masyarakat"
            ]);
            return redirect()->with("success", "Berhasil mengubah ketua RW $rw")->back();
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException($th);
        }
    }

    public  function indexRT($rw)
    {


        $data = $this->model->masyarakat
            ->select("masyarakat.nik,nama_lengkap,alamat,rw,rt")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("role", "=", "rt")
            ->where("rw", "=", $rw)
            ->get();

        $masyarakat = $this->model->masyarakat
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("rw", "=", $rw)
            ->where("role", "=", "masyarakat")
            ->get();

        $params["data"] = (object)[
            "title" => "RT",
            "description" => "Kelola Data ketua RT dengan mudah",
            "masyarakat" => $masyarakat,
            "data" => $data,
            "rw" => $rw
        ];

        return $this->view("admin/rt-rw/rt", $params);
    }

    public  function ajaxRT($rw, $nik)
    {
        $data = $this->model->masyarakat
            ->select("masyarakat.nik,nama_lengkap,alamat,rw,rt")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("role", "=", "rt")
            ->where("rw", "=", $rw)
            ->where("masyarakat.nik", "=", $nik)
            ->first();
        return response($data, 200);
    }


    public  function storeRT($rw)
    {
        try {

            $nik = request("nik");
            $rt = request("rt");
            $user = $this->model->users->where("nik", "=", $nik)->first();
            if (!$user) {
                return redirect()->with("error", "Data user belum melakukan aktivasi. Harap lakukan aktivasi terlebih dahulu untuk mendaftarkan ketua RW")->back();
            }

            $rwExist =  $this->model->masyarakat
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->join("users", "masyarakat.nik", "users.nik")
                ->where("role", "=", "rt")
                ->where("rw", "=", $rw)
                ->where("rt", "=", $rt)
                ->get();

            if ($rwExist) {
                return redirect()->with("error", "RW $rw sudah memiliki Ketua RW terdaftar. Harap periksa data dan coba lagi.")->back();
            }
            $this->model->users->update($user->id, [
                "role" => "rt"
            ]);
            return redirect()->with("success", "Berhasil menambahkan ketua RW $rw")->back();
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException($th);
        }
    }
    public  function updateRT($rw, $nik)
    {
        try {

            $rw = request("rw");
            $rt = request("rt");
            $user = $this->model->users->where("nik", "=", $nik)->first();
            if (!$user) {
                return redirect()->with("error", "Data user belum melakukan aktivasi. Harap lakukan aktivasi terlebih dahulu untuk mendaftarkan ketua RW")->back();
            }

            $rwExist =  $this->model->masyarakat
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->join("users", "masyarakat.nik", "users.nik")
                ->where("role", "=", "rt")
                ->where("rw", "=", $rw)
                ->where("rt", "=", $rt)
                ->where("masyarakat.nik", "<>", $nik)
                ->get();

            if ($rwExist) {
                return redirect()->with("error", "RW $rw sudah memiliki Ketua RW terdaftar. Harap periksa data dan coba lagi.")->back();
            }
            $this->model->users->update($user->id, [
                "role" => "masyarakat"
            ]);
            return redirect()->with("success", "Berhasil mengubah ketua RW $rw")->back();
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException($th);
        }
    }
}
