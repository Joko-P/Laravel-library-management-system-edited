<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;
use Illuminate\Database\QueryException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('book.index', [
            'books' => book::all()
        ]);
    }

    public function available()
    {

        return view('book.index', [
            'books' => book::where('in_stock','>',0)->get()
        ]);
    }

    public function borrowed()
    {

        return view('book.index', [
            'books' => book::where('in_stock','<=',0)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create',[
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorebookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorebookRequest $request)
    {
        book::create($request->validated());
        return redirect()->route('books');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(book $book)
    {
        return view('book.edit',[
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebookRequest  $request
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebookRequest $request, $id)
    {
        $book = book::find($id);
        $book->name = $request->name;
        $book->auther_id = $request->author_id;
        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->in_stock = $request->in_stock;
        $book->save();
        return redirect()->route('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            book::findorfail($id)->delete();
            return redirect()->route('books')->with(['title' => 'Delete Success!','msg' => 'Data Buku berhasil dihapus!']);
        } catch(QueryException $error) {
            if ($error->getCode() == 23000) {
                return redirect()->back()->withErrors(['title' => 'Delete Failed!','msg' => 'Data Buku tidak dapat dihapus karena masih tersambung data peminjaman!']);
            } else {
                return redirect()->back()->withErrors(['title' => 'SQL Error Code '.$error->getCode(),'msg' => $error->getMessage()]);
            }
        }
    }
}
