<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files Uploader</title>
    <style>
    #file_upload_wrapper {
        width: 400px;
        margin: 100px auto;
    }
    .drag_drop {
        padding: 100px 0;
        border: 1px dashed #ddd;
        max-width: 250px;
        text-align: center;
        cursor:pointer;
    }
    .or {
        max-width: 250px;
        text-align: center;
        font-size: 25px;
        font-weight: 700;
        margin: 15px 0;
    }
    </style>
</head>
<body>
    <section id="file_upload_wrapper">
        <div id="file_info">
            <h2>File Info : </h2>
            <ol>
                <li>Every Single Files Size Must Be Below <b>5mb</b>.</li>
                <br>
                <li>Only <b>JPG, PNG, BMP, MP3, MP4 AND MKV</b> Files were allowed to upload.</li>
            </ol>
            <br>
        </div>
       <form method="POST" enctype="multipart/form-data">
            <div class="drag_drop"  ondragover="allowDrop(event)" ondrop="drop(event)" ondrag="drag(event)">
                Drag And Drop Files
            </div>
            <div class="or">Or</div>
            <input type="file" multiple id="files"  onchange='uploadHandler(event)'>
       </form>
        <h2 id="upload_info">Upload Info : </h2>
        
       <progress id="progressBar" value="0" max="100" style="width:270px"></progress>
       <h3 id="status"></h3>

    </section>


    <script>
        let progressHandler = (event) => {
            var percent = (event.loaded / event.total) * 100;
            document.getElementById('progressBar').value = Math.round(percent);
            document.getElementById('status').innerHTML = Math.round(percent) + "% uploaded... Please Wait";

        }

        let completeHandler = (event) =>{
            document.getElementById('status').innerHTML = event.target.responseText;
        }

       let uploadHandler = () => {
           event.preventDefault();
           var u_s = 0;
           var invalid_file_name = '';

           var formData = new FormData();
           var files = document.getElementById("files").files;
           for(var i = 0; i < files.length; i++){
               var size = files[i].size / 1048576;
               size = Math.round(size);
                if(size > 5){
                    u_s++;
                    if(u_s > 1){
                        invalid_file_name = invalid_file_name + ", " + files[i].name;
                    }else{
                        invalid_file_name = files[i].name;
                    }
                }else if(files[i].type == 'JPG' || 'PNG' || 'BMP' || 'MP3' || 'MP4' || 'MKV'){
                    formData.append('file_'+i, files[i]);
                }else{
                    u_s++;
                    if(u_s > 1){
                        invalid_file_name = invalid_file_name + ", " + files[i].name;
                    }else{
                        invalid_file_name = files[i].name;
                    }
                }
               
           }

           formData.append('madeBy', 'Rashed');

           if(u_s == 0){
                let ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.open("POST", "upload.php", true);
                ajax.send(formData);
           }else{
                console.log(invalid_file_name);
                document.getElementById('progressBar').value = 0;
                document.getElementById('status').innerHTML = `"${invalid_file_name}" - Is Unable To Upload.`;
           }
       }


       let allowDrop = (event) => {
        event.preventDefault();
       }

       let drag = (event) => {
        event.preventDefault();
       }

       let drop = (event) => {
            event.preventDefault();
            var u_s = 0;
            var invalid_file_name = '';

            let files = event.dataTransfer.files;

            let formData = new FormData();

            for(var i = 0; i < files.length; i++){
                var size = files[i].size / 1048576;
               size = Math.round(size);
                if(size > 5){
                    u_s++;
                    if(u_s > 1){
                        invalid_file_name = invalid_file_name + ", " + files[i].name;
                    }else{
                        invalid_file_name = files[i].name;
                    }
                }else if(files[i].type == 'JPG' || 'PNG' || 'BMP' || 'MP3' || 'MP4' || 'MKV'){
                    formData.append('file_'+i, files[i]);
                }else{
                    u_s++;

                    if(u_s > 1){
                        invalid_file_name = invalid_file_name + ", " + files[i].name;
                    }else{
                        invalid_file_name = files[i].name;
                    }
                }
            }

            formData.append('madeBy', 'Rashed');

            if(u_s == 0){
                let ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.open("POST", "upload.php", true);
                ajax.send(formData);
           }else{
                document.getElementById('progressBar').value = 0;
                document.getElementById('status').innerHTML = `"${invalid_file_name}" - Is Unable To Upload.`;
           }  
       }
       
    </script>
</body>
</html>