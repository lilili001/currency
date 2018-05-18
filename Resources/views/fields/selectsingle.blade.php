<div class="form-group">

    <label for="{{ $settingName }}">{{ trans($moduleInfo['description']) }}</label>

    <select class="current-currency" name="{{ $settingName }}[]" id="{{ $settingName }}">
        @foreach ($defaultCurrencyList as $id => $item)
            <option value="{{ $item->code  }}"
                    {{--{{ isset($dbSettings[$settingName]) && isset(array_flip(json_decode($dbSettings[$settingName]->plainValue))[$item->code]) ? 'selected' : '' }}--}}
            <?php
                    $currentCurrency = setting('currency::current-currency');
                    $condition = isset($dbSettings[$settingName]) && isset(array_flip(json_decode($dbSettings[$settingName]->plainValue))[$item->code]);
                    echo $condition ? 'selected' : '' ;
                ?>
            > {{$item->code}} - {{ $item->d_name }} </option>
        @endforeach
    </select>
</div>
<script>
    $( document ).ready(function() {
        $('.current-currency').selectize({
            delimiter: ',',
            plugins: ['remove_button']
        });
    });
</script>
