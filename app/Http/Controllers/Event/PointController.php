<?php

namespace App\Http\Controllers\Event;

//import Model "Post
use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Member;
use App\Models\TransactionPoint;
use App\Models\Label;
use Illuminate\Support\Facades\Validator;


//return type View
use Illuminate\View\View;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index(): View
    {
        //get posts
        $data = TransactionPoint::latest()->paginate(5);
        $label = Label::all();
        $event      = Event::all();
        $member     = Member::all();
        $event_cat  = EventCategory::all();

        //render view with data
        return view('event.point.index', compact('data', 'label', 'event', 'member', 'event_cat'));
    }

    public function create(): View
    {
        $label      = Label::all();
        $event      = Event::all();
        $member     = Member::all();
        $event_cat  = EventCategory::all();
        return view('event.point.create', compact('label', 'event', 'member', 'event_cat'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'member_id'     => 'required',
            'event_id'      => 'required',
            'category_id'   => 'required',
            'point_rank'    => 'required',
            'point_participation'          => 'required',
            'total_point'   => 'required',
            'rank'          => 'required',
            'status'        => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //create post
        $point              = new TransactionPoint;
        $point->member_id   = $request->input('member_id');
        $point->event_id    = $request->input('event_id');
        $point->category_id = $request->input('category_id');
        $point->point_rank  = $request->input('point_rank');
        $point->point_participation        = $request->input('point_participation');
        $point->total_point = $request->input('total_point');
        $point->rank        = $request->input('rank');
        $point->status      = $request->input('status');
        $point->save();

        //redirect to index
        return redirect()->route('point.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        //get post by ID
        $data = TransactionPoint::find($id);
        // $label = Label::all();
        return response()->json($data);

        //render view with post
        // return view('event.transaction.show', compact('label'));
    }

    public function edit(string $id): View
    {
        $data       = TransactionPoint::findOrFail($id);
        $label      = Label::all();
        $event      = Event::all();
        $member     = Member::all();
        $event_cat  = EventCategory::all();
        return view('event.point.edit', compact('data', 'label', 'event', 'member', 'event_cat'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'member_id'     => 'required' . $id,
            'event_id'      => 'required',
            'category_id'   => 'required',
            'point_rank'    => 'required',
            'point_participation'          => 'required',
            'total_point'   => 'required',
            'rank'          => 'required',
            'status'        => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $point =   TransactionPoint::findOrFail($id);
        if (!$point) {
            return redirect()->route('event.point.index')->with('error', 'Point not found.');
        }

        //update post
        $point->member_id   = $request->input('member_id');
        $point->event_id    = $request->input('event_id');
        $point->category_id = $request->input('category_id');
        $point->point_rank  = $request->input('point_rank');
        $point->point_participation        = $request->input('point_participation');
        $point->total_point = $request->input('total_point');
        $point->rank        = $request->input('rank');
        $point->status      = $request->input('status');
        $point->save();

        return redirect()->route('point.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        //delete data
        $delete = TransactionPoint::where('id', $id)->delete();

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
