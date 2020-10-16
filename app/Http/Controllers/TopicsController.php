<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
	    //使用Eloquent的预加载功能 with() 提前加载了我们后面要用到的关联属性user和category 并做了缓存 因此后面不必产生多余的SQL查询
		$topics = $topic->withOrder($request->order)
                        ->with('user','category')
                        ->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
        //URL 矫正 当URL带有slug时 让之后的子链接都带有slug
        if ( ! empty($topic->slug) && $topic->slug != $request->slug){
            //301永远重定向到正确的URL上
        return redirect($topic->link(),301);
        }

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
	    //fill方法会将传参的键值数组填充到模型的属性中，如以上数组，$topic->title的值是标题；
	    $topic->fill($request->all());
	    $topic->user_id = Auth::id();
	    $topic->save();

        session()->flash('success','添加成功');
		return redirect()->route('topics.show', $topic->id);
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		session()->flash('success','修改成功');
		return redirect()->route('topics.show', $topic->id);
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		session()->flash('success','删除成功！');
		return redirect()->route('topics.index');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }


}