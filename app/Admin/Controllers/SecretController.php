<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Secret;
use App\Models\Fee;
use App\Models\Interfaces;
use App\Admin\Renderable\InderfacesTable;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class SecretController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Secret(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('app_key','公钥');
            $grid->column('app_secret','秘钥');
            $grid->column('account','可用金额(￥)')->editable(true);
            $grid->column('interfaces_id','接口ID');
            $grid->column('fee_type','费用类型')->display(function ($fee_type){
                if($this->is_definition == 1){
                    switch ($fee_type){
                        case 1:
                            return '按次收费';
                            break;
                        case 2:
                            return '按月收费';
                            break;
                        default:
                            return '未知';
                    }
                }else{
                    $fee_id = $this->fee_id;
                    $list = Fee::find($fee_id);
                    switch ($list->type){
                        case 1:
                            return '按次收费';
                            break;
                        case 2:
                            return '按月收费';
                            break;
                        default:
                            return '未知';
                    }
                }
            });
            $grid->column('fee','费用金额(￥)')->display(function ($fee_type){
                if($this->is_definition == 1){
                    return $this->fee;
                }else{
                    $fee_id = $this->fee_id;
                    $list = Fee::find($fee_id);
                    return $list->money;
                }
            });

//            $grid->column('fee_id','费用ID');

            $grid->column('created_at','创建时间')->sortable();
//            $grid->column('updated_at');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id','ID');
                $filter->equal('is_definition','是否自定义');
                $filter->equal('fee_id','费用ID');
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
        return Show::make($id, new Secret(), function (Show $show) {
            $show->field('interfaces_id');
            $show->field('is_definition');
            $show->field('fee_type');
            $show->field('fee');
            $show->field('fee_id');
            $show->row(function (Show\Row $row){
                $row->width('6')->field('id');
                $row->width('6')->field('interfaces_id','接口')->value('111');
            });

            $show->row(function (Show\Row $row){
                $row->width('6')->field('app_key');
                $row->width('6')->field('app_secret');
            });


            $show->field('created_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Secret(), function (Form $form) {
            $form->display('id');
            $form->text('app_key','公钥')->required();
            $form->text('app_secret','秘钥')->required();

//            $form->currency('account','可用余额')->symbol('￥')->display(0);
            $form->currency('account','可用金额')->symbol('￥');

            $form->multipleSelectTable('interfaces_id','接口')
                ->placeholder('接口')
                ->title('接口列表')
                ->from(InderfacesTable::make(['id' => $form->getKey()])) // 设置渲染类实例，并传递自定义参数
                ->model(Interfaces::class, 'id', 'name')// 设置编辑数据显示
                ->saving(function ($v){
                    return json_encode($v,JSON_UNESCAPED_UNICODE);
                })->required();

            $form->radio('is_definition', '自定义费用')
                ->options([
                    0 => '关闭',
                    1 => '开启',
                ])->default(0)
                ->when(0, function (Form $form) {
                    $form->select('fee_id','费用ID')->options($this->getFee())->default(1)->required();
                })->when(1, function (Form $form) {
                    $form->select('fee_type','费用类型')->options(['1'=>'按次收费','2'=>'按月收费'])->default(1)->required();
                    $form->currency('fee','收费金额')->symbol('￥')->default(0)->required();
                })->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    protected function getFee($columns=['*']){
        //下拉选择的数据
        $user = Fee::all($columns)->toArray();
        if ($user){
            foreach ($user as $k=>$value){
                $list[$value['id']] = $value['title'];
            }
        }else{
            $list = [];
        }
        return $list;
    }
}
