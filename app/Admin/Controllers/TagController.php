<?php

namespace App\Admin\Controllers;

use App\Models\Tag;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TagController extends Controller
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

            $content->header(trans('lang.tag'));
            $content->description('tag');

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

            $content->header(trans('lang.tag'));
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

            $content->header(trans('lang.tag'));
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
        return Admin::grid(Tag::class, function (Grid $grid) {
            //数据模型表格
            $grid->column('id',trans('lang.id'))->sortable();
            $grid->column('title',trans('lang.title'))->editable();
            $grid->column('flag',trans('lang.flag'))->editable();
            $grid->column('count',trans('lang.count'))->sortable();

            $grid->filter(function($filter){
                $filter->useModal();
                $filter->like('title',trans('lang.title'));
                $filter->like('flag',trans('lang.flag'));
                $filter->is('count',trans('lang.count'));
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
        return Admin::form(Tag::class, function (Form $form) {

            $form->display('id', trans('lang.id'));

            $form->text('title', trans('lang.title'));
            $form->text('flag', trans('lang.flag'));
            $form->display('count', trans('lang.count'));

            $form->display('created_at', trans('lang.created_at'));
            $form->display('updated_at', trans('lang.updated_at'));
        });
    }
}
