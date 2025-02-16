<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::query();

        // Lấy dữ liệu từ request
        $keyword = $request->get('keyword');
        $searchBy = $request->get('search_by', 'all');
        $sortBy = $request->get('sort_by', 'id_desc');
        $perPage = $request->get('per_page', 10);

        // Xử lý tìm kiếm
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($keyword, $searchBy) {
                if ($searchBy === 'all') {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('bio', 'like', "%{$keyword}%");
                } elseif ($searchBy === 'id') {
                    if (is_numeric($keyword)) {
                        $q->where('id', intval($keyword));
                    }
                } else {
                    $q->where($searchBy, 'like', "%{$keyword}%");
                }
            });
        }

        // Xử lý sắp xếp
        switch ($sortBy) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $query->orderBy('id', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Xử lý phân trang
        if ($perPage === 'all') {
            $artists = $query->get();
        } else {
            $artists = $query->paginate((int) $perPage)->appends($request->all());
        }

        return view('admin.artists.index', compact('artists'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $artists = Artist::where('name', 'like', "%{$search}%")
            ->orWhere('bio', 'like', "%{$search}%")
            ->paginate(10);

        return view('artists.index', compact('artists'));
    }

    // Các phương thức khác giữ nguyên...
    public function create()
    {
        return view('artists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        try {
            Artist::create($request->all());
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được thêm thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi thêm nghệ sĩ!')->withInput();
        }
    }

    public function show(Artist $artist)
    {
        return view('artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        try {
            $artist->update($request->all());
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật nghệ sĩ!')->withInput();
        }
    }

    public function destroy(Artist $artist)
    {
        try {
            $artist->delete();
            return redirect()->route('artists.index')->with('success', 'Nghệ sĩ đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa nghệ sĩ!');
        }
    }
}
