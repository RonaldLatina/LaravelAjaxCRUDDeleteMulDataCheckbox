<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Laravel 10 Delete Multiple Data using Checkbox | Jquery Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-info">
                <p>{{ $message }}</p>
            </div>
        @endif
        <h2 class="mb-4">Laravel 10 Delete Multiple Data using Checkbox | Jquery Ajax</h2>
        <button class="btn btn-primary btn-xs removeAll mb-3">Remove All Selected Data</button>
        <table class="table table-bordered">
            <tr>
                <th><input type="checkbox" id="checkboxesMain"></th>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            @if ($users->count())
                @foreach ($users as $key => $rs)
                    <tr id="tr_{{ $rs->id }}">
                        <td><input type="checkbox" class="checkbox" data-id="{{ $rs->id }}"></td>
                        <td>{{ ++$key }}</td>
                        <td>{{ $rs->name }}</td>
                        <td>{{ $rs->email }}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkboxesMain').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });
            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#checkboxesMain').prop('checked', true);
                } else {
                    $('#checkboxesMain').prop('checked', false);
                }
            });
            $('.removeAll').on('click', function(e) {
                var userIdArr = [];
                $(".checkbox:checked").each(function() {
                    userIdArr.push($(this).attr('data-id'));
                });
                if (userIdArr.length <= 0) {
                    alert("Choose min one item to remove.");
                } else {
                    if (confirm("Are you sure you want to delete")) {
                        var stuId = userIdArr.join(",");
                        $.ajax({
                            url: "{{ url('delete-all') }}",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + stuId,
                            success: function(data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Error occured.');
                                }
                            },
                            error: function(data) {
                                alert(data.responseText);
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
