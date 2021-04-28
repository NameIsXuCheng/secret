<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Interfaces;
use App\Models\Platform;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class InterfacesController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Interfaces(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name','接口名称');
            $grid->column('platform_id','平台名称')->display(function ($platform_id){
                $user = Platform::all()->toArray();
                if ($user){
                    foreach ($user as $k=>$value){
                        if($value['id'] == $platform_id){
                            return $value['name'];
                        }else{
                            continue;
                        }
                    }
                }else{
                    return $platform_id;
                }
            });
            $grid->column('url','请求地址');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            //过滤查询
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '接口名称');
                $filter->equal('platform_id', '接口名称')
                    ->select($this->getPlatform(['id','name']))->placeholder('平台');
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
        return Show::make($id, new Interfaces(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('name');
            $show->field('platform_id');
            $show->field('url');
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
        return Form::make(new Interfaces(), function (Form $form) {
            $form->display('id');
            $form->text('name')->placeholder('接口名称')->required();

            $form->select('platform_id')->options($this->getPlatform(['id','name']))
                ->placeholder('请选择平台');

            $form->text('url')->placeholder('链接地址')->required();
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    protected function getPlatform($columns=['*']){
        //下拉选择的数据
        $user = Platform::all($columns)->toArray();
        if ($user){
            foreach ($user as $k=>$value){
                $list[$value['id']] = $value['name'];
            }
        }else{
            $list = [];
        }
        return $list;
    }

}
