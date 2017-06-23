<?php

namespace App\Admin\Controllers;

use App\Models\Link;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class LinkController extends Controller
{
    use ModelForm;
    const TITLE = '链接';
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header(self::TITLE);
            $content->description('link');

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

            $content->header(self::TITLE);
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

            $content->header(self::TITLE);
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
        return Admin::grid(Link::class, function (Grid $grid) {
            $grid->column('id','编号')->sortable();
            $grid->column('logo','LOGO')->image('',40);
            $grid->column('title','名称')->editable();
            $grid->column('url','网址')->editable();
            $grid->column('ip','IP')->editable();
            $grid->column('released','发布?')->display(function($val){
                return $val ? '是' : '否';
            });
            $grid->column('remark','备注')->display(function($val){
                return str_limit($val,30,'...');
            })->editable('textarea');
            $grid->column('order','排序')->sortable()->editable();

            //自定义查询过滤器
            $grid->filter(function($filter){
               //使用模态
                $filter->useModal();
                //查询字段
                $filter->like('title','名称');
                $filter->like('url','网址');
                $filter->like('ip','IP');
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
        return Admin::form(Link::class, function (Form $form) {

            $form->display('id', '编号');

            $form->text('title', '名称');
            $form->url('url', '网址');
            $form->image('logo', 'LOGO')->uniqueName();
            $form->ip('ip', 'IP');
            $form->textarea('remark', '备注');
            $form->radio('released', ' 发布?')->options(['否','是']);
            $form->number('order','排序')->default(0);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
