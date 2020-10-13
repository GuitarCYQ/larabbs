<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    //只允许以下后缀名的图片文件上传
    protected $allowed_ext = ["png","jpg","gif","jpeg"];

    public function save($file, $folder, $file_prefix)
    {
        //文件夹命名
        //构建存储的文件夹规则 例如：uploads/images/avatars/202010/21/
        //文件夹切割能让查找效率更高。
        $folder_name = "uploads/images/$folder/" . date('Ym/d',time());

        //存储地址
        //文件具体存储物理路径， 'public_path()' 获取的是'public'文件夹的物理路径。
        //值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/202010/13/
        $upload_path = public_path() . '/' . $folder_name;

        //获取文件的后缀名，因图片从剪贴板里黏贴是后缀名为空，所以此处确保后缀名一直在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        //拼接文件名，为前缀是为了增加辨析度，前缀可以是相关数据模型的ID
        //值如：1_12323423432_8bgdBSKPk.png
        $filename = $file_prefix . '_' . time() . "_" . Str::random(10) . '.' . $extension;

        //如果上传的不是图片将终止操作
        if ( ! in_array($extension, $this->allowed_ext)){
            return false;
        }

        //将图片移动到我们的目标存储路径中
        $file->move($upload_path,$filename);

        return [
                'path'  =>  config('app.url') . "/$folder_name/$filename"
            ];

    }

}
