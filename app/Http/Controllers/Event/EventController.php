<?php

namespace App\Http\Controllers\Event;

//import Model "Post
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Label;
use App\Models\Button;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(): View
    {
        //get event
        $data = Event::latest()->paginate(5);
        $label = Label::all();

        //render view with data
        return view('event.transaction.index', compact('data', 'label'));
    }

    public function calendar(Request $request)
    {
        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Event
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan
        $search = $request->input('search'); // Mengambil nilai pencarian dari permintaan

        $query = Event::query();

        if ($month) {
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $query->whereMonth('date', $month);
        }

        if ($search) {
            // Jika ada kata kunci pencarian, tambahkan kondisi pencarian berdasarkan judul atau deskripsi event
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Ambil data event berdasarkan kondisi yang telah ditetapkan
        $events = $query->orderBy('date', 'desc')->get();

        return view('event.transaction.calendar', [
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'events' => $events
        ]);
    }

    public function create(): View
    {
        $label = Label::all();
        return view('event.transaction.create', compact('label'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event = \App\Models\Event::latest()->first();
        $kodeEvent = "EPB-";
        if ($event == null) {
            $kodeEvent = "EPB-0001";
        } else {
            $kodeEvent = "EPB-" . sprintf("%04s", $event->id + 1);
        }

        //upload image
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('event', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $event = new Event;
            $event->image       = $imageName;
            $event->code        = $kodeEvent;
            $event->title       = $request->input('title');
            $event->price       = str_replace(".", "", $request->input('price'));
            $event->description = strip_tags($request->input('description'));
            $event->date        = $request->input('date');
            $event->time        = $request->input('time');
            $event->location    = $request->input('location');
            $event->status      = $request->input('status');
            $event->maps        = $request->input('maps');
            $event->organizer   = $request->input('organizer');
            $event->start_date  = $request->input('start_date');
            $event->end_date    = $request->input('end_date');
            $event->expiry_date = $request->input('expiry_date');
            $event->save();
        }
        //redirect to index
        return redirect()->route('event.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        //get post by ID
        $data = Event::find($id);
        // $label = Label::all();
        return response()->json($data);

        //render view with post
        // return view('event.transaction.show', compact('label'));
    }

    public function edit(string $id): View
    {
        $data = Event::findOrFail($id);
        $label = Label::all();
        return view('event.transaction.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048' . $id,
            'title'         => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $event =   Event::findOrFail($id);
        if (!$event) {
            return redirect()->route('event.transaction.index')->with('error', 'Event not found.');
        }

        //upload image
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($event->image) {
                Storage::delete('public/event/' . $event->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('event', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $event->image = $imageName;
        }

        //create post
        $event->title       = $request->input('title');
        $event->price       = $request->input('price');
        $event->description = strip_tags($request->input('description'));
        $event->date        = $request->input('date');
        $event->time        = $request->input('time');
        $event->location    = $request->input('location');
        $event->status      = $request->input('status');
        $event->maps        = $request->input('maps');
        $event->organizer   = $request->input('organizer');
        $event->start_date  = $request->input('start_date');
        $event->end_date    = $request->input('end_date');
        $event->expiry_date = $request->input('expiry_date');
        $event->save();

        return redirect()->route('event.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Event::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "About deleted successfully.";
        } else {
            $success = false;
            $message = "About deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
