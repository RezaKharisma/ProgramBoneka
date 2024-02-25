<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        return view('settings.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'alamat' => ['nullable'],
            'no_telp' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return Redirect::route('profile.index')->with('danger', 'Periksa form kembali!')->withErrors($validator)->withInput();
        }else{
            $request->user()->fill($validator->validated());
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            $request->user()->save();
            return Redirect::route('profile.index')->with('success', 'Profil berhasil terupdate!');
        }
    }

    /**
     * Update the user's picture
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        if ($request->foto) {
            $validator = Validator::make($request->all(), [
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return Redirect::route('profile.index')->with('danger', 'Periksa form kembali!')->withErrors($validator)->withInput();
            }else{
                $this->checkInStorage($request->user()->foto);
                $imageName = time().'.'.$request->foto->extension();
                $request->foto->move(public_path('profile_photo'), $imageName);

                $request->user()->update([
                    'foto' => $imageName
                ]);
            }
            return Redirect::route('profile.index')->with('success', 'Foto berhasil terupdate!');
        }
        return redirect()->back();
    }

    public function checkInStorage($imgName){
        $path = 'profile_photo/'.$imgName;
        if($imgName == 'default.png'){
            return;
        }

        if(file_exists(public_path($path))){
            unlink(public_path($path));
        }

        return;
    }
}
