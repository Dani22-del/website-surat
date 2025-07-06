<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, DB, Hash, Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class DataPegawaiController extends Controller
{
     public function index(Request $request)
    {
        // $user = Auth::user();
        // return Petani::where('user_id', $user->id)->first();
        if ($request->ajax()) {
            $data = User::orderBy('id', 'ASC')
           ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('level_user', function ($row) {
                    // 1) Ubah underscore jadi spasi + kapitalisasi tiap kata
                    $label = ucwords(str_replace('_', ' ', $row->level_user));
                    // alternatif: $label = Str::title(str_replace('_', ' ', $row->level_user));

                    // 2) Pilih class badge berdasarkan nilai asli (underscore)
                    switch ($row->level_user) {
                        case 'admin_devisi':
                            $class = 'bg-label-success';  // hijau
                            break;
                        case 'kepala_arsip':
                            $class = 'bg-label-warning';  // oranye
                            break;
                        case 'direktur':
                            $class = 'bg-label-primary';  // biru
                            break;
                        default:
                            $class = 'bg-label-secondary'; // abu‑abu fallback
                    }

                    // 3) Kembalikan HTML badge
                    return "<span class=\"badge rounded-pill {$class}\">{$label}</span>";
                })
              ->editColumn('status', function ($row) {
                        if ($row->status === 'Aktif') {
                            $class = 'bg-label-success';
                        } else {
                            $class = 'bg-label-danger';
                        }
                        return "<span class=\"badge rounded-pill {$class}\">{$row->status}</span>";
                    })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow " data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu " data-popper-placement="bottom-end">
                         <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="detailDataPegawai(' . $row->id . ')">
                            <i class="ri-zoom-in-line"></i> Detail
                        </a>
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
                ->rawColumns(['level_user','action','status'])
                ->make(true);
        }
        return view('data_pegawai.main')->with('data');
    }

    public function addDataPegawai(Request $request)
    {
        try {
            // $data['gudang'] = MasterGudang::where('perusahaan_id', 1)->get();
            $data['statuses'] = [
            'admin_devisi' => 'Admin Devisi',
            'kepala_arsip' => 'Kepala Arsip',
            'direktur'     => 'Direktur',
            'pegawai'      => 'Pegawai',
        ];
            $data['data'] = $request->id ? User::find($request->id) : null;
            $content = view('data_pegawai.form', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch (\Exception $e) {
            return ['status' => 'success', 'content' => $e->getMessage()];
        }
    }
    public function detailDataPegawai(Request $request)
    {
      try {
        $data['statuses'] = [
            'admin_devisi' => 'Admin Devisi',
            'kepala_arsip' => 'Kepala Arsip',
            'direktur'     => 'Direktur',
            'pegawai'      => 'Pegawai',
        ];
        $data['data'] = $request->id ? User::find($request->id) : null;
        $content = view('data_pegawai.show', $data)->render();
        return ['status' => 'success', 'content' => $content];
      } catch (\Exception $e) {
        return ['status' => 'success', 'content' => $e->getMessage()];
      }
    }
    public function store(Request $request)
    {
       
        try {
            if (!empty($request->id)) {
                $data = User::find($request->id);
            } else {
                $data = new User();
            }
            $data->name=$request->name;
            $data->email=$request->email;
            
            if ($request->filled('password')) {
            // (opsional: validasi panjang/confirmation dulu)
            $data->password = Hash::make($request->password);
            }
            $data->level_user = $request->level_user;
            $data->no_ktp = $request->no_ktp;
            $data->phone = $request->phone;
            $data->status = $request->status;
            $data->alamat = $request->alamat;
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
            $data = User::find($request->id);

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
