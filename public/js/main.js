// Help func to make image preview for the upload page
const loadPreview = (input, id) => {
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
            $(id)
                .attr('src', e.target.result)
                .width("100%")
                .height("auto")
                .attr('style', "display : block");
        };
        reader.readAsDataURL(input.files[0]);
    }
}