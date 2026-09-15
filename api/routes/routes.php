<?php
$routes = [
 
    // AUTH ROUTES
    [
        "method" => "POST",
        "path" => "/auth/login",
        "controller" => "AuthController",
        "action" => "login"
    ],
    [
        "method" => "POST",
        "path" => "/auth/register",
        "controller" => "AuthController",
        "action" => "register"
    ],

    // [
    //     "method" => "GET",
    //     "path" => "/auth/status",
    //     "controller" => "AuthController",
    //     "action" => "status"
    // ],

    // [
    //     "method" => "POST",
    //     "path" => "/auth/logout",
    //     "controller" => "AuthController",
    //     "action" => "logout"
    // ],


    // // =========================
    // // USERS
    // // =========================

    // [
    //     "method" => "GET",
    //     "path" => "/users",
    //     "controller" => "UserController",
    //     "action" => "index"
    // ],

    // [
    //     "method" => "GET",
    //     "path" => "/users/{id}",
    //     "controller" => "UserController",
    //     "action" => "show"
    // ],

    // [
    //     "method" => "POST",
    //     "path" => "/users",
    //     "controller" => "UserController",
    //     "action" => "store"
    // ],

    // [
    //     "method" => "PUT",
    //     "path" => "/users/{id}",
    //     "controller" => "UserController",
    //     "action" => "update"
    // ],

    // [
    //     "method" => "DELETE",
    //     "path" => "/users/{id}",
    //     "controller" => "UserController",
    //     "action" => "destroy"
    // ],


    // // =========================
    // // DASHBOARD
    // // =========================

    // [
    //     "method" => "GET",
    //     "path" => "/dashboard",
    //     "controller" => "DashboardController",
    //     "action" => "index"
    // ],

    // [
    //     "method" => "GET",
    //     "path" => "/dashboard/stats",
    //     "controller" => "DashboardController",
    //     "action" => "stats"
    // ]

];
?>