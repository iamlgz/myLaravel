<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/17
 * Time: 11:16
 */
?>
@extends('adminlte::master')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Hover Data Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">商品名称</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">商品单价</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">商品描述</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">商品类型</th>
                                        @if(isset($button['goods_del']) || isset($button['goods_update']))
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">操作</th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $v)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$v->goods_name}}</td>
                                            <td>{{$v->goods_price}}</td>
                                            <td>{{$v->goods_ms}}</td>
                                            <td>{{$v->t_name}}</td>
                                            @if(isset($button['goods_del']) || isset($button['goods_update']))
                                                <td>
                                                    @if(isset($button['goods_del']))
                                                    <a href="goods/del?goods_id={{$v->goods_id}}"><button type="button" class="btn btn-block btn-danger">删除</button></a>
                                                    @endif
                                                    @if(isset($button['goods_update']))
                                                        <a href="goods/update?goods_id={{$v->goods_id}}"><button type="button" class="btn btn-block btn-info">修改</button></a>
                                                    @endif
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                 </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">商品名称</th>
                                        <th rowspan="1" colspan="1">商品单价</th>
                                        <th rowspan="1" colspan="1">商品描述</th>
                                        <th rowspan="1" colspan="1">商品类型</th>
                                        @if(isset($button['goods_del']) || isset($button['goods_update']))<th rowspan="1" colspan="1">操作</th>@endif

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                            </div>

                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {{$data->appends(['menu_id'=>$menu_id])->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
