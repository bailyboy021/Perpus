<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Helpers\Encrypt;
use DataTables;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Loan;
use Auth;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Perpustakaan Gefami';
        $data['route'] = 'books';
        // $data['buku'] = Book::paginate(9);

        $query = Book::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $data['buku'] = $query->paginate(9);

		return view('rak-buku.index', $data);
    }

    public function detailBook(Request $request)
    {
        $model = Book::where('id', $request->id)->firstOrFail();

        $data['dataBuku'] = $model;

        $data = array(
            'body' => view('rak-buku.detail-buku', $data)->render()
            ,'title' => "Detail Buku"
        );

        echo json_encode($data);
    }    

    public function borrow()
    {
        $data['title'] = 'Perpustakaan Gefami';
        $data['route'] = 'books';
		return view('peminjaman.index', $data);
    }

    public function borrowList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "statusPinjaman" => "nullable|string|in:Sedang Dipinjam,Sudah Dikembalikan",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        $validatedData = $validator->validated();

        $query = Loan::with(['user', 'book'])->orderBy('id','desc')->filter($validatedData);

        if (auth()->user()->role_id == 3) { // User
            $query->where('user_id', auth()->id());
        }

        // Filter berdasarkan statusPinjaman
        if ($request->has('statusPinjaman') && $request->statusPinjaman !== null) {
            if ($request->statusPinjaman == 'Sudah Dikembalikan') {
                $query->whereNotNull('returned_at'); 
            } elseif ($request->statusPinjaman == 'Sedang Dipinjam') {
                $query->whereNull('returned_at'); 
            }
        }

        return DataTables::eloquent($query)
        ->editColumn('id', function ($data) {
            $encrypt = new Encrypt();
            return $encrypt->encrypt_decrypt($data->id, 'encrypt');
        })
        ->addColumn('name', function ($data) {
            return '<div class="text-left">'.$data->user->name.'</div>';
        })
        ->addColumn('title', function ($data) {
            return '<div class="text-left">'.$data->book->title.'</div>';
        })
        ->addColumn('borrowed_at', function ($data) {
            return date('d M Y', strtotime($data->borrowed_at));
        })
        ->addColumn('due_date', function ($data) {
            return date('d M Y', strtotime($data->due_date));
        })
        ->addColumn('returned_at', function ($data) {
            return $data->returned_at ? date('d M Y', strtotime($data->returned_at)) : '-';
        })
        ->addColumn('status', function ($data) {
            return $data->returned_at ? 'Sudah Dikembalikan' : 'Sedang Dipinjam';
        })
        ->setRowClass('text-center')
        ->rawColumns(['id', 'name', 'title', 'borrowed_at', 'due_date', 'return_at', 'status'])
        ->make(true);
    }

    public function borrowBook(Request $request)
    {
        $user = auth()->user();

        // Cek apakah user sudah meminjam buku
        if (Loan::where('user_id', $user->id)->whereNull('returned_at')->exists()) {
            return response()->json(['message' => 'Anda harus mengembalikan buku sebelum meminjam yang lain.'], 400);
        }

        $book = Book::findOrFail($request->book_id);

        if (!$book->is_available) {
            return response()->json(['message' => 'Buku tidak tersedia.'], 400);
        }

        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(7),
        ]);

        $book->update(['is_available' => false]);

        return response()->json(['message' => 'Buku berhasil dipinjam.']);
    }

    public function detailBorrow(Request $request)
    {
        $encrypt = new Encrypt();
		$id = $encrypt->encrypt_decrypt($request->id, 'decrypt');
        $model = Loan::where('id', $id)->firstOrFail();
        $data['dataPinjaman'] = $model;

        $data = array(
            'body' => view('peminjaman.kembalikan-buku', $data)->render()
            ,'title' => "Kembalikan Buku Pinjaman"
        );

        echo json_encode($data);
    }

    public function returnBook(Request $request)
    {
        $loan = Loan::where('user_id', auth()->id())->whereNull('returned_at')->firstOrFail();
        $loan->update(['returned_at' => now()]);

        $loan->book->update(['is_available' => true]);

        return response()->json(['message' => 'Buku berhasil dikembalikan.']);
    }

    public function checkOverdue()
    {
        $overdueLoans = Loan::whereNull('returned_at')->where('due_date', '<', now())->get();
        return response()->json($overdueLoans);
    }
}
