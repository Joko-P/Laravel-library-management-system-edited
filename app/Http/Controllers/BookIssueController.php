<?php

namespace App\Http\Controllers;

use App\Models\book_issue;
use App\Http\Requests\Storebook_issueRequest;
use App\Http\Requests\Updatebook_issueRequest;
use App\Models\auther;
use App\Models\book;
use App\Models\settings;
use App\Models\student;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.issueBooks', [
            'books' => book_issue::all(),
            'title' => "Total"
        ]);
    }

    public function active()
    {
        return view('book.issueBooks', [
            'books' => book_issue::where('issue_status','N')->get(),
            'title' => "Aktif"
        ]);
    }

    public function late()
    {
        return view('book.issueBooks', [
            'books' => book_issue::where('issue_status','N')->where('return_date','<',date_create(date('Y-m-d')))->get(),
            'title' => "Aktif Terlambat"
        ]);
    }

    public function returned_good()
    {
        return view('book.issueBooks', [
            'books' => book_issue::where('issue_status','Y')->whereRaw('book_issues.return_date >= book_issues.return_day')->get(),
            'title' => "Kembali Tepat Waktu"
        ]);
    }

    public function returned_late()
    {
        return view('book.issueBooks', [
            'books' => book_issue::where('issue_status','Y')->whereRaw('book_issues.return_date < book_issues.return_day')->get(),
            'title' => "Kembali Terlambat"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.issueBook_add', [
            'students' => student::latest()->get(),
            'books' => book::where('in_stock','>=',1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storebook_issueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storebook_issueRequest $request)
    {
        $issue_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime((settings::latest()->first()->return_days) . " days"));
        $data = book_issue::create($request->validated() + [
            'student_id' => $request->student_id,
            'book_id' => $request->book_id,
            'issue_date' => $issue_date,
            'return_date' => $return_date,
            'issue_status' => 'N',
        ]);
        $data->save();
        $book = book::find($request->book_id);
        $book->in_stock = $book->in_stock - 1;
        $book->save();
        return redirect()->route('book_issued');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // calculate the total fine  (total days * fine per day)
        $book = book_issue::where('id',$id)->get()->first();
        $first_date = date_create(date('Y-m-d'));
        $last_date = date_create($book->return_date);
        $diff = date_diff($first_date, $last_date);
        if ($first_date < $last_date) {
            $fines = 0;
        } else {
            $fines = (settings::latest()->first()->fine * $diff->format('%a'));
        }
        // dd($fine);
        return view('book.issueBook_edit', [
            'book' => $book,
            'fine' => $fines,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatebook_issueRequest  $request
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = book_issue::find($id);
        $book->issue_status = 'Y';
        $book->return_day = now();
        $first_date = date_create(date('Y-m-d'));
        $last_date = date_create($book->return_date);
        $diff = date_diff($first_date, $last_date);
        if ($first_date < $last_date) {
            $book->fines = 0;
        } else {
            $book->fines = (settings::latest()->first()->fine * $diff->format('%a'));
        }

        $book->save();
        $bookk = book::find($book->book_id);
        $bookk->in_stock = $bookk->in_stock + 1;
        $bookk->save();
        return redirect()->route('book_issued.active');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book_issue::find($id)->delete();
        return redirect()->route('book_issued');
    }
}
