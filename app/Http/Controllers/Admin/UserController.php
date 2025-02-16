<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm
        if ($request->filled('keyword')) {
            $searchBy = $request->get('search_by', 'all');
            $keyword = $request->get('keyword');

            if ($searchBy === 'all') {
                $query->where(function ($q) use ($keyword) {
                    $q->where('id', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('role', 'like', "%{$keyword}%");
                });
            } else {
                $query->where($searchBy, 'like', "%{$keyword}%");
            }
        }

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'id_desc');
        switch ($sortBy) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'id_desc':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        // Kiểm tra nếu chọn "Tất cả", lấy toàn bộ dữ liệu
        if ($perPage === 'all') {
            $users = $query->get(); // Lấy tất cả người dùng
        } else {
            $users = $query->paginate((int) $perPage)->appends($request->all());
        }

        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = ['admin' => 'Admin', 'user' => 'User', 'artist' => 'Artist'];
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'user', 'artist'])],
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return redirect()->route('users.index')
                ->with('success', 'Người dùng đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi tạo người dùng!')
                ->withInput();
        }
    }

    public function edit(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Không thể chỉnh sửa tài khoản của chính mình ở đây!');
        }

        $roles = ['admin' => 'Admin', 'user' => 'User', 'artist' => 'Artist'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Không thể cập nhật tài khoản của chính mình ở đây!');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'user', 'artist'])],
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $user->update($updateData);

            return redirect()->route('users.index')
                ->with('success', 'Người dùng đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng!')
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        try {
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', 'Người dùng đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa người dùng!');
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }
}
