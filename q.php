<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Example</title>

    <!-- Include Switchery CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/switchery@0.8.2/dist/switchery.min.css">

    <!-- Optional: Include jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

    <!-- Include Switchery JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/switchery@0.8.2/dist/switchery.min.js"></script>
</head>
<body>

    <form class="form-group">
        <input type="checkbox" class="js-switch" checked /> Checked
        
    </form>

    <!-- Initialize Switchery -->
    <script>
        // Make sure to execute this script after the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the switch
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { size: 'small' /*, other options */ });
        });
    </script>

</body>
</html>
