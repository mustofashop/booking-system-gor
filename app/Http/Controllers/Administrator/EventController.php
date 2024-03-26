<?php

namespace App\Http\Controllers\Administrator;

//import Model "Post
use App\Http\Controllers\Controller;
use App\Models\Button;
use App\Models\Event;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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
            'photo_circuit' => 'required',
            'info_circuit'  => 'required',
            'title'         => 'required',
            'price'         => 'required',
            'cost'          => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'gate'          => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
            'count_limit'   => 'required'
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

        //upload image 1
        if ($request->hasFile('image') && $request->hasFile('photo_circuit')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile1 = $request->file('image');
            $imageFile2 = $request->file('photo_circuit');
            $imageName1 = $imageFile1->hashName(); // Mendapatkan nama enkripsi file
            $imageName2 = $imageFile2->hashName(); // Mendapatkan nama enkripsi file
            $imageFile1->storePubliclyAs('event', $imageName1, 'public'); // Menyimpan file dengan nama spesifik
            $imageFile2->storePubliclyAs('event', $imageName2, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $event                      = new Event;
            $event->image               = $imageName1;
            $event->photo_circuit       = $imageName2;
            $event->code        = $kodeEvent;
            $event->title       = $request->input('title');
            $event->count_limit = $request->input('count_limit');
            $event->price       = str_replace(".", "", $request->input('price'));
            $event->cost       =  $request->input('cost');
            $event->description = strip_tags($request->input('description'));
            $event->date        = $request->input('date');
            $event->time        = $request->input('time');
            $event->location    = $request->input('location');
            $event->info_circuit    = $request->input('info_circuit');
            $event->status      = $request->input('status');
            $event->gate        = $request->input('gate');
            $event->maps        = $request->input('maps');
            $event->organizer   = $request->input('organizer');
            $event->start_date  = $request->input('start_date');
            $event->end_date    = $request->input('end_date');
            $event->expiry_date = $request->input('expiry_date');
            $event->user_id     = auth()->user()->id;
            $event->save();
        }
        //redirect to index
        return redirect()->route('event.index')->with(['success' => 'Event created successfully.']);
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
            'photo_circuit' => 'photo_circuit|mimes:jpeg,jpg,png|max:2048',
            'info_circuit'  => 'required',
            'title'         => 'required',
            'price'         => 'required',
            'cost'          => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'gate'          => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
            'count_limit'   => 'required'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $event = Event::findOrFail($id);
        if (!$event) {
            return redirect()->route('event.transaction.index')->with('error', 'Event not found.');
        }

        //upload image
        if ($request->hasFile('image') && $request->hasFile('photo_circuit')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($event->image) {
                Storage::delete('public/event/' . $event->image);
            }

            if ($event->photo_circuit) {
                Storage::delete('public/event/' . $event->photo_circuit);
            }

            $imageFile1 = $request->file('image');
            $imageFile2 = $request->file('photo_circuit');
            $imageName1 = $imageFile1->hashName(); // Mendapatkan nama enkripsi file
            $imageName2 = $imageFile2->hashName(); // Mendapatkan nama enkripsi file
            $imageFile1->storePubliclyAs('event', $imageName1, 'public'); // Menyimpan file dengan nama spesifik
            $imageFile2->storePubliclyAs('event', $imageName2, 'public'); // Menyimpan file dengan nama spesifik
        }

        //create post
        $event->title       = $request->input('title');
        $event->count_limit = $request->input('count_limit');
        $event->price       = str_replace(".", "", $request->input('price'));
        $event->cost       =  $request->input('cost');
        $event->description = strip_tags($request->input('description'));
        $event->date        = $request->input('date');
        $event->time        = $request->input('time');
        $event->location    = $request->input('location');
        $event->status      = $request->input('status');
        $event->gate        = $request->input('gate');
        $event->info_circuit    = $request->input('info_circuit');
        $event->maps        = $request->input('maps');
        $event->organizer   = $request->input('organizer');
        $event->start_date  = $request->input('start_date');
        $event->end_date    = $request->input('end_date');
        $event->expiry_date = $request->input('expiry_date');
        $event->save();

        return redirect()->route('event.index')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Event::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Event deleted successfully.";
        } else {
            $success = false;
            $message = "Event deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
