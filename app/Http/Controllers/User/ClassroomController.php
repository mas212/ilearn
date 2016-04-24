<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Discussion;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClassroomController extends Controller
{
    public function show($id)
    {
    	$classroom = Classroom::findOrFail($id);
    	$page_title = 'Kelas ' . $classroom->classname;

    	if (Gate::allows('member-of', $classroom)){
    		return view('user.classrooms.index', compact('classroom', 'page_title'));
        }

		return abort(401);
    }

    public function courses($id)
    {
        $classroom = Classroom::findOrFail($id);
        $page_title = 'Materi - Kelas ' . $classroom->classname;

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.courses', compact('classroom', 'page_title'));
        }

        return abort(401);
    }

    public function assignments($id)
    {
        $classroom = Classroom::findOrFail($id);
        $page_title = 'Tugas - Kelas ' . $classroom->classname;

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.assignments', compact('classroom', 'page_title'));
        }

        return abort(401);
    }

    public function quizes($id)
    {
        $classroom = Classroom::findOrFail($id);
        $page_title = 'Quiz - Kelas ' . $classroom->classname;

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.quizes', compact('classroom', 'page_title'));
        }

        return abort(401);
    }

    public function members($id)
    {
        $classroom = Classroom::findOrFail($id);
        $page_title = 'Anggota - Kelas ' . $classroom->classname;

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.members', compact('classroom', 'page_title'));
        }

        return abort(401);
    }

    public function discussionDetail($classroom, $discuss)
    {
        $classroom  = Classroom::findOrFail($classroom);
        $discussion = Discussion::findOrFail($discuss);

        $page_title = 'Diskusi - Detail';

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.detail-discuss', compact('classroom', 'discussion', 'page_title'));
        }

        return abort(401);
    }

    public function assignmentDetail($classroom, $assignment_id)
    {
        $classroom  = Classroom::findOrFail($classroom);
        $assignment = Assignment::findOrFail($assignment_id);
        $submit     = $assignment->submissions->contains(Auth::user()->id);
        $submitted  = $assignment->submissions()->where('user_id', Auth::user()->id)->get();
        $page_title = $assignment->title;

        if (Gate::allows('member-of', $classroom)){
            return view('user.classrooms.detail-assignment', compact('classroom', 'assignment', 'submit', 'submitted', 'page_title'));
        }

        return abort(401);
    }

    public function attachSubmission(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'file' => 'max:1000|mimes:doc,docx,pdf,zip'
        ], [
            'required' => 'Kolom :attribute diperlukan'
        ]);

        $data = [
            'title' => $request->title,
            'file' => $request->file,
            'content' => $request->content,
        ];

        if($request->hasFile('file')) {
            $data['file'] = $this->upload($request->file('file'));
        }

        Assignment::find($id)->submissions()->attach(Auth::user()->id, $data);

        \Flash::success('Tugas selesai!');

        return redirect()->back();
    }

    public function detachSubmission(Request $request, $id)
    {
        $file = '';
        $assignment = Assignment::find($id);
        $users = $assignment->submissions()->where('user_id', $request->user_id)->get();

        foreach ($users as $user) {
            $file = public_path('/uploads/assignments/' . $user->pivot->file);
        }

        if(file_exists($file) && $file) {
            unlink($file);
        }

        $assignment->submissions()->detach($request->user_id);

        \Flash::success('Jawaban siswa berhasil dibatalkan!');

        return redirect()->back();
    }

    public function download($filename)
    {
        if($filename) {
            $pathToFile = public_path('uploads/assignments/' . $filename);

            return response()->download($pathToFile, null, [], null);
        }

        return abort(500);
    }

    public function upload(UploadedFile $file)
    {
        $original = Auth::user()->fullname . '-' . pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
        $sanitize = preg_replace('/[^a-zA-Z0-9]+/', '-', $original);
        $fileName = $sanitize . '.' . $file->getClientOriginalExtension();
        $destination = public_path() . DIRECTORY_SEPARATOR . 'uploads/assignments';

        $uploaded = $file->move($destination, $fileName);

        return $fileName;
    }
}