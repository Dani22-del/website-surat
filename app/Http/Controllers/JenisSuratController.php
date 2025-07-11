<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\DataTables;
use Validator, DB, Hash, Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\JenisSurat;
use Yajra\DataTables\Facades\DataTables;

class JenisSuratController extends Controller
{
    public function index(Request $request)
    {
        // $user = Auth::user();
        // return Petani::where('user_id', $user->id)->first();
        if ($request->ajax()) {
            $data = JenisSurat::orderBy('id', 'ASC')
           ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow " data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu " data-popper-placement="bottom-end">
                    
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="editForm(' . $row->id . ')">
                            <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="deleteForm(' . $row->id . ')">
                            <i class="ri-delete-bin-7-line me-1"></i> Delete
                        </a>

                    </div>
                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('jenis_surat.main')->with('data');
    }

    public function addJenisSurat(Request $request)
    {
        try {
            // $data['gudang'] = MasterGudang::where('perusahaan_id', 1)->get();
            $data['data'] = $request->id ? JenisSurat::find($request->id) : null;
            $content = view('jenis_surat.form', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch (\Exception $e) {
            return ['status' => 'success', 'content' => $e->getMessage()];
        }
    }
    public function store(Request $request)
    {
       
        try {
            if (!empty($request->id)) {
                $data = JenisSurat::find($request->id);
            } else {
                $data = new JenisSurat();
            }
            $data->kode=$request->kode;
            $data->type=$request->type;
            $data->deskripsi = $request->deskripsi;
            $data->save();
            if ($data) {
                if (!empty($request->id)) {
                    return ['code' => '200', 'status' => 'success', 'message' => 'Berhasil Edit Data'];
                } else {
                    return ['code' => '200', 'status' => 'success', 'message' => 'Berhasil Tambah Data'];
                }
            } else {
                return ['code' => '201', 'status' => 'error', 'message' => 'Error'];
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!',
                'errMsg' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = JenisSurat::find($request->id);

            if (!$data) {
                return response()->json(
                    [
                        'error' => 'Data not found',
                    ],
                    404
                );
            }
            $data->delete();

            return response()->json([
                'success' => 'Data Berhasil Dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'Terjadi kesalahan, silahkan coba lagi',
                ],
                500
            );
        }
    }
}
