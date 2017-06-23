<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Post;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PostController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('lang.post'));
            $content->description('post');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header(trans('lang.post'));
            $content->description('edit');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('lang.post'));
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Post::class, function (Grid $grid) {
            $grid->column('id',trans('lang.id'))->sortable();
            $grid->column('title',trans('lang.title'))->display(function($str){
                return str_limit($str,30, '....');
            });
            $grid->column('user.username',trans('lang.username'));
            $grid->column('category.title', trans('lang.category'));
            $grid->column('views', trans('lang.views'));
            $grid->column('comments', trans('lang.comments'));
            $grid->column('release_at', trans('lang.release_at'));

            //查询过滤器
            $grid->filter(function($filter){
                $filter->useModal();
                $filter->like('title',trans('lang.title'));
                $filter->is('user_id',trans('lang.username'))->select(User::all()->pluck('username','id'));
                $filter->is('category_id',trans('lang.category'))->select(Category::all()->pluck('title','id'));
                $filter->between('release_at',trans('lang.release_at'))->datetime();
            });
            //每页显示条数
            $grid->paginate(50);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Post::class, function (Form $form) {
            $form->display('id', trans('lang.id'));
            $form->text('title', trans('lang.title'));
            $form->image('thumb', trans('lang.thumb'))->uniqueName();
            $form->editor('content', trans('lang.content'));
            //$form->display('markdown', ' MarkDown');
            $form->text('flag', trans('lang.flag'));
            $form->select('user_id', trans('lang.username'))->options(function($id){
                if($id){
                    $model = User::find($id);
                    return [$model->id => $model->username];
                }else{
                    $models = User::all();
                    foreach($models as $model){
                        $return[$model->id] = $model->username;
                    }
                    return $return;
                }
            });
            $form->select('category_id', trans('lang.category'))->options(function($id){
                if($id){
                    $model = Category::find($id);
                    return [$model->id => $model->name];
                }else{
                    $models = Category::all();
                    foreach($models as $model){
                        $return[$model->id] = $model->name;
                    }
                    return $return;
                }
            });
            $form->number('views', trans('lang.views'))->default(100);
            $form->number('comments', trans('lang.comments'))->default(100);
            $form->datetime('release_at', trans('lang.release_at'));
            $form->display('created_at', trans('lang.created_at'));
            $form->display('updated_at', trans('lang.updated_at'));
        });
    }
}
