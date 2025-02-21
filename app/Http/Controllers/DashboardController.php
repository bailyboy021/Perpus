<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['route'] = 'admin.dashboard.index';
        $data['total_user'] = User::count();
        $data['total_book'] = Book::count();
        $data['total_loan'] = Loan::count();
        
        return view('dashboard.index', $data);
    }
}
