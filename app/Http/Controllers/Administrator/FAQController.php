<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function index()
    {
        $data = Question::paginate(10);
        $label = Label::all();
        return view('admin.faq.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $ordering = Question::pluck('ordering')->last() + 1;
        return view('admin.faq.create', compact('label', 'ordering'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'ordering' => 'required|integer|unique:setup_question,ordering',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data baru
        $model = new Question;
        $model->question = $request->input('question');
        $model->answer = $request->input('answer');
        $model->ordering = $request->input('ordering');
        $model->status = $request->input('status');
        $model->created_by = strtoupper(auth()->user()->username);
        $model->save();

        return redirect()->route('faq.index')->with('success', 'FAQ has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.faq.show', compact('label'));
    }

    public function edit($id)
    {
        $data = Question::findOrFail($id);
        $label = Label::all();
        return view('admin.faq.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'ordering' => 'required|integer|unique:setup_question,ordering,' . $id,
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $about = Question::findOrFail($id);
        if (!$about) {
            return redirect()->route('faq.index')->with('error', 'FAQ not found');
        }

        // Update data
        $about->question = $request->input('question');
        $about->answer = $request->input('answer');
        $about->ordering = $request->input('ordering');
        $about->status = $request->input('status');
        $about->updated_by = strtoupper(auth()->user()->username);
        $about->save();

        return redirect()->route('faq.index')->with('success', 'FAQ has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Question::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "FAQ deleted successfully.";
        } else {
            $success = false;
            $message = "FAQ deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
