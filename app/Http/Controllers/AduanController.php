<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aduan;
use App\Models\Like;

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
    public function updateLike(Request $request, $aduanId)
    {
        $aduan = Aduan::findOrFail($aduanId);

        $validatedData = $request->validate([
            'like' => 'required|integer',
            'status_like' => 'required|boolean'
        ]);

        // Asumsikan Anda memiliki user_id dari autentikasi
        $userId = auth()->id();

        // Temukan atau buat entri like
        $like = Like::firstOrNew(
            ['user_id' => $userId, 'aduan_id' => $aduanId]
        );

        // Update status_like dari request
        $like->status_like = $validatedData['status_like'];
        $like->save();

        // Update jumlah like pada tabel Aduan
        $aduan->update([
            'like' => $validatedData['like']
        ]);

        return response()->json([
            'aduan' => $aduan,
            'like' => $like
        ]);
    }

    public function updateStatus(Request $request, $aduanId)
    {
        $aduan = Aduan::findOrFail($aduanId);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $aduan->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json($aduan);
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
