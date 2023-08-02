<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConceptorController extends Controller
{
    public function index()
    {
        $title = 'Konseptor';
        $userRole = Auth::user()->role;

        $conceptors = User::where('role', '!=', 'Super Admin');

        if ($userRole == 'Admin Pkn') {
            $conceptors->where('role', 'Admin Pkn');
        } elseif ($userRole == 'Admin Penilai') {
            $conceptors->where('role', 'Admin Penilai');
        }

        $conceptors = $conceptors->orderBy('role')->orderBy('name')->get();

        return view('konseptor.index', compact('title', 'conceptors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'whatsapp_number' => 'required',
            'password' => 'required|min:8',
            'role' => 'nullable'
        ]);

        $data['password'] = Hash::make($request->password);

        $loggedInUserRole = Auth::user()->role;
        $allowedRoles = ['Admin Pkn', 'Admin Penilai'];

        if (in_array($loggedInUserRole, $allowedRoles)) {
            $data['role'] = $loggedInUserRole;
        } else {
            $data['role'] = $request->role;
        }

        User::create($data);

        $message = "$request->name berhasil ditambahkan menjadi " . $data['role'];
        return back()->with('success', $message);
    }

    public function getConceptor($id)
    {
        $conceptor = User::find($id);
        return response()->json($conceptor);
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'whatsapp_number' => 'required',
            'role' => 'nullable'
        ]);

        $loggedInUserRole = Auth::user()->role;
        $allowedRoles = ['Admin Pkn', 'Admin Penilai'];

        if (in_array($loggedInUserRole, $allowedRoles)) {
            $data['role'] = $loggedInUserRole;
        } else {
            $data['role'] = $request->role;
        }

        $conceptor = User::findOrFail($id);
        $conceptor->update($data);

        return back()->with('success', "Data berhasil diedit");
    }

    public function delete($id)
    {
        $conceptor = User::findorFail($id);
        $conceptor->delete();

        return back()->with('success', "Data berhasil dihapus");
    }
}
