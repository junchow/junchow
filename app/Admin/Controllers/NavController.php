<?php

namespace App\Admin\Controllers;

use App\Models\Nav;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;

class NavController extends Controller
{
    use ModelForm;
    const TITLE = '导航';
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header( self::TITLE);
            $content->description('nav');

//            $content->body($this->grid());
            $content->row(function(Row $row){
               $row->column(4, function(Column $column){
                   $column->append($this->tree());
               });
                $row->column(8, function(Column $column){
                    $column->append($this->form()->setAction('navs'));
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

            $content->header( self::TITLE);
            $content->description('create');

            $content->body($this->form());
        });
    }

    protected function tree(){
        return Nav::tree(function($tree){
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
        return Admin::grid(Nav::class, function (Grid $grid) {

            $grid->column('id',trans('lang.id'))->sortable();
            $grid->column('title',trans('lang.title'))->editable();
            $grid->column('url', trans('lang.url'))->editable();
            $grid->column('order',trans('lang.order'))->editable()->sortable();

            $grid->filter(function($filter){
               $filter->useModal();

               $filter->like('title',trans('lang.title'));
               $filter->like('url', trans('lang.url'));
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
        return Admin::form(Nav::class, function (Form $form) {

            $form->display('id',trans('lang.id'));

            $form->select('parent_id',trans('lang.parent_id'))->options(Nav::selectOptions());
            $form->text('title',trans('lang.title'));
            $form->url('url', trans('lang.url'));
            $form->number('order',trans('lang.order'));

            $form->display('created_at', trans('lang.created_at'));
            $form->display('updated_at', trans('lang.updated_at'));
        });
    }
}
