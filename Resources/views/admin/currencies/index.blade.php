@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('currency::currencies.title.currency rate') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('currency::currencies.title.currency rate') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            {{--<div class="row">--}}
                {{--<div class="btn-group pull-right" style="margin: 0 15px 15px 0;">--}}
                    {{--<a href="{{ route('admin.currency.currency.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">--}}
                        {{--<i class="fa fa-pencil"></i> {{ trans('currency::currencies.button.create currency') }}--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                 <?php
                    $defaultCurrency =  @setting('currency::default-currency');
                    $allowed_currencies = json_decode( @setting('currency::allowed-currencies') );
                    //dd( $allowdCurrencies );
                ?>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover" id="table">
                            <thead>
                            <tr>
                                <th>{{ trans('currency::currencies.title.currency from')  }}</th>
                                <th>{{ trans('currency::currencies.title.currency to')  }}</th>
                                <th>{{ trans('currency::currencies.title.currency rate')  }}</th>
                                <th>{{ trans('currency::currencies.title.currency symbol')  }} </th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($allowdCurrencies)): ?>
                            <?php foreach ($allowdCurrencies as $key=>$currency): ?>
                            <tr>
                                <td>{{ $defaultCurrency  }}</td>
                                <td>{{ $key }}</td>
                                <td class="rate"> {{   $currency['rate']  }} </td>
                                <td class="symbol">{{  $currency['symbol'] }}</td>
                                <td>{{ $currency['created_at'] }}</td>
                                <td>
                                    <button data-id="{{ $currency['id']  }}" data-currency="{{  $key  }}" class='edit-btn btn btn-sm btn-flat glyphicon glyphicon-edit' type='button'>编辑</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('currency::currencies.title.create currency') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.currency.currency.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {

            var table =  $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });

            $("#table tbody").on("click",".edit-btn",function(){
                var tds=$(this).parents("tr").children();
                $.each(tds, function(i,val){
                    var jqob=$(val);
                    if(i < 2 || i==4 ||  jqob.has('button').length ){return true;}//跳过第1项 序号,按钮
                    var txt=jqob.text();
                    var put=$("<input type='text'>");
                    put.val(txt);
                    jqob.html(put);
                });
                $(this).html("保存");
                $(this).toggleClass("edit-btn glyphicon-edit");
                $(this).toggleClass("save-btn glyphicon-ok");
            });

            $("#table tbody").on("click",".save-btn",function(){

                var row= ($(this).parents("tr"));
                var tds=$(this).parents("tr").children();

                var data = null;
                $.each(tds, function(i,val){
                    var jqob=$(val);
                    //把input变为字符串
                    if(!jqob.has('button').length){
                        var txt=jqob.children("input").val();
                        jqob.html(txt);
                        (jqob).data(txt);//修改DataTables对象的数据
                    }
                });

                $.ajax({
                    "url":  route('admin.currency.currency.update',{ currency : $(this).data('id')  }),
                    "data":{
                        currency:$(this).data('currency'),
                        rate: $(this).parents('tr').children('.rate').text(),
                        symbol: $(this).parents('tr').children('.symbol').text(),
                        _token:'{{csrf_token()}}',
                    },
                    "type":"post",
                    "error":function(){
                        alert("服务器未正常响应，请重试");
                    },
                    "success":function(response){
                        //alert(response);
                    }
                });
                $(this).html("编辑");
                $(this).toggleClass("edit-btn  glyphicon-edit");
                $(this).toggleClass("save-btn  glyphicon-ok");
            });
        });
    </script>
@endpush
