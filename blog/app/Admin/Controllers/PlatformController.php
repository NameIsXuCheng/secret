<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Platform;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PlatformController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Platform(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('domain');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Platform(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('name');
            $show->field('domain');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Platform(), function (Form $form) {
            $form->display('id');
            $form->text('name')->placeholder('平台名称')->required();
            $form->url('domain')->placeholder('域名地址')->required();
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
