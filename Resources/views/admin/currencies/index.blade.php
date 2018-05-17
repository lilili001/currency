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
                ?>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('currency::currencies.title.currency from')  }}</th>
                                <th>{{ trans('currency::currencies.title.currency to')  }}</th>
                                <th>{{ trans('currency::currencies.title.currency rate')  }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($allowed_currencies)): ?>
                            <?php foreach ($allowed_currencies as $currency): ?>
                            <tr>
                                <td>{{ $defaultCurrency  }}</td>
                                <td>{{ $currency }}</td>
                                <td> {{  ((array) $rateList[ $currency ])['rate']  }} </td>
                                <td>
                                    {{  ((array) $rateList[ $currency ])['created_at']   }}
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
            $('.data-table').dataTable({
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
        });
    </script>
@endpush
