<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="div_nav print_none">


    <div class="div_header_nav flex-center">
        <div class="nav_orange flex-row flex-center">
            <p class="p_mall"><i class="fa-solid fa-phone"></i> +32 (0) 81 20 66 23 </p>
            <p class="p_mall"><i class="fa-solid fa-envelope"></i> info@neurolead.net </p>
        </div>
    </div>

    <div class="div_body_nav flex-row spaced-around">
        <div class="flex-row spaced-around div_computer flex-center">
            <a href="../home/welcome.php">
                <img src="../../assets/img/logo-neurolead.png" class="img_logo_nav" />
            </a>

            <div class="computer_none flex-row">
                <i onclick="viewHeaderPhone()" class="fa-solid fa-bars"></i>
            </div>

            <div class="div_header_size">
                <div class="flex-row div_p_nav phone_none spaced-around flex-end">
                    <p class="p_nav">
                        <a href="https://neurolead.net/"> Home </a>
                    </p>
                    <p class="p_nav">
                        <a href="https://neurolead.net/model/"> Model</a>
                    </p>
                    <p class="p_nav">
                        <a href="https://neurolead.net/areas-of-expertise/"> Our expertise </a>
                    </p>
                    <p class="p_nav">
                        <a href="https://neurolead.net/solutions/"> Our Solutions </a>
                    </p>
                    <p class="p_nav">
                        <a href="https://neurolead.net/news/"> News </a>
                    </p>
                    <p class="p_nav">
                        <a href="https://neurolead.net/about-us/"> About </a>
                    </p>
                    <p class="p_nav">
                        <a href="http://localhost/neurotest/views/home/welcome.php"> Passer le test </a>
                    </p>
                    <?php
                    if (isset($_SESSION['is_connected'])) {
                    ?>
                        <p class="p_nav">
                            <a href="http://localhost/neurotest/views/home/control.php"> Page admin </a>
                        </p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="relative header_phone">
    <div class="div_phone_header">
        <div class="flex-center flex-col div_header_for_phone">
            <p class="p_nav">
                <a href="https://neurolead.net/"> Home </a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> Model</a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> Our expertise </a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> Our Solutions </a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> News </a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> About </a>
            </p>
            <p class="p_nav">
                <a href="https://neurolead.net/"> Passer le test </a>
            </p>
        </div>
    </div>
</div>

<style media="print">
    .print_none{
        display: none;
    }

    #h1_finish_quest{
        margin-top: 24px;
    }
    </style>

<style>
    .div_header_nav {
        justify-content: start !important;
        background: #EF7E33;
        height: 35px;
        font-size: 10px;
        color: white;
        padding-left: 5%;
    }

    .p_mall {
        font-size: 13px;
        padding: 10px;
        font-weight: 700;
    }

    .nav_orange {
    
    }

    .div_phone_header {
        width: 95%;
        background-color: white;
        box-shadow: 0px 0px 3px #DFDFDF;
        padding: 15px;
        border-top: 2px solid blue;
        zoom: 1.7;
        position: fixed;
        z-index: 10;
    }

    .div_header_for_phone {
        width: 100%;

    }

    .header_phone {
        z-index: 10;
    }

    .div_nav {
        position: fixed;
        width: 100vw;
        top: 0;
        left: 0;
        z-index: 11;
    }

    .img_logo_nav {
        height: 44px;
        margin-left: 6%;
    }

    .div_body_nav {
        background: white;
        height: 34px;
        padding: 15px;
        box-shadow: 0px 0px 3px #DFDFDF;
    }

    .div_body {
        position: relative;
    }

    .p_nav>a {
        text-decoration: none;
        padding: 0px 15px;
        font-weight: 600;
        letter-spacing: 2px;
        font-size: 14px;
        color: #484848;
        font-family: 'lato', Arial, Helvetica, sans-serif;
    }

    .p_nav>a:hover {
        color: #DBDBDB;
    }
</style>

<script src="../assets/js/survey/result.js"></script>