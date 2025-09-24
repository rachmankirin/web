<?php
session_start();

if (!isset($_SESSION['biodata_list'])) {
    $_SESSION['biodata_list'] = [];
}

// Function to add biodata to session storage
function add_biodata($data) {
    $_SESSION['biodata_list'][] = $data;
}

// Function to get all biodata
function get_all_biodata() {
    return $_SESSION['biodata_list'];
}

// Function to search biodata by keyword in name, nim, or prodi
function search_biodata($keyword) {
    $keyword = strtolower($keyword);
    $results = [];

    foreach ($_SESSION['biodata_list'] as $biodata) {
        if (
            strpos(strtolower($biodata['nama']), $keyword) !== false ||
            strpos(strtolower($biodata['nim']), $keyword) !== false ||
            strpos(strtolower($biodata['prodi']), $keyword) !== false
        ) {
            $results[] = $biodata;
        }
    }

    return $results;
}
