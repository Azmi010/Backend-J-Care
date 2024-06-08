<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aduan;

class AduanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aduans = Aduan::with('user')->get();
        return $aduans;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'status_id' => 'required',
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'like' => 'required|integer',
            'status' => 'in:pending,verified,rejected'
        ]);

        $aduan = Aduan::create([
            'user_id' => $validatedData['user_id'],
            'status_id' => $validatedData['status_id'],
            'judul' => $validatedData['judul'],
            'lokasi' => $validatedData['lokasi'],
            'keterangan' => $validatedData['keterangan'],
            'like' => $validatedData['like'],
            'status' => $validatedData['status'] ?? 'pending'
        ]);

        return response()->json($aduan, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Aduan $aduan)
    {
        return $aduan->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $aduanId)
    {
        $aduan = Aduan::findOrFail($aduanId);

        $validatedData = $request->validate([
            'like' => 'required|integer'
        ]);

        $aduan->update([
            'like' => $validatedData['like']
        ]);

        return $aduan;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $aduans = Aduan::where('user_id', $userId)->get();

        foreach ($aduans as $aduan) {
            $aduan->delete();
        }

        return response(null, 204);
    }
}
