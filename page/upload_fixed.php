<?php
// Solution for preventing unsafe file upload:
// 1, file name: alphanumberic, limit length of name + encode with timestamp to ensure uniqueness
// 2, extension: whitelist
// 3, content file: use api
// 4, storage: limit max file size, config daily upload storage in server config 

function check_file_content($filename) {
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $type = finfo_file($finfo, $filename);
  $whitelist_mime = array('image/png' => 1, 'image/jpeg' => 2, 'image/gif' => 3);
  if (isset($type) && array_key_exists($type, $whitelist_mime)) {
    return true;
  } else {
    return false;
  }
}

if (isset($_POST["submit"])) {
  $target_dir = 'uploads/';
  $upload_err = '';
  $file = pathinfo($_FILES['fileToUpload']['name']);
  // call $file['filename'] and $file['extension'] to get filename and extension of uploaded file

  $whilelist_extension = array('png' => 1, 'jpg' => 2, 'jpeg' => 3, 'gif' => 4);
  // Check filename
  if (!preg_match("/^[a-zA-Z0-9]{1,20}\.[a-zA-Z0-9]{1,7}$/i", basename($_FILES['fileToUpload']['name']))) $upload_err = 'Invalid file name. Filename contain no more than 20 characters and only letters, numbers are allowed!';
  else if (!array_key_exists($file['extension'], $whilelist_extension)) $upload_err = 'Only png, jpg, jpeg, gif are allowed!';
  else if (!check_file_content($_FILES["fileToUpload"]["tmp_name"])) $upload_err = 'Malicious file content!';
  else if ($_FILES['fileToUpload']['size'] > 5000000) $upload_err = 'File size need to be no more than 5MB'; 

  if (empty($upload_err)) {
    // Add timestamp to filename
    $target_file = $target_dir . $file['filename'].'_'.time().'.'.$file['extension'];

    // Move file to desired upload folder
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "<p>Please check file at ".$target_file."</p>";
    }
    else {
      $upload_err = 'Something wrong. Please try again later...';
    }
  }
  
  if (!empty($upload_err)) echo "<p>$upload_err</p>";
}
?>

<h2>This is upload page!</h2>
<form class="form-inline" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="file">Choose file to upload</label>
    <input type="file" class="form-control" name="fileToUpload">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Upload</button>
</form>
