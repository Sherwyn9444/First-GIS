<html>
    <head>
    <script>
        $(document).ready(function(){
            
                $.post("table.php",{
                    searchbar: ""
                },function(data, status){
                    $("#prof-table").html(data);
                });
            $("#prof-btn-search").click(function(){
                var search_text = $('#prof-txt-search').val();
                $.post("table.php",{
                    searchbar: search_text
                },function(data, status){
                    $("#prof-table").html(data);
                });
            });
        });
    </script>
    </head>
    <body>
        <div class="prof-search">
            <input id="prof-txt-search" type="text" placeholder="Search">
            <button id="prof-btn-search">Search</button>
        </div>
        <table id="prof-table">

        </table>
        
    </body>
</html>