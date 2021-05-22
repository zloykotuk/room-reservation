<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Reservation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<form id="f" action="{{$isEdit ? route('api.reservation.update', ['id' => $reservation->id]) : route('api.reservation.store')}}" method="POST" style="padding:20px;">
    @csrf
    <h1>New Reservation</h1>
    <div>Name: </div>
    <div><input type="text" id="name" name="name" value="{{$name}}"/></div>
    <div>Start:</div>
    <div><input type="text" id="start" name="start" value="{{$start}}" /></div>
    <div>End:</div>
    <div><input type="text" id="end" name="end" value="{{$end}}" /></div>
    <div>Room:</div>
    <div>
        <select id="room" name="room_id">
            @foreach($rooms as $room)
                <option value="{{$room->id}}" {{$resource == $room->id ? 'selected' : ''}}>
                    {{$room->name}}
                </option>
            @endforeach
        </select>
    </div>
    @if($isEdit)
        <div>Status:</div>
        <div>
            <select id="status" name="status">
                @foreach(\App\Services\Reservation\ReservationStatusConstans::STATUSES as $status)
                    <option value="{{$status}}" {{$reservation->status === $status ? 'selected' : ''}}>{{$status}}</option>
                @endforeach
            </select>
        </div>
        <div>Paid:</div>
        <div>
            <select id="paid" name="paid">
                @foreach([0, 50, 100] as $option)
                    <option value="{{$option}}" {{$reservation->paid == $option ? 'selected' : ''}}>{{$option.'%'}}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="space"><input type="submit" value="Save" /> <a href="javascript:close();">Cancel</a></div>
</form>
<script type="text/javascript">
    function close(result) {
        if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
            parent.DayPilot.ModalStatic.close(result);
        }
    }

    $("#f").submit(function () {
        var f = $("#f");
        $.post(f.attr("action"), f.serialize(), function (result) {
            close(eval(result));
        });
        return false;
    });

    $(document).ready(function () {
        $("#name").focus();
    });

</script>
</body>
</html>
