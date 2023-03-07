<?php

namespace App\Http\Controllers;

use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PelamarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // $pelamar = Pelamar::where([
        //     ['user_id', '=', Auth::user()->id],
        //     ['status', '=', 1],
        //     ])->get();

        $pelamar = Pelamar::paginate(100);
        return response()->json([
            'status' => 'success',
            'data' =>$pelamar,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    
        $validator = Validator::make(request()->all(),[
            'namalengkap' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'noktp' => 'required',
            'ttl' => 'required',
            'alamat' => 'required',
            'jk' => 'required',
            'cv' => 'required',
            'posisi' => 'required',
            'keahlian' => 'required',
            
        ]);

        if($validator->fails()){
            return response()->json([$validator->messages()]);
        }

        if ($request->hasfile('cv')) {            
            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('cv')->getClientOriginalName());
            $request->file('cv')->move(public_path('images'), $filename);}
        
       

        $pelamar = Pelamar::create ([
            'namalengkap' => $request->namalengkap,
            'email' => $request ->email,
            'nohp' => $request ->nohp,
            'noktp' => $request ->noktp,
            'ttl' => $request ->ttl,
            'alamat' => $request ->alamat,
            'jk' => $request ->jk,
            'cv' => $filename,
            'posisi' => $request ->posisi,
            'keahlian' => $request->keahlian,
            'status' => 0,
        ]);


         if($pelamar){
            return response()->json([
                'message'=>'berhasil menambahkan data pelamar',
            ]);
        }else{
            return response()->json([
                'message'=>'gagal menambahkan data pelamar',
            ]);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelamar  $pelamar
     * @return \Illuminate\Http\Response
     */
    public function show(Pelamar $pelamar)
    {
        return response ()->json ([
            'data'=>$pelamar
         ]);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelamar  $pelamar
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
      

        $pelamar = Pelamar::where('id', '=', $id)->update([
            'status' => 1,
        ]);
        
        // if($pelamar){
        //     return response()->json([
        //         'message'=>'Berhasil Validasi',
        //     ]);
        // }else{
        //     return response()->json([
        //         'message'=>'Permintaan Di tolak',
        //     ]);
        // }

        // $pelamar->update($request->all());

        if($pelamar){
            return response()->json([
                'message'=>'Anda Lolos',
            ]);
        }else{
            return response()->json([
                'message'=>'Anda Gagal',
            ]);
        }
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'salary updated',
        //     'data' => $pelamar
        // ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelamar  $pelamar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelamar $pelamar)
    {
        $pelamar->delete();
        return response()->json ([
            'status' => 'success',
            'message' => 'pelamar berhasil dihapus',
        ]);
    }
}
