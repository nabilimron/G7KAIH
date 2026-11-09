<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AkunService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AkunController extends Controller{

    private const ROLE_AKUN = ['guru_wali', 'siswa'];
    private const STATUS    = ['aktif', 'nonaktif'];

    public function __construct(private AkunService $service){
        logger('AkunController::__construct dijalankan');
    }

    public function index(Request $request){
        $role = $request->query('role', 'guru_wali');
        abort_unless(in_array($role, self::ROLE_AKUN, true), 404);

        $cari   = $request->string('q')->trim()->toString();
        $status = $request->query('status');

        $users = User::where('role', $role)
            ->when($cari !== '', function ($q) use ($cari) {
                $cari = addcslashes($cari, '%_\\');
                $q->where(fn ($w) => $w->where('name', 'like', "%$cari%")
                                       ->orWhere('username', 'like', "%$cari%"));
            })
            ->when(in_array($status, self::STATUS, true), fn ($q) => $q->where('status', $status))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.akun.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.akun.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:users,username'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'role'     => ['required', Rule::in(self::ROLE_AKUN)],
            'status'   => ['required', Rule::in(self::STATUS)],
        ]);

        $this->service->buat($data);

        return redirect()->route('akun.index', ['role' => $data['role']])
            ->with('ok', 'Akun berhasil ditambahkan');
    }

    // UPDATE
    public function edit(User $akun)
    {
        $this->pastikanBolehDikelola($akun);
        return view('admin.akun.edit', ['user' => $akun]);
    }

    public function update(Request $request, User $akun)
    {
        $this->pastikanBolehDikelola($akun);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/',
                           Rule::unique('users', 'username')->ignore($akun->id)],
            'password' => ['nullable', Password::min(8)->letters()->numbers()],
            'role'     => ['required', Rule::in(self::ROLE_AKUN)],
            'status'   => ['required', Rule::in(self::STATUS)],
        ]);

        if (! $request->filled('password')){
            unset($data['password']);
        }

        $akun->update($data);

        return redirect()->route('akun.index', ['role' => $akun->role])
            ->with('ok', 'Akun berhasil diperbarui');
    }

    // DELETE
    public function destroy(Request $request, User $akun)
    {
        $this->pastikanBolehDikelola($akun);
        abort_if($akun->id === $request->user()?->id, 403, 'Tidak boleh menghapus akun sendiri.');

        $role = $akun->role;
        $akun->delete();

        return redirect()->route('akun.index', ['role' => $role])
            ->with('ok', 'Akun berhasil dihapus');
    }

    private function pastikanBolehDikelola(User $akun): void
    {
        abort_unless(in_array($akun->role, self::ROLE_AKUN, true), 403);
    }
}