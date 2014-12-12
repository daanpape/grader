<?php

/*
 * DPTechnics CMS
 * Database module
 * Author: Daan Pape
 * Date: 18-08-2014
 */

// Load required files
require_once('config.php');
require_once('database.php');

class FileUpload {

    public static function uploadFile() {
        // Check if files are present 
        if (isset($_FILES['files'])) {
            $dao = new FileDAO();
            $upload_errors = array();
            $image_data = array();

            // Upload all files
            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $errors = array();
                $file_name = $key . $_FILES['files']['name'][$key];
                $file_size = $_FILES['files']['size'][$key];
                $file_tmp = $_FILES['files']['tmp_name'][$key];
                $file_type = $_FILES['files']['type'][$key];

                // Check file size requirements
                if ($file_size > Config::$fileMaxSize * 1024) {
                    $errors[] = 'The file must be smaller than ' . (Config::$fileMaxSize / 1024.0) . 'Mb';
                }

                // Check file type requirements
                if (!in_array($file_type, Config::$fileImgSupport)) {
                    $errors[] = 'The file is not in the correct format';
                }

                if (empty($errors)) {
                    /* Place file on the server */
                    chdir(dirname(__FILE__));
                    $name = uniqid("img_", false) . '.' . strtolower(substr(strrchr($file_name, '.'), 1));
                    $upload_path = Config::$fileDestination . '/' . $name;
                    if (!move_uploaded_file($file_tmp, '../' . $upload_path))
                        $errors[] = 'An unidentified error occured, please try again later';
                    $imgid = $dao->putUpload($upload_path);
                    $image_info = array();
                    $image_info['link'] = '/' . $upload_path;
                    $image_info['id'] = $imgid;
                    $image_info['type'] = strtolower(substr(strrchr($file_name, '.'), 1));
                    $image_info['name'] = $name;
                    $size = getimagesize('../' . $upload_path);
                    $image_info['size'] = $size[0] . 'x' . $size[1];

                    $image_data[] = $image_info;
                } else {
                    /* An error occured */
                    $upload_errors[$file_name] = $errors;
                }
            }

            /* Process upload errors */
            $message = "";

            if (!empty($upload_errors)) {
                $message = 'The following errors occured:<ul>';
                foreach ($upload_errors as $key => $value) {
                    $message .= '<li>Errors on file "' . $key . '"<ul>';
                    foreach ($value as $error) {
                        $message .= '<li>' . $error . '</li>';
                    }
                    $message .= '</ul></li>';
                }
                $message .='</ul>';

                header("HTTP/1.0 412 Precondition Failed");
                echo $message;
            }

            return $image_data;
        } else {
            return "No files were selected";
        }
    }
}

?>