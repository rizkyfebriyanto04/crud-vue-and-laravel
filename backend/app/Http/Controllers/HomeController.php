<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{

        public function index()
        {
            $akun = Home::latest()->get();

            return response()->json([
                'success' => true,
                'message' => 'List Akun Home',
                'data'    => $akun
            ], 200);

        }
        public function show($id)
        {
            $akun = Home::findOrfail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Akun Home',
                'data'    => $akun
            ], 200);

        }
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nama'   => 'required',
                'nik' => 'required',
                'alamat' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $akun = Home::create([
                'nama'     => $request->nama,
                'nik'   => $request->nik,
                'alamat'   => $request->alamat
            ]);

            if($akun) {

                return response()->json([
                    'success' => true,
                    'message' => 'Data Akun Berhasil di Tambahkan !!!',
                    'data'    => $akun
                ], 201);

            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal di Tambahkan',
            ], 409);

        }
        public function update(Request $request, Home $home)
        {
            //set validation
            $validator = Validator::make($request->all(), [
                'nama'   => 'required',
                'nik' => 'required',
                'alamat' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $home = Home::findOrFail($home->id);

            if($home) {

                $home->update([
                    'nama'     => $request->nama,
                    'nik'   => $request->nik
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data Akun Berhasil di Update !!!',
                    'data'    => $home
                ], 200);

            }

            return response()->json([
                'success' => false,
                'message' => 'Data Akun Tidak Ada !!!',
            ], 404);

        }

        public function destroy($id)
        {
            $akun = Home::findOrfail($id);

            if($akun) {

                $akun->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Data Akun Di Hapus !!!',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Data Akun Tidak Ada !!!',
            ], 404);
        }
}
