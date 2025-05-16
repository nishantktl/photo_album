<?php 
include_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Album</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data" id="album-form">
            <input type="file" id="f_img" name="file_data">
            <button id="submit_btn">Upload</button>
        </form>
        <div id="err" style="display:none;"></div>
        <div id="msg" style="display:none;"></div>
        <div id="warning" style="display:none;"></div>
    </div>

    <div id="display-img" class="image-wrapper" style="display: none;">
        <div class="image-column" id="left-column"></div>
        <div class="image-column" id="right-column"></div>
    </div>
    
    <div id="pagination" style="display:none;">
        <button id="prev" disabled>Previous</button>
        <span id="current-page">Page 1</span>
        <button id="next">Next</button>
    </div>

</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="script.js"></script>
