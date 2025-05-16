$(document).ready(function(){

        

        let currentPage = 1;

        function fetchImages(page) {
            $.ajax({
                url: 'fetch_image.php',
                data: { page: page },
                dataType: 'json',
                method: 'GET',
                success: function (response) {
                    if (response.images.length > 0) {
                        setTimeout(function(){
                        $('#msg').html('').hide();
                        $('#warning').html('').hide();
                        $('#f_img').val('');
                        $('#pagination').show();
                        },3000);
                        

                        let leftHtml = '';
                        let rightHtml = '';

                        response.images.forEach((image, index) => {
                            let imgTag = `<img src="images/${image.filename}" alt="${image.filename}">`;
                            if (index < 3) leftHtml += imgTag;
                            else rightHtml += imgTag;
                        });

                        $('#left-column').html(leftHtml);
                        $('#right-column').html(rightHtml);
                        $('#display-img').show();

                        $('#current-page').text(response.page);
                        $('#prev').prop('disabled', response.page <= 1);
                        $('#next').prop('disabled', response.page >= response.totalPages);

                        currentPage = response.page;
                    } else {
                        $('#warning').html('<p>Image Not found. Please upload Image</p>').show();
                        $('#pagination').hide();
                    }
                },
                error: function () {
                    console.error('Failed to fetch images.');
                }
            });
        }


        fetchImages(currentPage);

        $('#next').click(function () {
            fetchImages(currentPage + 1);
        });

        $('#prev').click(function () {
            if (currentPage > 1) {
                fetchImages(currentPage - 1);
            }
        });


        $('#submit_btn').click(function(e){
            e.preventDefault();
            
            let img = $('#f_img').val();
            if(img == ''){
                let html = `<p>Please insert image while uploading</p>`;
                $('#err').html(html).show();
                $('#msg').html('').hide();
                $('#warning').html('').hide();
            } else {
                $('#err').html('').hide();
                
                let formData = new FormData($('#album-form')[0]);

                $.ajax({
                    url:'upload.php',
                    data: formData,
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    method:'POST',
                    success: function(response) {
                        if(response) {
                            let txt_color = (response.status == 'success') ? 'green' : 'red'; 
                            let html = `<p style="color:${txt_color}">${response.message}</p>`;
                            $('#msg').html(html).show();
                            $('#warning').html('').hide();
                            fetchImages(currentPage);
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

    })