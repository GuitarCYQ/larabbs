<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        //处理了图片上传的逻辑
        if ($request->avatar){
            //调用ImageUploadHandler的save()方法
            $result = $uploader->save($request->avatar, 'avatars', $user->id);

            //ImageUploadHandler做了判断 如果文件后缀名不对 返回false;
            if ($result){
                $data['avatar'] = $request['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }
}
