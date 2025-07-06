<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, DB, Hash, Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SuratKeluarController extends Controller
{
 public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            if ($user->level_user == 'admin_devisi') {
                $data = SuratKeluar::where('user_id', $user->id)
                                   ->orderBy('id_surat_keluar', 'ASC')
                                   ->get();
            } elseif ($user->level_user == 'kepala_arsip') {
                // Menampilkan surat keluar berdasarkan status_arsip saja
                $data = SuratKeluar::whereIn('status_arsip', ['Pending', 'Revisi'])
                                   ->orderBy('id_surat_keluar', 'ASC')
                                   ->get();
            } elseif ($user->level_user == 'direktur') {
                $data = SuratKeluar::where('status_divisi', 'Approved')
                                   ->where('status_direktur', 'Pending')
                                   ->orderBy('id_surat_keluar', 'ASC')
                                   ->get();
            } else {
                $data = SuratKeluar::orderBy('id_surat_keluar', 'ASC')->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) use ($user) {
                    // Pilih field status sesuai role
                    if ($user->level_user === 'admin_devisi') {
                        $status = $row->status_divisi;
                    } elseif ($user->level_user === 'kepala_arsip') {
                        $status = $row->status_arsip;
                    } elseif ($user->level_user === 'direktur') {
                        $status = $row->status_direktur;
                    } else {
                        // fallback: prioritas direktur > arsip > divisi
                        if ($row->status_direktur !== 'Pending') {
                            $status = $row->status_direktur;
                        } elseif ($row->status_arsip !== 'Pending') {
                            $status = $row->status_arsip;
                        } else {
                            $status = $row->status_divisi;
                        }
                    }

                    // Tentukan kelas CSS sesuai nilai status
                    switch ($status) {
                        case 'Revisi':
                            $class = 'bg-label-warning';
                            break;
                        case 'Approved':
                            $class = 'bg-label-success';
                            break;
                        case 'Rejected':
                            $class = 'bg-label-danger';
                            break;
                        default: // Pending
                            $class = 'bg-label-info';
                    }

                    // Kembalikan badge sesuai role dan database
                    return "<span class=\"badge rounded-pill {$class}\">{$status}</span>";
                })
               ->addColumn('action', function ($row) use ($user) {
                    // 1. Admin devisi → Detail / Edit / Delete
                    if ($user->level_user === 'admin_devisi') {
                        return '
                            <div class="dropdown">
                                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-line"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="detailSuratKeluar('.$row->id_surat_keluar.')">
                                        <i class="ri-zoom-in-line"></i> Detail
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editForm('.$row->id_surat_keluar.')">
                                        <i class="ri-pencil-line me-1"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deleteForm('.$row->id_surat_keluar.')">
                                        <i class="ri-delete-bin-7-line me-1"></i> Delete
                                    </a>
                                </div>
                            </div>';
                    }

                    // 2. Kepala Arsip → tombol khusus cekKepalaArsip()
                    if ($user->level_user === 'kepala_arsip') {
                        return '
                            <button class="btn btn-sm btn-primary me-1" onclick="cekKepalaArsip('.$row->id_surat_keluar.')">
                                <i class="ri-eye-line"></i> Cek
                            </button>';
                    }

                    // 3. Direktur → tombol khusus cekDirektur()
                    if ($user->level_user === 'direktur') {
                        return '
                            <button class="btn btn-sm btn-primary me-1" onclick="cekDirektur('.$row->id_surat_keluar.')">
                                <i class="ri-eye-line"></i> Cek
                            </button>';
                    }

                    // 4. Fallback untuk role lain (jika ada)
                    return '
                        <button class="btn btn-sm btn-primary" onclick="detailSuratKeluar('.$row->id_surat_keluar.')">
                            <i class="ri-eye-line"></i> Detail
                        </button>';
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('surat_keluar.main')->with('data');
    }

//     public function store(Request $request)
// {
//     try {
//         // Ambil data pengguna yang sedang login
//         $user = Auth::user();

//         // Validasi peran pengguna: hanya admin yang boleh membuat surat
//         if ($user->level_user != 'admin_devisi') {
//             return response()->json([
//                 'code' => 403,
//                 'status' => 'error',
//                 'message' => 'Anda tidak memiliki izin untuk membuat surat keluar.'
//             ]);
//         }

//         // Tentukan apakah ini operasi tambah atau edit
//         if (!empty($request->id)) {
//             $data = SuratKeluar::find($request->id);
//             if (!$data) {
//                 return response()->json([
//                     'code' => 404,
//                     'status' => 'error',
//                     'message' => 'Surat keluar tidak ditemukan.'
//                 ]);
//             }
//         } else {
//             $data = new SuratKeluar();
//             // Set status awal untuk surat baru
//             $data->status_divisi = 'Pending';
//             $data->status_arsip = 'Pending';
//             $data->status_direktur = 'Pending';
//             $data->user_id = $user->id; // Set user_id hanya untuk data baru
//         }

//         // Isi data dari request
//         $data->nomor_surat = $request->nomor_surat;
//         $data->jenis_surat_id = $request->jenis_surat_id;
//         $data->tanggal_surat = Carbon::parse($request->tanggal_surat);
//         $data->perihal = $request->perihal;
//         $data->isi = $request->isi;
//         $data->tujuan = $request->tujuan;
//         if ($request->hasFile('lampiran')) {
//         // Hapus lampiran lama jika ada
//         if ($data->lampiran) {
//             Storage::disk('public')->delete($data->lampiran);
//         }

//         $file     = $request->file('lampiran');
//         $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
//                     .'.'. $file->getClientOriginalExtension();

//         // Simpan ke folder "lampiran" di storage/app/public
//         $path = $file->storeAs('lampiran', $filename, 'public');

//         // Simpan path di kolom database, misal "lampiran"
//         $data->lampiran = $path;
//     }

//         // Simpan data
//         $data->save();

//         // Kembalikan respons sukses
//         if ($data) {
//             if (!empty($request->id)) {
//                 return ['code' => '200', 'status' => 'success', 'message' => 'Berhasil Edit Data'];
//             } else {
//                 return ['code' => '200', 'status' => 'success', 'message' => 'Berhasil Tambah Data'];
//             }
//         } else {
//             return ['code' => '201', 'status' => 'error', 'message' => 'Gagal menyimpan data'];
//         }
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'code' => 500,
//             'message' => 'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!',
//             'errMsg' => $e->getMessage(),
//         ]);
//     }
// }

        public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if (!empty($request->id)) {
                $data = SuratKeluar::find($request->id);
                if (!$data) {
                    return response()->json([
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Surat keluar tidak ditemukan.'
                    ]);
                }
            } else {
                if ($user->level_user != 'admin_devisi') {
                    return response()->json([
                        'code' => 403,
                        'status' => 'error',
                        'message' => 'Anda tidak memiliki izin untuk membuat surat keluar.'
                    ]);
                }
                $data = new SuratKeluar();
                $data->user_id = $user->id;
                $data->status_divisi = 'Pending';
                $data->status_arsip = 'Pending';
                $data->status_direktur = 'Pending';
            }

            if ($user->level_user == 'admin_devisi') {
                $data->nomor_surat = $request->nomor_surat;
                $data->jenis_surat_id = $request->jenis_surat_id;
               $data->tanggal_surat = $request->tanggal_surat;
                $data->perihal = $request->perihal;
                $data->isi = $request->isi;
                $data->tujuan = $request->tujuan;

                if ($request->hasFile('lampiran')) {
                    if ($data->lampiran) {
                        Storage::disk('public')->delete($data->lampiran);
                    }
                    $file = $request->file('lampiran');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('lampiran', $filename, 'public');
                    $data->lampiran = $path;
                }

                if (!empty($request->id)) {
                    $data->status_divisi = 'Pending';
                    $data->status_arsip = 'Pending';
                }
            } elseif ($user->level_user == 'kepala_arsip') {
                // if ($data->status_arsip != 'Pending') {
                //     return response()->json([
                //         'code' => 403,
                //         'status' => 'error',
                //         'message' => 'Surat tidak dalam status menunggu persetujuan kepala arsip.'
                //     ]);
                // }
                if ($request->tindakan == 'Approved') {
                    $data->status_arsip = 'Pending';
                    $data->status_divisi = 'Approved';
                    $data->status_direktur = 'Pending';
                } elseif ($request->tindakan == 'Revisi') {
                    $data->status_arsip = 'Revisi';
                    $data->status_divisi = 'Revisi';
                }
                $data->catatan_kepala = $request->catatan_kepala; // Tambahkan catatan_kepala
            } elseif ($user->level_user == 'direktur') {
                // if ($data->status_direktur != 'Pending') {
                //     return response()->json([
                //         'code' => 403,
                //         'status' => 'error',
                //         'message' => 'Surat tidak dalam status menunggu persetujuan direktur.'
                //     ]);
                // }
                if ($request->tindakan == 'Approved') {
                    $data->status_direktur = 'Approved';
                    $data->status_arsip = 'Approved';
                } elseif ($request->tindakan == 'Revisi') {
                    $data->status_direktur = 'Revisi';
                    $data->status_arsip = 'Revisi';
                    $data->status_divisi = 'Revisi';
                }
                $data->catatan_direktur = $request->catatan_direktur; // Tambahkan catatan_direktur
            }

            $data->save();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => !empty($request->id) ? 'Berhasil Memperbarui Data' : 'Berhasil Tambah Data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

 public function addSuratKeluar(Request $request)
    {
        try {
            $data['jenis'] = JenisSurat::all();
            $data['data'] = $request->id ? SuratKeluar::find($request->id) : null;
            $content = view('surat_keluar.form', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch (\Exception $e) {
            return ['status' => 'success', 'content' => $e->getMessage()];
        }
    }

    public function cekKepalaArsip(Request $request)
    {
        try {
            $data['jenis'] = JenisSurat::all();
            $data['data'] = $request->id ? SuratKeluar::find($request->id) : null;
            $content = view('surat_keluar.cek_kepala', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch (\Exception $e) {
            return ['status' => 'success', 'content' => $e->getMessage()];
        }
    }
    public function cekDirektur(Request $request)
    {
        try {
            $data['jenis'] = JenisSurat::all();
            $data['data'] = $request->id ? SuratKeluar::find($request->id) : null;
            $content = view('surat_keluar.cek_direktur', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch (\Exception $e) {
            return ['status' => 'success', 'content' => $e->getMessage()];
        }
    }
    public function laporan(Request $request)
    {
         $user = Auth::user();

        // Hanya Kepala Arsip yang boleh akses halaman ini
        if ($user->level_user !== 'kepala_arsip') {
            abort(403);
        }

        if ($request->ajax()) {
            $data = SuratKeluar::where('status_arsip', 'Approved')
                            ->orderBy('id_surat_keluar', 'ASC')
                            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                // reuse addColumn('status') & addColumn('action') yang sama
                ->addColumn('status', function ($row) use ($user) {
                    // Pilih field status sesuai role
                    if ($user->level_user === 'admin_devisi') {
                        $status = $row->status_divisi;
                    } elseif ($user->level_user === 'kepala_arsip') {
                        $status = $row->status_arsip;
                    } elseif ($user->level_user === 'direktur') {
                        $status = $row->status_direktur;
                    } else {
                        // fallback: prioritas direktur > arsip > divisi
                        if ($row->status_direktur !== 'Pending') {
                            $status = $row->status_direktur;
                        } elseif ($row->status_arsip !== 'Pending') {
                            $status = $row->status_arsip;
                        } else {
                            $status = $row->status_divisi;
                        }
                    }

                    // Tentukan kelas CSS sesuai nilai status
                    switch ($status) {
                        case 'Revisi':
                            $class = 'bg-label-warning';
                            break;
                        case 'Approved':
                            $class = 'bg-label-success';
                            break;
                        case 'Rejected':
                            $class = 'bg-label-danger';
                            break;
                        default: // Pending
                            $class = 'bg-label-info';
                    }

                    // Kembalikan badge sesuai role dan database
                    return "<span class=\"badge rounded-pill {$class}\">{$status}</span>";
                })
                 ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow " data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu " data-popper-placement="bottom-end">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="detailLaporan(' . $row->id_surat_keluar . ')">
                            <i class="ri-zoom-in-line"></i> Detail
                        </a>
                          <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="cetakLaporan(' . $row->id_surat_keluar . ')">
                            <i class="ri-pencil-line me-1"></i> Cetak
                        </a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('surat_keluar.laporan')->with('data'); 
    }
}
