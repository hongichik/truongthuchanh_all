<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Hiển thị danh sách liên hệ
     */
    public function index(Request $request)
    {
        $query = Contact::with('repliedByAdmin')->orderBy('created_at', 'desc');

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);
        
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Hiển thị chi tiết liên hệ
     */
    public function show(Contact $contact)
    {
        $contact->load('repliedByAdmin');
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Trả lời liên hệ
     */
    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
            'status' => 'required|in:replied,resolved'
        ], [
            'admin_reply.required' => 'Vui lòng nhập nội dung trả lời',
            'admin_reply.max' => 'Nội dung trả lời không được quá 2000 ký tự',
            'status.required' => 'Vui lòng chọn trạng thái',
        ]);

        try {
            $contact->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'replied_at' => now(),
                'replied_by' => Auth::guard('admin')->id(),
            ]);

            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Trả lời liên hệ thành công!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi trả lời liên hệ.')
                ->withInput();
        }
    }

    /**
     * Cập nhật trạng thái liên hệ
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:pending,replied,resolved'
        ]);

        $contact->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Xóa liên hệ
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return redirect()->route('admin.contacts.index')
                ->with('success', 'Xóa liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa liên hệ.');
        }
    }

    /**
     * Lấy thống kê liên hệ
     */
    public function getStats()
    {
        return [
            'total' => Contact::count(),
            'pending' => Contact::where('status', 'pending')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'resolved' => Contact::where('status', 'resolved')->count(),
        ];
    }
}
