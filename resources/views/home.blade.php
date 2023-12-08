<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap-4.0.0/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-4.0.0/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        .left-bar {
            /* background: grey; */
            color: white;
        }

        .right-bar {
            background: rgb(255, 226, 226);
        }

        .left-bar-header {
            background: #202124;
            margin-left: 15px;
        }

        .search-bar-div {
            background: #202124;
            top: 0;
            left: 0;
            height: 45px;
            z-index: 999;
            transition: all .4s ease-in;
            transform: translateY(-50px);
        }

        .search-users {
            outline: none;
            color: white;
            border: 1px solid white;
            width: 96%;
            margin-top: 7px;
            padding: 7px 44px 7px 14px;
            border-radius: 20px;
        }

        .search-inside-input {
            right: 8px;
            top: 0px;
            height: 100%;
            padding-top: 14px;
        }

        .chats-heading {
            font-family: var(--primary-heading);
        }

        .users-dp {
            width: 79%;
            border-radius: 50%;
            height: 100%;
            margin: auto;
            display: block;
        }

        .indivisual-user {
            padding: 10px 0px 10px 0px;
            cursor: pointer;
            transition: .4s ease-in;
        }

        .indivisual-user:hover {
            padding: 10px 0px 10px 0px;
            background: #28292d;
        }

        .separtor {
            height: .1rem;
            display: block;
            margin: auto;
            background: linear-gradient(to right, #202124, #5b5b5b, #202124);
        }

        .user-name,
        ..message-details {
            font-family: 'Josefin Sans', sans-serif;
        }

        .message-details {
            font-size: 14px;
            font-family: 'Josefin Sans', sans-serif;
        }

        .status-unread {
            width: 12px;
            margin-top: -5px;
        }

        .status-read {
            width: 15px;
            margin-top: -5px;
        }

        .users-list {
            height: 85vh;
            overflow: hidden;
            transform: translateX(-5px);
        }

        .users-list .col-12 {
            padding-right: 1px;
        }

        .inner-user-list {
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #394053 #4f5055;
            height: 90%;
        }

        /* WebKit scrollbar styles */
        .inner-user-list::-webkit-scrollbar {
            width: 8px;
        }

        .inner-user-list::-webkit-scrollbar-thumb {
            background-color: #394053;
        }

        .inner-user-list::-webkit-scrollbar-track {
            background-color: #4f5055;
        }

        .hover:hover {
            background: #47484d;
        }

        .manage-user .active {
            background: #47484d;
        }

        .requests-lists {
            position: absolute;
            top: 0;
            right: 0;
            background: linear-gradient(to top, #202124, #303337, #202124);
            transform: translateX(100%);
            z-index: 999;
        }

        .requests-lists,
        .add {
            transition: all .5s ease-in;
        }

        .added-lists {
            transition: all .5s ease-in;
        }

        .requests-lists .separtor {
            background: linear-gradient(to right, #232428, #5b5b5b, #222326);
        }

        /* .users-area .row .row .user-details-div,
        .users-area .row .row .user-image-div {
            padding-left: 7px !important;
        } */
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="container-flued">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 left-bar inside-container">
                    <div class="row">
                        <div class="left-bar-header p-2 w-100 position-relative">
                            <div class="col-12 position-absolute search-bar-div">
                                <div class="w-100 position-relative">
                                    <input type="text" value="" name="search-users" class="search-users"
                                        placeholder="search">
                                    <i
                                        class="fa-solid fa-magnifying-glass cursor-pointer m-1 px-3 color-white position-absolute search-inside-input">
                                    </i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p>Real Chat</p>
                                </div>
                                <div class="col-8 d-flex justify-content-end">
                                    <a href="#search" id="search-user">
                                        <i class="fa-solid fa-magnifying-glass cursor-pointer m-1 px-3 color-white"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row users-area pt-3">
                                <div class="col-12">
                                    <p class="chats-heading"><i class="fa-solid fa-comments"></i> Chats</p>
                                    <div class="row mt-2 mb-2 cursor-pointer manage-user">
                                        <div class="col-6 text-center added hover transition active" id="added-btn">
                                            Added</div>
                                        <div class="col-6 text-center req hover transition" id="requests-btn">Request(1)
                                        </div>
                                    </div>

                                    <div class="row users-list position-relative">
                                        <div class="inner-user-list added-lists">
                                            <div class="col-12">

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>



                                            </div>
                                        </div>

                                        <div class="inner-user-list requests-lists">
                                            <div class="col-12">

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>

                                                <div class="row indivisual-user">
                                                    <div class="user-image-div col-3">
                                                        <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                            alt="Lorem Ipsum" class="users-dp">
                                                    </div>
                                                    <div class="user-details-div col-9">
                                                        <p class="m-0 user-name">Lorem Ipsum</p>
                                                        <p class="m-0 message-details">
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick.png') }}"
                                                                alt="tick" class="status-unread"> Hello, Dummy
                                                            User
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="separtor"></span>




                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-9 right-bar">

                    <div class="row">
                        <div class="col-4 m-auto bg-success w-50 pt-5">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            let isOpenSearchDiv = false;
            // search bar function
            $('#search-user').on('click', function() {
                openSearch();
            });

            window.addEventListener('popstate', function(event) {
                if (isOpenSearchDiv) {
                    closeSearch();
                }
            });


            // ---------------- Functions Area

            // Seacrh Bar Div

            function openSearch() {
                $('.search-bar-div').css('transform', 'translateY(-0px)');
                $('input[name="search-users"]').val('');
                $('input[name="search-users"]').focus();
                setTimeout(() => {
                    isOpenSearchDiv = true;
                }, 400);
            }

            function closeSearch() {
                $('.search-bar-div').css('transform', 'translateY(-50px)');
                setTimeout(() => {
                    isOpenSearchDiv = false;
                }, 400);
            }

            $(document).on('click', '.right-bar, .users-area', function() {
                if (isOpenSearchDiv) {
                    closeSearch();
                }
            });

            $('#requests-btn').on('click', function() {
                $('.requests-lists').css('transform', 'translateX(0%)');
                $('.added-lists').css('transform', 'translateX(-100%)');
                $('#requests-btn').addClass('active');
                $('#added-btn').removeClass('active');
            });

            $('#added-btn').on('click', function() {
                $('.requests-lists').css('transform', 'translateX(100%)');
                $('.added-lists').css('transform', 'translateX(0%)');
                $('#requests-btn').removeClass('active');
                $('#added-btn').addClass('active');
            });




        });
    </script>
</body>

</html>
