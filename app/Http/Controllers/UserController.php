<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Helpers\Encrypt;
use DataTables;
use Carbon\Carbon;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'Users';
        $data['route'] = 'users';
        $data['users'] = User::all();
		return view('user.index', $data);
    }

    public function getUsers(Request $request)
    {
        try {
            $users = User::with(['role']);
    
            return DataTables::eloquent($users)
                ->editColumn('id', function ($data) {
                    $encrypt = new Encrypt();
                    return $encrypt->encrypt_decrypt($data->id, 'encrypt');
                })
                ->addColumn('name', function ($data) {
                    return '<div class="text-left">'.$data->name.'</div>';
                })
                ->addColumn('email', function ($data) {
                    return '<div class="text-left">'.$data->email.'</div>';
                })
                ->addColumn('role_name', function ($data) {
                    return '<div class="text-left">'.($data->role->role_name ?? 'Tidak Ada Role').'</div>';
                })
                ->setRowClass('text-center')
                ->rawColumns(['id', 'name', 'email', 'role_name'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat mengambil data pengguna.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function add()
    {
        $data['model'] = new User();

        return view('user.add', $data);
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/",
            "role" => "required|int|exists:roles,id",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors,
            ], 400);            
        }

        $data = User::store($validator->validated());
        return response()->json($data, 201);
    }

    public function editUser(Request $request)
    {
        $encrypt = new Encrypt();
		$id = $encrypt->encrypt_decrypt($request->id, 'decrypt');
        $model= User::where('id', $id)->firstOrFail();
        $data['model'] = $model;

        $data = array(
            'body' => view('user.add', $data)->render()
            ,'title' => "Edit User : ".$model->name
        );

        echo json_encode($data);
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request->idUser);
        $validator = Validator::make($request->all(), [
            "nama" => "required|string|max:255",
            "email" => [
                "nullable",
                "email",
                Rule::unique('users', 'email')->ignore($user->id), // Ignore email user saat ini
            ],
            "password" => "nullable|string|min:8|regex:/^(?=.*[A-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/",
            "role" => "required|int|exists:roles,id",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors,
            ], 400);            
        }
		
        $data = array(
            'name' => $request->nama,
            'role_id' => $request->role,
        );

        // Update email hanya jika berbeda
        if ($request->filled('email') && $request->email !== $user->email) {
            $data['email'] = $request->email;
        }
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);		
		
    }

    public function destroyUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:users,id,deleted_at,NULL',
        ]);

        $result = User::deleteUser($request->id);

        return response()->json([
            'message' => $result['message'],
        ], 200);
    }
}
