@isset($data)
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Ticket No.:</label>
        {{$data->ticket_no}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Added By:</label>
        {{$data->addedBy->name}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Updated By:</label>
        {{$data->updatedBy->name}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Date Updated:</label>
        {{$data->updated_at->toDayDateTimeString()}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Created At:</label>
        {{$data->created_at->toDayDateTimeString()}}
        </div>
    </div>
</div>
<hr>
@endisset

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Schedule*</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-clock"></i></span>
            </div>
            <input type="text" name="schedule" class="form-control float-right" id="scheduletime">
{{--            <div class="input-group-prepend">--}}
{{--                <button class="input-group-text input-group-text-clear" style="cursor: pointer" onclick="clear()"><i class="el-icon-circle-close"></i></button>--}}
{{--            </div>--}}
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
        <label>Message*</label>
        {!! Form::textarea('message', null, ['rows'=>'3', 'class'=>'form-control', 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Notification display Datetime </label>
        <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">event</i></span>
              </div>
              <input class="form-control" id="datetimepicker" type="text" name="notification_display_datetime" value="{{(isset($data->notification_display_datetime)) ? $data->notification_display_datetime : null}}" placeholder="Choose time">
            </div>
    {{--        <div class="form-group">--}}
    {{--        <label>Notification Message*</label>--}}
    {{--        {!! Form::textarea('notification_message', null, ['rows'=>'3', 'class'=>'form-control', 'required']) !!}--}}
    {{--        </div>--}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Notification Message*</label>
            {!! Form::textarea('notification_message', null, ['rows'=>'3', 'class'=>'form-control', 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                {!! Form::checkbox('is_active', 1, null, ['id' => 'is_active']) !!}
                <label class="form-check-label" for="is_active">Is Active</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                {!! Form::checkbox('auto_up_on_schedule_end', 1, null, ['id' => 'auto_up_on_schedule_end']) !!}
                <label class="form-check-label" for="auto_up_on_schedule_end">Auto Up on Schedule End</label>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(function() {
    let startDate = moment().startOf('hour');
    let endDate = moment().startOf('hour').add(32, 'hour');

    @isset($data)
        startDate = moment.parseZone('{{$data->schedule_start}}');
        endDate = moment.parseZone('{{$data->schedule_end}}');
    @endisset

    $('#scheduletime').daterangepicker({
        timePicker: true,
        startDate: startDate,
        endDate: endDate,
        locale: {
            format: 'llll'
        }
    });

   $('#datetimepicker').daterangepicker({
         singleDatePicker: true,
         timePicker: true,
         format: 'YYYY-MM-DD HH:mm',
         startDate: startDate,
         endDate: endDate,
         locale: {
           format: 'llll'
         }
   });

  //   $('#datetimepicker').bootstrapMaterialDatePicker({
  //   format: 'YYYY-MM-DD HH:mm',
  //   shortTime: false,
  //   date: true,
  //   time: true,
  //   monthPicker: false,
  //   year: true,
    clearButton: false,
    nowButton: false,
    switchOnClick: true,
  //   cancelText: 'Cancel',
  // });

})
// function clear() {
//   document.getElementById('scheduletime').value = '';
// }
{{--    window.name = "{{ $data->addedBy->name }}"--}}
</script>
@endpush
