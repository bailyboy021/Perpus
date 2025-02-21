<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Helpers\Encrypt;
use App\Helpers\Mimetype;
use DataTables;
use Carbon\Carbon;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $data['title'] = 'Buku';
        $data['route'] = 'books';
        $data['buku'] = Book::all();
		return view('buku.index', $data);
    }

    public function getBooks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "is_available" => "nullable|integer",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        $validatedData = $validator->validated();

        return DataTables::eloquent(Book::with(['user'])
                            ->filter($validatedData))
        ->editColumn('id', function ($data) {
            $encrypt = new Encrypt();
            return $encrypt->encrypt_decrypt($data->id, 'encrypt');
        })
        ->addColumn('title', function ($data) {
            return '<div class="text-left">'.$data->title.'</div>';
        })
        ->addColumn('author', function ($data) {
            return '<div class="text-left">'.$data->author.'</div>';
        })
        ->addColumn('is_available', function ($data) {
            return $data->is_available=='1' ? 'Tersedia' : 'Sedang Dipinjam';
        })
        ->setRowClass('text-center')
        ->rawColumns(['id', 'title', 'author', 'is_available'])
        ->make(true);
    }

    public function add()
    {
        $data['model'] = new Book();

        return view('buku.add', $data);
    }

    public function storeBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "year" => "required|string|max:4", 
            "genre" => "required|string|max:255",
            "synopsis" => "required|string",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors,
            ], 400);            
        }

        if($request->hasFile('cover')) {
            $file = $request->file('cover');
            $content = file_get_contents($file->getRealPath());
            $filename = $file->getClientOriginalName();

            if (!MimeType::whiteList($filename) || !MimeType::whiteListBytes($content, $filename)) {
                return response()->json(['error' => 'File tidak valid atau tidak diizinkan.'], 415);
            }
            
            $filename = time() . "_" . str_replace(" ", "_", $filename);
            $file->move(public_path().'/images/cover/', $filename);
        }

        $data = array(
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year,
            'cover' => $filename ?? 'no-images.png',
            'genre' => $request->genre,
            'synopsis' => $request->synopsis,
            'is_available' => 1,
        );       

        Book::create($data);
        return response()->json($data, 201);
    }

    public function editBook(Request $request)
    {
        $encrypt = new Encrypt();
		$id = $encrypt->encrypt_decrypt($request->id, 'decrypt');
        $model= Book::where('id', $id)->firstOrFail();
        $data['model'] = $model;

        $data = array(
            'body' => view('buku.add', $data)->render()
            ,'title' => "Edit Buku : ".$model->title
        );

        echo json_encode($data);
    }

    public function updateBook(Request $request)
    {
        $buku = Book::find($request->idBuku);
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "year" => "required|string|max:4", 
            "genre" => "required|string|max:255",
            "synopsis" => "required|string",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors,
            ], 400);            
        }
		
        $data = array(
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year,
            'cover' => $filename ?? 'no-images.png',
            'genre' => $request->genre,
            'synopsis' => $request->synopsis,
        );

        // Cek apakah ada file cover yang diunggah
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $content = file_get_contents($file->getRealPath());
            $filename = $file->getClientOriginalName();

            if (!MimeType::whiteList($filename) || !MimeType::whiteListBytes($content, $filename)) {
                return response()->json(['error' => 'File tidak valid atau tidak diizinkan.'], 415);
            }

            // Buat nama file unik agar tidak bentrok
            $filename = time() . "_" . str_replace(" ", "_", $filename);

            // Hapus cover lama jika bukan default 'no-images.png'
            if ($buku->cover && $buku->cover !== 'no-images.png') {
                $oldCoverPath = public_path('images/cover/' . $buku->cover);
                if (file_exists($oldCoverPath)) {
                    unlink($oldCoverPath);
                }
            }

            // Simpan cover baru
            $file->move(public_path('images/cover/'), $filename);
            $data['cover'] = $filename;
        } else {
            // Jika tidak ada cover baru, gunakan cover lama
            $data['cover'] = $buku->cover;
        }

        $buku->update($data);
    }

    public function destroyBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:books,id,deleted_at,NULL',
        ]);

        $buku = Book::find($request->id);
        $oldCoverPath = public_path('images/cover/' . $buku->cover);
        if (file_exists($oldCoverPath)) {
            unlink($oldCoverPath);
        }

        $result = Book::deleteBook($request->id);

        return response()->json([
            'message' => $result['message'],
        ], 200);
    }
}
