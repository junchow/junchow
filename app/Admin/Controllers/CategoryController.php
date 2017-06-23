<?php

namespace App\Admin\Controllers;

use App\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;

class CategoryController extends Controller
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

            $content->header(trans('lang.category'));
            $content->description('category');

            $content->row(function(Row $row){
               $row->column(4,function(Column $column){
                   return $column->append($this->tree());
               });
               $row->column(8, function(Column $column){
                   return $column->append($this->form()->setAction('categories'));
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

            $content->header(trans('lang.category'));
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

            $content->header(trans('lang.category'));
            $content->description('create');

            $content->body($this->form());
        });
    }

    protected function tree(){
        return Category::tree(function($tree){
           $tree->branch(function($branch){
               return $branch['title'];
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
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->column('id',trans('lang.id'))->sortable();
            $grid->column('title',trans('lang.title'));
            $grid->column('flag',trans('lang.flag'));
            $grid->column('remark',trans('lang.remark'));
            $grid->column('order',trans('lang.order'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
            $form->display('id', trans('lang.id'));
            $form->select('parent_id', trans('lang.parent_id'))->options(Category::selectOptions());
            $form->text('title', trans('lang.title'));
            $form->text('flag', trans('lang.flag'));
            $form->textarea('remark', trans('lang.remark'));
            $form->number('order', trans('lang.order'));
            $form->display('created_at', trans('lang.created_at'));
            $form->display('updated_at', trans('lang.updated_at'));
        });
    }
}
