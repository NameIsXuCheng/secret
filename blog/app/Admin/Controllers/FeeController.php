<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Fee;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FeeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Fee(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title','标题');
            $grid->column('type','收费类型')->display(function ($type){
                switch ($type){
                    case 1:
                        return '按次收费';
                        break;
                    case 2:
                        return '按月收费';
                        break;
                    default:
                        return '未知类型';
                }
            });;
            $grid->column('money','金额(￥)');
            $grid->column('created_at','创建时间');
//            $grid->column('updated_at','更新时间')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('type','收费类型')
                    ->select(['1'=>'按次收费','2'=>'按月收费'])->placeholder('收费类型');
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
        return Show::make($id, new Fee(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('title','标题');
            $show->field('type','收费类型');
            $show->field('money','收费金额');
            $show->field('created_at','创建时间');
//            $show->field('updated_at','标题');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Fee(), function (Form $form) {
            $form->display('id');
            $form->text('title','标题')->required();
            $form->select('type','收费类型')->options(['1'=>'按次收费','2'=>'按月收费'])->required();
            $form->currency('money','收费金额')->symbol('￥')->required();
        
            $form->display('created_at','创建时间');
//            $form->display('updated_at');
        });
    }
}
