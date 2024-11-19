<label>{{trans('file.Receiver')}} *</label>
<select name="receiver_id" id="receiver_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select receiver...">
    @forelse($receivers as $receiver)
        <option value="{{ $receiver->id.'-'.$receiver->name }}">{{ $receiver->name }}</option>
    @empty
        <option value="">{{ trans('file.Not Found') }}</option>
    @endforelse
</select>
