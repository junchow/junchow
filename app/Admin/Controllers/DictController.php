<?php

namespace App\Admin\Controllers;

use App\Models\Dict;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;

class DictController extends Controller
{
    use ModelForm;
    const TITLE = '字典';
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        return Admin::content(function(Content $content){
            $content->header( self::TITLE);
            $content->description('description');

            $content->row(function(Row $row){
               $row->column(6,function(Column $column){
                   $column->append($this->tree());
               });
               $row->column(6,function(Column $column){
                   $column->append($this->form()->setAction(admin_url('dicts')));
               });
            });
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

            $content->header( self::TITLE);
            $content->description('description');

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

            $content->header( self::TITLE);
            $content->description('description');

            $content->body($this->form());
        });
    }
    protected function tree(){
        return Dict::tree(function($tree) {
            //brand 为当前行数据数组
            $tree->branch(function ($branch) {
                return '<i class="fa fa-arrow-right"></i> '.$branch['title'] . ' ' . $branch['flag'];
            });
            //模型的查询
            $tree->query(function($model){
                return $model->where('released',1);
            });
        });
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Dict::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->title('名称')->editable();
            $grid->flag('标识')->editable();
            $grid->value('键值')->editable();


            $grid->order('排序')->sortable()->editable();

            $grid->filter(function($filter){
               $filter->useModal();
               $filter->like('title','名称');
               $filter->like('flag','标识');
               $filter->is('value','键值');
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
        return Admin::form(Dict::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('parent_id', trans('admin::lang.parent_id'))->options(Dict::selectOptions());
            $form->text('title',' 名称')->placeholder('中文名称');
            $form->text('flag','标识')->placeholder('英文大写');
            $form->text('value',' 键值')->placeholder('状态值，建议使用数字。');
            $form->number('order','排序');
            $form->radio('released','发布?')->options(['否','是']);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
