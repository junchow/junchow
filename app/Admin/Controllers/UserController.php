<?php

namespace App\Admin\Controllers;

use App\Models\Profile;
use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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

            $content->header('会员');
            $content->description('列表');

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

            $content->header('会员');
            $content->description('编辑');

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

            $content->header('会员');
            $content->description('新增');

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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->id('编号')->sortable();
            $grid->username('账户')->editable();
            $grid->email('邮箱')->editable();
            $grid->phone(' 手机')->editable();
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            //自定义操作按钮
            $grid->actions(function($actions){
                $id = $actions->getKey();
                //判断是否具有会员资料
                $count = Profile::where('user_id',$id)->count();
                if($count==1){
                    $href = "/admin/profiles/{$id}/edit/";
                }else{
                    $href = "/admin/profiles/create/";
                }

                $actions->append(' <a href="'.$href.'"><i class="fa fa-info-circle"></i></a> ');
                $actions->append(' <a href=""><i class="fa fa-lock"></i></a> ');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->display('id', '编号');
            $form->text('username', '账户')->help('长度为6~20位')->rules('required|min:6|max:20');
            //$form->password('password', '密码');
            $form->email('email', '邮箱')->help('邮箱格式如 yourname@host.com');
            $form->mobile('phone', ' 手机');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
