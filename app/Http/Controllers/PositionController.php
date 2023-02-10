<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Position::all();
            return DataTables::of($query)
            ->addColumn('action', function($item) {
                return '
                    <div class="d-flex justify-content-center">
                        <button data-id="'.$item->id.'" type="button" id="btn-edit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                        <button data-id="'.$item->id.'" type="button" id="btn-hapus" class="btn btn-sm btn-danger ml-3 "><i class="fas fa-trash-alt"></i></button>
                    </div>
                    ';
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('jabatan.position');
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
         $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
        ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $post = position::create([
            'name'     => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Ditambahkan!',
            'data'    => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kategori',
            'data'    => $position
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
         $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
        ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position->update([
            'name'     => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data'    => $position
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil dihapus'
        ]);
    }
}
