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
                    <h3 class="box-title">属性列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                @if(isset($button['attrval_add']))
                                    <a href="{{url('admin/attrval/add')}}" class="btn btn-primary btn-sm" role="button">属性值添加</a>
                                @endif
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">属性名称</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">属性值名称</th>
                                        @if(isset($button['attrval_del']) || isset($button['attrval_update']))
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">操作</th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $v)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$v->name}}</td>
                                            <td class="sorting_1">{{$v->val_name}}</td>
                                        @if(isset($button['attrval_del']) || isset($button['attrval_update']))
                                                <td>
                                                    @if(isset($button['attrval_del']))
                                                    <a href="attrval/del?id={{$v->id}}"><button type="button" class="btn btn-primary btn-danger btn-sm">删除</button></a>
                                                    @endif
                                                    @if(isset($button['attrval_update']))
                                                        <a href="attrval/update?id={{$v->id}}"><button type="button" class="btn btn-primary btn-sm">修改</button></a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                 </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
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
