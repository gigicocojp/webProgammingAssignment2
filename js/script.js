function uploadFile() {
    var form = new FormData();
    form.append('file', document.querySelector('#imageFile').files[0]);// files[0] is the first upload file
    console.log(document.querySelector('#imageFile').files[0]);
    form.append('upload', true);
    var upload = new XMLHttpRequest();
    upload.open('POST', 'upload.php');
    upload.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText != 0) {
                document.querySelector('#uploadError').innerText = "Image uploaded successfully.";
                document.querySelector('#img_show').setAttribute("src",this.responseText);
                document.querySelector('#img_path').value =this.responseText;
            } else {
                document.querySelector('#uploadError').innerText = "An error occoured when uploading the image";
            }
        }
    };
    upload.send(form);
}