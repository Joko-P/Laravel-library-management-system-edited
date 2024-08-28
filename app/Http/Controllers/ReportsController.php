<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\book_issue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    protected $top_amount = 7;

    public function index()
    {
        return view('report.index');
    }

    public function weekly_report() {
        return view('report.mingguan', ['report_stat' => '', 'range' => '']);
    }

    public function generate_weekly_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        $count_jumlah = (book_issue::selectRaw('count(*)')->where('issue_status','Y')->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])->get());
        if ($count_jumlah->first()->getAttribute('count(*)') <= 0) {
            return redirect()->back()->withErrors(['title' => 'Gagal generate reports! Belum ada peminjaman yang kembali seminggu terakhir!']);
        } else {
            return view('report.final_report', [
                'satuan' => "Mingguan",
                'satuan_kecil' => "Hari",
                'top_pinjam' => $this->top_amount,
                'range' => "(".Carbon::create($request->date)->subDays(7)->format('d M Y')." - ".Carbon::create($request->date)->format('d M Y').")",
    
                'reports_all' => book_issue::select('book_issues.*','students.gender','students.name as full_name','books.name as book_title','authers.name as writer','categories.name as category','publishers.name as publisher')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->join('books','books.id','book_issues.book_id')
                ->join('authers','authers.id','books.auther_id')
                ->join('categories','categories.id','books.category_id')
                ->join('publishers','publishers.id','books.publisher_id')
                ->orderBy('issue_date')
                ->get(),

                'report_stat' => 'Y',
    
                'issue_total' => book_issue::selectRaw('fines > 0 as telat, count(*)')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->groupBy(DB::raw('fines > 0'))
                ->get(),
    
                'issue_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),
    
                'punctual_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','<=',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),
    
                'late_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','>',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),
    
                'issue_groups' => book_issue::selectRaw('DATE_FORMAT(issue_date, \'%e %b %Y\') as date')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->groupBy('date')
                ->orderBy(DB::raw('DATE_FORMAT(issue_date, \'%Y %m %d\')'))
                ->get(),
    
                'book_counts' => book_issue::selectRaw('books.name as book_title, count(*) as jumlah_buku')
                ->where('issue_status',"Y")
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->join('books','books.id','book_issues.book_id')
                ->groupBy('books.name')
                ->orderBy('jumlah_buku','desc')->orderBy('book_title','asc')
                ->get(),
    
                'daily_time' => book_issue::selectRaw('HOUR(issue_date) as jam, count(*) as jumlah')
                ->where('issue_status', 'Y')
                ->whereBetween('issue_date', [
                    Carbon::create($request->date)->subDays(7),
                    Carbon::create($request->date)
                ])
                ->groupBy(DB::raw('HOUR(issue_date)'))
                ->get(),
    
                'male_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','L')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get(),
    
                'female_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','P')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(7), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get()
            ]);
        }
        
    }

    public function monthly_report() {
        return view('report.bulanan', ['report_stat' => '', 'range' => '']);
    }

    public function generate_monthly_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        $count_jumlah = (book_issue::selectRaw('count(*)')->where('issue_status','Y')->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])->get());
        if ($count_jumlah->first()->getAttribute('count(*)') <= 0) {
            return redirect()->back()->withErrors(['title' => 'Gagal generate reports! Belum ada peminjaman yang kembali sebulan terakhir!']);
        } else {
            return view('report.final_report', [
                'satuan' => "Bulanan",
                'satuan_kecil' => "Hari",
                'top_pinjam' => $this->top_amount,
                'range' => "(".Carbon::create($request->date)->subDays(30)->format('d M Y')." - ".Carbon::create($request->date)->format('d M Y').")",

                'reports_all' => book_issue::select('book_issues.*','students.gender','students.name as full_name','books.name as book_title','authers.name as writer','categories.name as category','publishers.name as publisher')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->join('books','books.id','book_issues.book_id')
                ->join('authers','authers.id','books.auther_id')
                ->join('categories','categories.id','books.category_id')
                ->join('publishers','publishers.id','books.publisher_id')
                ->orderBy('issue_date')
                ->get(),

                'report_stat' => 'Y',

                'issue_total' => book_issue::selectRaw('fines > 0 as telat, count(*)')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->groupBy(DB::raw('fines > 0'))
                ->get(),

                'issue_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),

                'punctual_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','<=',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),

                'late_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','>',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m %d\')'))
                ->get(),

                'issue_groups' => book_issue::selectRaw('DATE_FORMAT(issue_date, \'%e %b %Y\') as date')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->groupBy('date')
                ->orderBy(DB::raw('DATE_FORMAT(issue_date, \'%Y %m %d\')'))
                ->get(),

                'book_counts' => book_issue::selectRaw('books.name as book_title, count(*) as jumlah_buku')
                ->where('issue_status',"Y")
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->join('books','books.id','book_issues.book_id')
                ->groupBy('books.name')
                ->orderBy('jumlah_buku','desc')->orderBy('book_title','asc')
                ->get(),

                'daily_time' => book_issue::selectRaw('HOUR(issue_date) as jam, count(*) as jumlah')
                ->where('issue_status', 'Y')
                ->whereBetween('issue_date', [
                    Carbon::create($request->date)->subDays(30),
                    Carbon::create($request->date)
                ])
                ->groupBy(DB::raw('HOUR(issue_date)'))
                ->get(),

                'male_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','L')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get(),

                'female_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','P')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subDays(30), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get()
            ]);
        }
    }

    public function yearly_report() {
        return view('report.tahunan', ['report_stat' => '', 'range' => '']);
    }

    public function generate_yearly_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        $count_jumlah = (book_issue::selectRaw('count(*)')->where('issue_status','Y')->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])->get());
        if ($count_jumlah->first()->getAttribute('count(*)') <= 0) {
            return redirect()->back()->withErrors(['title' => 'Gagal generate reports! Belum ada peminjaman yang kembali setahun terakhir!']);
        } else {
            return view('report.final_report', [
                'satuan' => "Tahunan",
                'satuan_kecil' => "Bulan",
                'top_pinjam' => $this->top_amount,
                'range' => "(".Carbon::create($request->date)->subMonths(12)->format('M Y')." - ".Carbon::create($request->date)->format('M Y').")",

                'reports_all' => book_issue::select('book_issues.*','students.gender','students.name as full_name','books.name as book_title','authers.name as writer','categories.name as category','publishers.name as publisher')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->join('books','books.id','book_issues.book_id')
                ->join('authers','authers.id','books.auther_id')
                ->join('categories','categories.id','books.category_id')
                ->join('publishers','publishers.id','books.publisher_id')
                ->orderBy('issue_date')
                ->get(),

                'report_stat' => 'Y',

                'issue_total' => book_issue::selectRaw('fines > 0 as telat, count(*)')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->groupBy(DB::raw('fines > 0'))
                ->get(),

                'issue_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')
                ->whereBetween('return_day', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->get(),

                'punctual_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','<=',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->get(),

                'late_counts' => book_issue::selectRaw('count(*)')
                ->where('issue_status','Y')->where('fines','>',0)
                ->whereBetween('return_day', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->groupBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->orderBy(DB::raw('DATE_FORMAT(return_day, \'%Y %m\')'))
                ->get(),

                'issue_groups' => book_issue::selectRaw('DATE_FORMAT(issue_date, \'%b %Y\') as date')
                ->where('issue_status','Y')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->groupBy('date')
                ->orderBy(DB::raw('DATE_FORMAT(issue_date, \'%Y %m\')'))
                ->get(),

                'book_counts' => book_issue::selectRaw('books.name as book_title, count(*) as jumlah_buku')
                ->where('issue_status',"Y")
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->join('books','books.id','book_issues.book_id')
                ->groupBy('books.name')
                ->orderBy('jumlah_buku','desc')->orderBy('book_title','asc')
                ->get(),

                'daily_time' => book_issue::selectRaw('HOUR(issue_date) as jam, count(*) as jumlah')
                ->where('issue_status', 'Y')
                ->whereBetween('issue_date', [
                    Carbon::create($request->date)->subMonths(12),
                    Carbon::create($request->date)
                ])
                ->groupBy(DB::raw('HOUR(issue_date)'))
                ->get(),

                'male_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','L')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get(),

                'female_most' => book_issue::selectRaw('students.name as full_name, count(*) as jumlah_pinjam')
                ->where('issue_status',"Y")->where('students.gender','P')
                ->whereBetween('issue_date', [Carbon::create($request->date)->subMonths(12), Carbon::create($request->date)])
                ->join('students','students.id','book_issues.student_id')
                ->groupBy('full_name')
                ->orderBy('jumlah_pinjam','desc')->orderBy('full_name','asc')
                ->take($this->top_amount)->get()
            ]);
        }
    }
}
