<div class="picture-select picture-preview-simple d-inline-block picture-object">
    <input type="hidden" class="form-control" id="gallery_picture[]" name="gallery_picture[]"
           value="<?= isset($galleryItem['value']) ? $galleryItem['value'] : '' ?>">
    <div class="clearGallery">x</div>
    <div class="image-container">
        <img src="<?= isset($galleryItem['cache']) ? $galleryItem['cache'] : '' ?>">
    </div>
</div>

