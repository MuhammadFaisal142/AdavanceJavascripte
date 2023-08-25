<!DOCTYPE html>
<html>
<head>
    <title>Multiple Image Cropping</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Include Croppie CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
</head>
<body>

<div class="container">
    <div class="col-xs-12">
        <div id="image-container"></div>
        <button type="button" class="btn btn-primary" onclick="addImageField()">Add More</button>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Include Croppie JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    var imageCounter = 0;
    var $uploadCrop;

    function crop_image_model(imageId) {
        // Start upload preview image
        $(".img-thumbnail").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
        var tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    rawImg = e.target.result;
                    $uploadCrop.croppie('bind', {
                        url: rawImg
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                alert("Sorry - your browser doesn't support the FileReader API");
            }
        }

        $('#cropImagePop').modal('show');
        $('.item-img').off('change').on('change', function () {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });

        $('#cropImageBtn').off('click').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: { width: 150, height: 200 }
            }).then(function (resp) {
                $('#item-img-output_' + imageId).attr('src', resp);
                $('#cropImagePop').modal('hide');
            });
        });
        // End upload preview image
    }

    function addImageField() {
        imageCounter++;
        var newImageField = `
            <div class="col-xs-12">
                <label class="cabinet center-block">
                    <figure>
                        <img src="" class="img-thumbnail" id="item-img-output_${imageCounter}" onclick="crop_image_model(${imageCounter})" style="width: 150px; height: 200px; border: 1px solid #ccc; cursor: pointer;" />
                    </figure>
                    <input type="file" class="item-img file center-block" name="file_photo" data-id="${imageCounter}" />
                </label>
            </div>
        `;
        $('#image-container').append(newImageField);
    }

    // Initialize Croppie and modal on document ready
    $(document).ready(function () {
        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 150,
                height: 200,
            },
            enforceBoundary: false,
            enableExif: true
        });
    });
</script>

<!-- Create the crop image modal outside the main script to prevent duplicate modals -->
<div id="cropImagePop" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block" style="width: 250px; height: 250px; padding-bottom: 25px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
