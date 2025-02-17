<?php
// Path to the user manual file
$file = '_assets/manuals/user_manual.pdf'; // Adjust the path as needed

// Check if the file exists
if (file_exists($file)) {
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf'); // Adjust this if your file is not PDF
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    // Read the file and send it to the output buffer
    readfile($file);
    exit;
} else {
    // File doesn't exist, show error
    echo "Sorry, the file you're looking for does not exist.";
}
?>