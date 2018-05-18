<div class="form-group">

    <label for="{{ $settingName }}">{{ trans($moduleInfo['description']) }}</label>

    <select multiple class="allowed-currencies" name="{{ $settingName }}[]" id="{{ $settingName }}">
        @foreach ($defaultCurrencyList as $id => $item)
            <option value="{{ $item->code  }}" {{ isset($dbSettings[$settingName]) && isset(array_flip(json_decode($dbSettings[$settingName]->plainValue))[$item->code]) ? 'selected' : '' }}> {{$item->code}} - {{ $item->d_name }} </option>
        @endforeach
    </select>
</div>
<script>
    $( document ).ready(function() {
        $('.allowed-currencies').selectize({
            delimiter: ',',
            plugins: ['remove_button']
        });
    });
</script>
