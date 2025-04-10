<?php 
function isLoggedIn()
{
    return !empty(session()->get('name'));
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect()->to('/login')->send();
        exit;
    }
}
