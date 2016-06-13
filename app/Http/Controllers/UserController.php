<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
use Cache;

class UserController extends Controller
{
    protected $user;
    
    public function __construct(User $_user)
    {
        $this->user = $_user;
    }
    
	public function myprofile(Request $request)
    {
        $user = $this->user->find($request->user()->user_id);
        $user->password = '';
    	return view('user.myprofile', ['user' => $user]);
    }
    
    public function myprofilesave(Request $request)
    {
//         exit;
        $current_user = $request->user();
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $current_user->user_id  . ',user_id',
            'avatar_img' => 'mimes:jpeg,bmp,png|max:300',
        ];
         
        $validator = Validator::make($request->all(), $rules);
        
        $validator->sometimes(['password'], 'required|confirmed|min:6', function($input){
            return !empty($input->password) ? 1 : 0;
        });
        
        if ($validator->fails()) {
            $this->throwValidationException(
                    $request, $validator
            );
        }
        
        $user_data = $request->all();
        
        if(empty($user_data['password'])){
            unset($user_data['password']);
        } else {
            $user_data['password'] = bcrypt($user_data['password']);
        }
        
        $user = User::find($current_user->user_id);
        $user->update($user_data);
        
        //upload and fix ad images
        $avatar = Input::file('avatar_img');
        if(!empty($avatar)){
            $destination_path = public_path('uf/udata/');
            if($avatar->isValid()){
                @unlink(public_path('uf/udata/') . '100_' . $user->avatar);
                
                $file_name = $user->user_id . '_' .md5(time() + rand(0,9999)) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move($destination_path, $file_name);
                 
                $img = Image::make($destination_path . $file_name);
                $width = $img->width();
                $height = $img->height();
                
                if($width == $height || $width > $height){
                    $img->heighten(100, function ($constraint) {
                        $constraint->upsize();
                    })->save($destination_path . '100_' . $file_name);
                } else {
                    $img->widen(100, function ($constraint) {
                        $constraint->upsize();
                    })->save($destination_path . '100_' . $file_name);
                }
                
                $img->resizeCanvas(100, 100, 'center')->save($destination_path . '100_' . $file_name);
                $user->avatar = $file_name;
                $user->save();
                @unlink($destination_path . $file_name);
            }
        }
        
        //set flash message and return
        session()->flash('message', 'Your profile is updated.');
        return redirect()->back();
    }
}
