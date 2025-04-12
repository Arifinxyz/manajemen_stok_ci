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


function adminRole()
{
    return session()->get('role') === 'admin';
}

function petugsaRole()
{
    return session()->get('role') === 'petugas';
}

function hrdRole()
{
    return session()->get('role') === 'hrd';
}
