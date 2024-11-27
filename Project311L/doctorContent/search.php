<!DOCTYPE html>
<html>

<head>
    <title>Live Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="text-center mt-5 mb-4">
            <h2>Search Patients 🔍</h2>
        </div>
        <input type="text" class="form-control" id="live_search" autocomplete="off"
            placeholder="Enter Patient's Name or Id...">
        <div id="searchresult"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#live_search").keyup(function() {
                var input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "liveSearch.php",
                        method: "POST",
                        data: {
                            input: input
                        },
                        success: function(data) {
                            $("#searchresult").html(data).css("display", "block");
                        }
                    });
                } else {
                    $("#searchresult").html("").css("display", "none");
                }
            });
        });
    </script>
</body>

</html>