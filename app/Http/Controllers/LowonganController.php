<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function __construct(){
        $this->middleware('auth:api');

        // $paging->withPageKey('page')->withPerPageKey('limit');
        // parent::__construct(new Post(), $paging);
    }

    // public function details(Request $request){
        
    //     if($request){
    //         $perPage=$request->perPage;
    //     }else{
    //       $perPage=5;
    // }

    
    public function index()
    {

        $lowongans = Lowongan::paginate(100);
        return response()->json([
            'status' => 'success',
            'data' =>$lowongans,
        ]);
        // $salaries = Salary::select("*")
        //                 ->offset(10)
        //                 ->limit(10)
        //                 ->get();

        // dd($salaries);


        // $salary = $request->salary;
        // return Salary::where("salary", "LIKE", "%$salary%")->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            'lowongan' => 'required',
            'kriteria' => 'required',
            'deskripsi' => 'required',

        ]);

        if($validator->fails()){
            return response()->json([$validator->messages()]);
        }

        $lowongan = Lowongan::create([
            'lowongan' => $request->lowongan,
            'kriteria' => $request->kriteria,
            'deskripsi' => $request->deskripsi,
        ]);

        if($lowongan){
            return response()->json([
                'message'=>'berhasil menambahkan data lowongan',
            ]);
        }else{
            return response()->json([
                'message'=>'gagal menambahkan data lowongan',
            ]);
        }
    }

        
        
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Lowongan $lowongan)
    {
        return response()->json([
            'data' => $lowongan 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $lowongan->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'lowongan updated',
            'data' => $lowongan
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lowongan $lowongan)
    {
        $salary->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'lowongan berhasil dihapus',
        ]);
    }
}
