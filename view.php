<html>
    <head>
    <script>
        $(document).ready(function(){
            
                $.post("table.php",{
                    searchbar: ""
                },function(data, status){
                    $("#view-table").html(data);
                });
            $("#view-btn-search").click(function(){
                var search_text = $('#view-txt-search').val();
                $.post("table.php",{
                    searchbar: search_text
                },function(data, status){
                    $("#view-table").html(data);
                });
            });
        });
    </script>
    <style>
        #view-main{
            margin-top: 5px;
        }
        #view-table{
            width:100%;
            background-color: grey;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #view-table td{
            width: 100px;
            height:25px;
        }
    </style>
    </head>
    <body>
        <div id="view-main">
            <div class="view-search">
                <input id="view-txt-search" type="text" placeholder="Search">
                <button id="view-btn-search">Search</button>
            </div>
            <table id="view-table">

            </table>
        </div>
    </body>
</html>