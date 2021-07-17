<?php

namespace App\Http\Controllers\Admin;
use App\Models\Coordinate;
use App\Models\Operator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoordinateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operator = Operator::all();
        $coordinate = Coordinate::all();
        return view("admin.data.coordinate.data", compact('operator','coordinate'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($coordinate)
    {
        $data = \DB::select("SELECT * FROM coordinates WHERE id = '$coordinate'");
        // $data = Operator::findOrFail($coordinate);
        if (count($data) === 0) {
            return redirect()->back();
        }
        
        return view("admin.data.coordinate.show", compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($coordinate)
    {
        $data = Coordinate::find($coordinate);
        $data->delete();
        return redirect()->route('admin.coordinate.index')->with('pesan', 'Data Berhasil Dihapus');
    }
}
