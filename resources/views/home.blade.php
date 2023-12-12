<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap-4.0.0/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-4.0.0/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    {{-- Include EmojiPicker CSS and JS --}}
    {{-- <link rel="stylesheet" href="/path/to/emoji-picker.css">
    <script src="/path/to/emoji-picker.js"></script> --}}
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css" />

    <style>
        .conversation-chats-container {
            width: 100%;
            height: 97vh;
            background: url('{{ asset('assets/images/bg/dark-travel.jpeg') }}') no-repeat center/cover;
        }

        .small-right-bar {
            /* display: none; */
        }

        .emoji-btn {
            top: 19px;
            left: 15px;
            color: #464646c9;
            font-size: 19px;
            cursor: pointer;
        }

        .emoji-div {
            display: none;
            width: 93%;
            bottom: 97px;
            z-index: 999999;
            left: 11px;
            scrollbar-width: thin;
        }

        emoji-picker {
            width: 100%;
            --num-columns: 15;
            --emoji-size: 1.5rem;
            --background: #202124;
        }

        .picker {
            width: 100%;
        }

        @media (min-width: 420px) and (max-width: 767px) {
            .users-list {
                width: 100%;
                margin-left: 0px;
            }

            .users-list .inner-user-list {
                width: 100%;
            }

            .users-list .inner-user-list .col-12 .row {
                /* background: white; */
                max-height: 82px;
            }

            .users-list .inner-user-list .col-12 .row .users-dp {
                /* display: none; */
                max-width: 62px;
            }

            .users-list .inner-user-list .col-12 .row .user-image-div {
                /* display: none; */
                max-width: 120px;
            }
        }

        @media (min-width: 768px) {
            .user-image-div {
                padding: 0px;
                padding-left: 7px;
            }
        }

        @media (min-width: 992px) and (max-width: 1286px) {
            .send-msg-btn img {
                top: -16px;
                right: -10px;
                height: 126%;
                width: 129%;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            #type-message {
                width: 88%;
            }

            .send-msg-btn img {
                top: -15px;
                right: -19px;
                height: 135%;
                width: 135%;
            }

            .emoji-div {
                width: 88%;
            }

            emoji-picker {
                --num-columns: 8;
                --emoji-size: 1.5rem;
                --background: #202124;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="container-flued">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 left-bar inside-container" id="left-bar">
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
                                            <a class="tabs-a" href="/#added">
                                                <p class="margin-0">
                                                    Added
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-6 text-center req hover transition" id="requests-btn">
                                            <a class="tabs-a" href="/#request">
                                                <p class="margin-0">
                                                    Request(1)
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row users-list position-relative">
                                        <div class="inner-user-list added-lists" id="added-lists">

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
                                                            <img src="{{ asset('assets/images/dummy-imgs/tick-double.png') }}"
                                                                alt="tick" class="status-read"> Hello, Dummy
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
                                                                alt="tick" class="status-read"> Hello, Dummy
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
                                                                alt="tick" class="status-read"> Hello, Dummy
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




                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-9 right-bar" id="right-bar">

                    <div class="row">
                        <div class="col-12 m-auto conversation-container">
                            <div class="conversation-header">
                                <div class="conversation-inner-header d-flex w-100">

                                    <div class="left-conv-header d-flex">
                                        <div class="go-back-cont div-sameline">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </div>
                                        <div class="conversation-person-details d-flex">
                                            <div class="conversation-user-img div-sameline">
                                                <img src="{{ asset('assets/images/dummy-imgs/35.jpg') }}"
                                                    alt="">
                                            </div>
                                            <div class="conversation-user-name">
                                                <p class="username">Lorem ipsum doller si</p>
                                                <p class="current-status">Typing...</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="right-conv-header">
                                        <div class="more-options position-relative">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                            <ul class="options position-absolute" id="options-conversation">
                                                <li>View Profile</li>
                                                <li>Wallpaper</li>
                                                <li>Block</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="conversation-chats-container position-relative">
                                <div class="position-absolute emoji-div">

                                    <emoji-picker for="type-message"></emoji-picker>
                                </div>
                                <div class="chats" id="chats">


                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem Ipsum Doller si
                                            </p>
                                        </div>
                                        <div class="message-time">12:50</div>
                                    </div>

                                    <div class="conversation-time">
                                        <p>Today</p>
                                    </div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
                                                reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
                                                atque
                                                quod labore voluptates asperiores commodi qui quibusdam alias, amet
                                                exercitationem. Dolores.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="spacer-10"></div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
                                                reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
                                                atque
                                                quod labore voluptates asperiores commodi qui quibusdam alias, amet
                                                exercitationem. Dolores.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p id="long-p">
                                                Lorem ipsum dolor sit amet.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, illo
                                                obcaecati cum doloribus debitis error.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="spacer-10"></div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam dolorum
                                                aperiam sapiente?
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="conversation-time">
                                        <p>12th Dec, 2023</p>
                                    </div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure voluptatem
                                                adipisci fuga numquam sed ut nam tempora iste dicta a ad ipsum fugiat,
                                                soluta unde eos debitis aut cupiditate. Corrupti.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>


                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem Ipsum Doller si
                                            </p>
                                        </div>
                                        <div class="message-time">12:50</div>
                                    </div>

                                    <div class="conversation-time">
                                        <p>Today</p>
                                    </div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
                                                reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
                                                atque
                                                quod labore voluptates asperiores commodi qui quibusdam alias, amet
                                                exercitationem. Dolores.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="spacer-10"></div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, dicta
                                                reprehenderit delectus accusamus reiciendis vero sint dolorum impedit
                                                atque
                                                quod labore voluptates asperiores commodi qui quibusdam alias, amet
                                                exercitationem. Dolores.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p id="long-p">
                                                Lorem ipsum dolor sit amet.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="parent-conv sender">
                                        <div class="conversations-sender conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, illo
                                                obcaecati cum doloribus debitis error.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="spacer-10"></div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam dolorum
                                                aperiam sapiente?
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>

                                    <div class="conversation-time">
                                        <p>12th Dec, 2023</p>
                                    </div>

                                    <div class="parent-conv reciever">
                                        <div class="conversations-reciever conversations">
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure voluptatem
                                                adipisci fuga numquam sed ut nam tempora iste dicta a ad ipsum fugiat,
                                                soluta unde eos debitis aut cupiditate. Corrupti.
                                            </p>
                                        </div>
                                        <div class="message-time">19:06</div>
                                    </div>


                                </div>
                                <div class="typing-area position-absolute">

                                    <div class="position-absolute emoji-btn">
                                        <i class="fas fa-smile"></i>
                                    </div>

                                    <form action="{{ route('send-msg') }}" id="send-msg" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <textarea name="type_message" id="type-message" placeholder="Type your message"></textarea>
                                    </form>
                                    <div class="send-msg-btn">
                                        <img src="{{ asset('assets/images/dummy-imgs/send.png') }}" alt="send"
                                            class="cursor-pointer" id="send-the-msg">
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        @if (session('welcome'))
            Swal.fire({
                title: 'Mubarakho!',
                text: '{{ session('welcome') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            //------------scroll to bottom 
            var chatsSec = $('#chats');
            chatsSec.css('scroll-behavior', 'auto');

            function scrollToBottom() {
                chatsSec.scrollTop(chatsSec.prop('scrollHeight'));
            }

            scrollToBottom();

            chatsSec.css('scroll-behavior', 'smooth');
            //------------scroll to bottom 



            let addReq = 'add';
            let isOpenSearchDiv = false;
            let moreConv = false;
            // search bar function
            $('#search-user').on('click', function() {
                openSearch();
            });

            window.addEventListener('popstate', function(event) {
                if (isOpenSearchDiv) {
                    closeSearch();
                    $('#requests-btn').click();
                }
            });


            // ---------------- Functions Area

            // Seacrh Bar Div

            function openSearch() {
                $('.search-bar-div').css('display', 'block');
                setTimeout(() => {
                    $('.search-bar-div').css('transform', 'translateY(-0px)');
                }, 10);

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
                    $('.search-bar-div').css('display', 'none');
                }, 400);
            }

            function addReqButton() {
                if (addReq == 'add') {
                    $('#requests-btn').click();
                } else {
                    $('#added-btn').click();
                }
            }

            $(document).on('click', '.right-bar, .users-area', function() {
                if (isOpenSearchDiv) {
                    closeSearch();
                }
            });

            $('#requests-btn').on('click', function() {
                addReq = 'req';
                $('.requests-lists').css('transform', 'translateX(0%)');
                $('.added-lists').css('transform', 'translateX(-100%)');
                $('#requests-btn').addClass('active');
                $('#added-btn').removeClass('active');
            });

            $('#added-btn').on('click', function() {
                addReq = 'add';
                $('.requests-lists').css('transform', 'translateX(100%)');
                $('.added-lists').css('transform', 'translateX(0%)');
                $('#requests-btn').removeClass('active');
                $('#added-btn').addClass('active');
            });

            //-----------more option conversation
            $('#options-conversation').removeClass('active');
            $('.more-options').on('click', function() {
                if (!moreConv) {
                    moreConv = true;
                    $('#options-conversation').addClass('active');
                } else {
                    moreConv = false;
                    $('#options-conversation').removeClass('active');
                }
            });

            $(document).on('click', '.left-bar-header, .conversation-chats-container', function() {
                if (moreConv) {
                    closeMoreOptionConversation();
                }
            });

            function closeMoreOptionConversation() {
                moreConv = false;
                $('#options-conversation').removeClass('active');
            }

            //-----------more option 


            //---show hide time 

            $('.parent-conv').on('click', function() {
                var messageTime = $(this).find('.message-time');
                if (messageTime.css('display') == 'none') {
                    messageTime.css('display', 'block');
                } else {
                    messageTime.css('display', 'none');
                }
            });

            //--------show hide time

            //-----type 
            let textarea = $('#type-message');

            // Update textarea height on input change
            textarea.on('input', function() {
                resizeTextarea();
            });

            // Initial resize
            resizeTextarea();

            function resizeTextarea() {
                // Set textarea height to auto to get the actual scroll height
                textarea.height('auto');

                // Set the textarea height to its scroll height if it's less than the max height, otherwise set it to the max height
                textarea.height(Math.min(textarea[0].scrollHeight, parseInt(textarea.css('max-height'))));
            }
            //-------type

        });

        //-------window size
        let smallScreenMediaQuery = window.matchMedia('(max-width: 767px)');
        let chatsLists = document.getElementById('added-lists').querySelectorAll('.indivisual-user');

        function handleScreenSizeChange() {
            if (smallScreenMediaQuery.matches) {
                console.log('less than 767px');
                chatsLists.forEach(element => {
                    element.classList.add('small-screen-added-lists');
                });
                document.getElementById('right-bar').classList.add('small-right-bar');
                document.getElementById('left-bar').classList.add('small-left-bar');
            } else {
                console.log('not less than 767px');
                chatsLists.forEach(element => {
                    element.classList.remove('small-screen-added-lists');
                });
                document.getElementById('right-bar').classList.remove('small-right-bar');
                document.getElementById('left-bar').classList.remove('small-left-bar');
            }
        }

        handleScreenSizeChange();
        smallScreenMediaQuery.addListener(handleScreenSizeChange);
        //-------window size


        $(document).on('click', '.small-screen-added-lists', function() {
            $('#type-message').focus();
            $('.small-left-bar').css('transform', 'translateX(-100%)');
        });
        let emojiDivShown = false;
        $('.emoji-btn').on('click', function() {
            $('#type-message').focus();
            if (!emojiDivShown) {
                emojiDivShown = true;
                $('.emoji-div').css('display', 'block');
            } else {
                emojiDivShown = false;
                $('.emoji-div').css('display', 'none');
            }
        });

        $(document).on('click', '#chats, .send-msg-btn img', emojiDivClose);

        function emojiDivClose() {
            $('#type-message').focus();
            if (emojiDivShown) {
                emojiDivShown = false;
                $('.emoji-div').css('display', 'none');
            }
        }


        $('#send-the-msg').on('click', function() {
            $('#send-msg').submit();
        });
    </script>

    <script type="module">
        document.addEventListener('emoji-click', (event) => {
            const textarea = document.getElementById('type-message');
            const emoji = event.detail.unicode;
            insertAtCursor(textarea, emoji);
            textarea.focus();
        });



        function insertAtCursor(textarea, value) {
            const cursorPos = textarea.selectionStart;
            textarea.value =
                textarea.value.substring(0, cursorPos) +
                value +
                textarea.value.substring(cursorPos);
            textarea.setSelectionRange(cursorPos + value.length, cursorPos + value.length);
            textarea.dispatchEvent(new Event('input'));
        }
    </script>

</body>

</html>
