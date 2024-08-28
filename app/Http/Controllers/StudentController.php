<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use App\Models\book;
use App\Models\book_issue;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index', [
            'students' => student::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request)
    {
        student::create($request->validated());

        // return redirect()->route('students');
        $the_name = $request->input('name');
        return redirect()->route('students')->with(['title' => 'Input Success!','msg' => 'Data '.$the_name.' berhasil diinput!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        return view('student.edit', [
            'student' => $student
        ]);
    }

    public function detail(student $student)
    {
        $books = book_issue::all()->where('student_id','==',$student->id);
        // dd([$student,$books]);
        return view('student.detail', [
            'student' => $student,
            'books' => $books
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, $id)
    {
        $student = student::find($id);
        $student->name = $request->name;
        $student->address = $request->address;
        $student->gender = $request->gender;
        $student->NIK = $request->NIK;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->save();

        return redirect()->route('students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            student::findorfail($id)->delete();
            return redirect()->route('students')->with(['title' => 'Delete Success!','msg' => 'Data Pengunjung berhasil dihapus!']);
        } catch(QueryException $error) {
            if ($error->getCode() == 23000) {
                return redirect()->back()->withErrors(['title' => 'Delete Failed!','msg' => 'Data Pengunjung tidak dapat dihapus karena masih tersambung data peminjaman!']);
            } else {
                return redirect()->back()->withErrors(['title' => 'SQL Error Code '.$error->getCode(),'msg' => $error->getMessage()]);
            }
        }
    }
}
