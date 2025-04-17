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


function productAdminRole()
{
    return session()->get('role') === 'productAdmin';
}

function petugasRole()
{
    return session()->get('role') === 'petugas';
}

function userAdminRole()
{
    return session()->get('role') === 'userAdmin';
}
