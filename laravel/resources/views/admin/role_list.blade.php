<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/18
 * Time: 10:11
 */
?>
@extends('adminlte::master')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">角色管理</h3>
                </div>
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr>
                                        <th rowspan="1" colspan="1">角色名称</th>
                                        @if(isset($button['role_del']) || isset($button['role_update']))
                                            <th rowspan="1" colspan="1">操作</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $v)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$v->role_name}}</td>
                                            @if(isset($button['role_del']) || isset($button['role_update']))
                                                <td>
                                                    @if(isset($button['role_del']))
                                                        <a href="role/del?role_id={{$v->id}}"><button type="button" class="btn btn-block btn-danger">删除</button></a>
                                                    @endif
                                                    @if(isset($button['role_update']))
                                                        <a href="role/update?role_id={{$v->id}}"><button type="button" class="btn btn-block btn-info">修改</button></a>
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
                                    {{--{{$data->appends(['menu_id'=>$menu_id])->links()}}--}}
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
