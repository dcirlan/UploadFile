<?php

if(!empty($_FILES['files']['name'][0])) {
    
    $files = $_FILES['files'];

    $uploaded = array();
    $failed = array();

    $allowed = array('jpg', 'png', 'gif');

    foreach($files['name'] as $position => $file_name) {
        
        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];

        $file_ext = explode('.', $file_name);
        $final_file_ext = strtolower(end($file_ext));

        if(in_array($final_file_ext, $allowed)) {
            if($file-error === 0) {
                if($file_size <= 1000000) {
                    $file_name_new = uniqid('', true) . '.' . $final_file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if(move_uploaded_file($file_tmp, $file_destination)) {
                        $uploaded[$position] = $file_destination;
                    } else {
                        $failed[$position] = "[{$file_name}] failed to upload.";
                    }
                } else {
                    $failed[$position] = "[{$file_name}] is too large.";
                }
            } else {
                $failed[$position] = "[{$file_name}] failed to upload because of code : {$file_error}.";
            }
        } else {
            $failed[$position] = "[{$file_name}] file extension '{$final_file_ext}' is not allowed.";
        }

        /*if(!empty($uploaded)) {
            var_dump($uploaded);
        }

        if(!empty($failed)) {
            var_dump($failed);
        }*/
    }
}

$it = new FilesystemIterator(uploads);
foreach($it as $fileinfo) {

    echo '<li>
    
        <figure>
        
            <img src="uploads/' . $fileinfo->getFilename() . ' " style="height: 100px; width: auto;">
            <figcaption>uploaded' . $fileinfo->getFilename() . '</figcaption>
        </figure>
    
    </li>';

}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Upload challenge</title>
</head>
<body>

    <form action="" method="POST" enctype="multipart/form-data">

        <label for="file">Upload your file</label>
        <input type="file" id="file" name="files[]" multiple></br>
        <button type="submit" name="submit">Upload</button>

    </form>

</body>
</html>