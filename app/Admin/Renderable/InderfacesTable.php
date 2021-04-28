<?php
/**
 * Created by PhpStorm.
 * User: matao
 * Date: 2021/3/25
 * Time: 11:13
 */
namespace App\Admin\Renderable;

use App\Models\Interfaces;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class InderfacesTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;

        return Grid::make(new Interfaces(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('created_at');

            $grid->quickSearch(['id', 'name']);

            $grid->paginate(10);
            $grid->disableActions();

//            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
//                $filter->like('name','接口名称');
//            });
        });
    }
}