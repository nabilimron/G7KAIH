@csrf
<div class="fld"><label>Nama lengkap</label>
 <label class="ctl"><input name="name" value="{{ old('name', $user->name ?? '') }}" maxlength="100"></label>
 @error('name') <small style="color:#e34557">{{ $message }}</small> @enderror</div>
 
<div class="fld"><label>Username</label>
 <label class="ctl"><input name="username" value="{{ old('username', $user->username ?? '') }}" maxlength="50" autocomplete="off"></label>
 @error('username') <small style="color:#e34557">{{ $message }}</small> @enderror</div>
 
<div class="fld"><label>Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}</label>
 <label class="ctl"><input type="password" name="password" autocomplete="new-password"></label>
 @error('password') <small style="color:#e34557">{{ $message }}</small> @enderror</div>
 
<div class="fld"><label>Peran</label>
 <label class="ctl"><select name="role">
  <option value="guru_wali" @selected(old('role', $user->role ?? '') === 'guru_wali')>Guru Wali</option>
  <option value="siswa" @selected(old('role', $user->role ?? '') === 'siswa')>Siswa</option>
 </select></label>
 @error('role') <small style="color:#e34557">{{ $message }}</small> @enderror</div>
 
<div class="fld"><label>Status</label>
 <label class="ctl"><select name="status">
  <option value="aktif" @selected(old('status', $user->status ?? 'aktif') === 'aktif')>Aktif</option>
  <option value="nonaktif" @selected(old('status', $user->status ?? '') === 'nonaktif')>Nonaktif</option>
 </select></label>
 @error('status') <small style="color:#e34557">{{ $message }}</small> @enderror</div>
 
<button class="btn" type="submit">Simpan</button>
<a href="{{ route('akun.index') }}">Batal</a>
