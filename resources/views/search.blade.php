<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="searchForm">
        @csrf
        <input type="text" name="query" placeholder="Enter your query">
        <button type="submit">Search</button>
        <div id="results">
            <div id="hadithNumber">

            </div>
            <div id="bookNumber">

            </div>
            <div id="bookHadith">

            </div>
            <div id="textResult">

            </div>
        </div>

    </form>

</body>
</html>
<script src="{{ asset('jquery.js') }}"></script>
<script>
    $(document).ready(function(){

    let searchRoute  = "{{ route('hadith.search') }}" ;
    let formSearch   = $('#searchForm');

    $(formSearch).submit(function(e)
    {
        e.preventDefault();
        $.ajax({
            url : searchRoute ,
            type : "post" ,
            data : formSearch.serialize() ,
            success:function(data)
            {
                $('#hadithNumber').html(`
                    <b> Hadith Number : </b> ${data.hadithnumber}<br>
                `);
                $('#bookNumber').html(`
                    <b> Book Number : </b> ${data.book} <br>
                `);
                $('#bookHadith').html(`
                    <b> Hadith Number in Book : </b> ${data.hadith}<br>
                `);
                $('#textResult').html(`
                    <b> Hadith Text : </b> <p>${data.text}</p>
                `);

            }
        })
    });



    });
</script>
