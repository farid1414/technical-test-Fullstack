<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeController extends Controller
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
            $query = Employee::with('position');
            return DataTables::of($query->get())
            ->addColumn('action', function($item) {
                return '
                    <div class="d-flex justify-content-center">
                        <button data-id="'.$item->id.'" type="button" id="btn-edit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                        <button data-id="'.$item->id.'" type="button" id="btn-hapus" class="btn btn-sm btn-danger ml-3 "><i class="fas fa-trash-alt"></i></button>
                    </div>
                    ';
            })
            ->addColumn('status-condition', function($item) {
                return $item->status === 1 ? '<p>Aktif</p>' :'<p>Tidak Aktif</p>';
            })
            ->rawColumns(['action', 'status-condition'])
            ->make();
        }
        $position = Position::all();
        return view('employee.employee', compact('position'));
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
            'nip'     => 'required|numeric',
            'departemen'     => 'required',
            'position'     => 'required',
            'date_birth'     => 'required',
            'address'     => 'required',
            'no_telp'     => 'required|numeric',
            'religion'     => 'required',
            'image'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // $gambar = $request->image;
        // $new_gambar = time() . ' - ' . $request->image->extension();
        if($request->has('image')){
            // $file = $request->file('image');
            // $name = Str::random(10);
            // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());
            $image = $request->image;
            $img= str_replace("C:\\fakepath\\"," ",$image);

            $post = Employee::create([
                'name'     => $request->name,
                'nip'     => $request->nip,
                'departemen'     => $request->departemen,
                'position_id'     => $request->position,
                'date_birth'     => $request->date_birth,
                'address'     => $request->address,
                'no_telp'     => $request->no_telp,
                'status' => true,
                'religion'     => $request->religion,
                'image'     => $img,
            ]);
        }
        // $request->image->move(public_path('images'), $img);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Ditambahkan!',
            'data'    => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kategori',
            'data'    => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
          $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'nip'     => 'required|numeric',
            'departemen'     => 'required',
            'position'     => 'required',
            'date_birth'     => 'required',
            'address'     => 'required',
            'no_telp'     => 'required|numeric',
            'religion'     => 'required',
            'image'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->image === ""){
            $img = $request->image-old;
        }else{
            $image = $request->image;
            $img= str_replace("C:\\fakepath\\"," ",$image);
        }


        if($request->input('status') !== 1){
            $status  = 0;
        }
        else{
            $status = 1;
        }


        $employee->update([
                'name'     => $request->name,
                'nip'     => $request->nip,
                'departemen'     => $request->departemen,
                'position_id'     => $request->position,
                'date_birth'     => $request->date_birth,
                'address'     => $request->address,
                'no_telp'     => $request->no_telp,
                'status' => $status,
                'religion'    => $request->input('religion'),
                'image'     => $img,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!',
            'data'    => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil dihapus'
        ]);
   }
}