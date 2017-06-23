<?php

namespace App\Admin\Controllers;

use \App\Models\Profile;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProfileController extends Controller
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

            $content->header('资料');
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

            $content->header('资料');
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

            $content->header('资料');
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
        return Admin::grid(Profile::class, function (Grid $grid) {
            $grid->id('编号')->sortable();
            $grid->column('user.username','账户');
            $grid->nickname('昵称');
            $grid->realname('真实姓名');
            $grid->gender('性别');
            $grid->age('年龄');
            $grid->birth('出生年月');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Profile::class, function (Form $form) {
            $form->display('id', '编号');


            $form->select('user_id','账户')->options(function($id){
                $return = [];
                $models = User::all();
                foreach($models as $model){
                    $return[$model->id] = $model->username;
                }
                return $return;
            });

            $form->divider();
            $form->text('realname','真实姓名');
            $form->date('birth',' 出生年月');
            $form->number('age','年龄');
            $form->radio('gender','性别')->options(['女','男'])->default(0);
            $form->divider();
            $form->text('nickname','昵称');
            $form->image('avatar',' 头像')->uniqueName();
            $form->divider();
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
