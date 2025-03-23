<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    @yield('content')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        console.log('k');
        $('#state').on('change', function(){
          var stateId = $(this).val();

          if(stateId){
            $.ajax({
                type: 'GET',
                url: 'cities/' + stateId,
                dataType: 'json',
                success: function(data) {
                  $('#city').empty();
                  $('#city').append('<option value"">Select City</option>');
  
                  $.each(data, function(key, value){
                    $('#city').append('<option value="'+value.id+'">'+value.name+'</option>');
                  });
                } 
            });
          } else {
             console.log('AJAX load did not work');
             $('#city').empty().append('<option value="">Select a City</option>');
             
          }
        });
      });
    </script>
  </body>
</html>