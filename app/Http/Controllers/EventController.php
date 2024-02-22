<?php

namespace App\Http\Controllers;

//import Model "Post

use App\Models\Absensi;
use App\Models\Event;
use App\Models\Pegawai;

//return type View
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get posts
        $posts = Event::latest()->paginate(5);

        //render view with posts
        return view('event.index', compact('posts'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $posts = DB::table('jadwal')
            ->leftjoin('pegawai', 'jadwal.npk', '=', 'pegawai.npk')
            ->select('jadwal.*', 'pegawai.nama')
            ->get();

        return view('jadwal.tambah_absensi', compact('posts', 'karyawan'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        // $this->validate($request, [
        //     'nama'     => 'required',
        //     'npk'     => 'required|min:5',
        //     'jenis_kelamin'   => 'required'
        // ]);
        // $date = date(now());
        $bulan = date('m-Y');
        // $curTime = new \DateTime();
        // $created_at = $curTime->format("Y-m-d H:i:s");
        // $updateTime = new \DateTime(); $updated_at = $updateTime->format("Y-m-d H:i:s");
        $updated = Carbon::now();
        //create post
        Event::create([
            'npk'     => $request->npk,
            'bulan'   => $bulan,
            'masuk'   => $updated,
            'latitude'   => $request->latitude,
            'longitude'   => $request->longitude
        ]);

        //redirect to index
        return redirect()->route('jadwal.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get post by ID
        $post = Event::findOrFail($id);

        //render view with post
        return view('absensi.show', compact('post'));
    }

    public function edit(string $id): View
    {
        //get post by ID
        $post = DB::table('jadwal')
            ->leftjoin('pegawai', 'jadwal.npk', '=', 'pegawai.npk')
            ->select('jadwal.*', 'pegawai.nama')
            ->where('jadwal.id', '=', $id)
            ->get();

        //render view with post
        return view('jadwal.edit', compact('post'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'npk'     => 'required|min:5',
            'jenis_kelamin'   => 'required'
        ]);

        //get post by ID
        $post = Event::findOrFail($id);

        //update post without image
        $post->update([
            'nama'     => $request->nama,
            'npk'     => $request->npk,
            'jenis_kelamin'   => $request->jenis_kelamin
        ]);

        //redirect to index
        return redirect()->route('absensi.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $post = Event::findOrFail($id);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('jadwal.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
