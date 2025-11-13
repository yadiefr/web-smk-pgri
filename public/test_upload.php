<?php
// Tampilkan informasi konfigurasi PHP yang relevan
echo '<h2>PHP Upload Configuration</h2>';
$settings = [
    'post_max_size',
    'upload_max_filesize',
    'memory_limit',
    'max_execution_time',
    'max_input_time',
    'max_file_uploads',
    'upload_tmp_dir',
    'file_uploads',
    'max_input_vars',
    'post_max_size (actual)' => ini_get('post_max_size'),
    'upload_max_filesize (actual)' => ini_get('upload_max_filesize'),
    'memory_limit (actual)' => ini_get('memory_limit'),
    'max_file_uploads (actual)' => ini_get('max_file_uploads'),
    'max_input_vars (actual)' => ini_get('max_input_vars'),
    'upload_tmp_dir (writable)' => is_writable(ini_get('upload_tmp_dir')) ? 'Yes' : 'No',
    'upload_tmp_dir (exists)' => file_exists(ini_get('upload_tmp_dir')) ? 'Yes' : 'No',
    'PHP_SELF' => $_SERVER['PHP_SELF'],
    'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE']
];

echo '<table border="1" cellpadding="5">';
foreach ($settings as $key => $value) {
    if (is_numeric($key)) {
        $key = $value;
        $value = ini_get($key);
    }
    echo "<tr><td><strong>$key</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
}
echo '</table>';

// Tampilkan form upload test
?>
<h2>Test Upload Form</h2>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="test_files[]" multiple>
    <input type="submit" value="Upload Files">
</form>

<?php
// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
    echo '<h3>Upload Results:</h3>';
    echo '<pre>';
    echo 'POST Content-Length: ' . $_SERVER['CONTENT_LENGTH'] . " bytes\n\n";
    
    foreach ($_FILES['test_files']['name'] as $key => $name) {
        if ($_FILES['test_files']['error'][$key] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['test_files']['tmp_name'][$key];
            $size = $_FILES['test_files']['size'][$key];
            echo "File: $name ($size bytes) - Uploaded successfully\n";
        } else {
            $error = $_FILES['test_files']['error'][$key];
            $error_msg = match($error) {
                UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
                default => 'Unknown upload error'
            };
            echo "File: $name - Error: $error_msg\n";
        }
    }
    echo '</pre>';
}
?>
