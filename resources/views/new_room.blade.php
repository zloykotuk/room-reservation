<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<form id="f" action="{{route('api.room.store')}}" method="POST" style="padding:20px;">
    @csrf
    <h1>New Room</h1>
    <div>Name: </div>
    <div><input type="text" id="name" name="name" value/></div>
    <div>Capacity:</div>
    <div><input type="text" id="start" name="capacity" value/></div>
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
